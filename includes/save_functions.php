
<?php


    function writeSaveJson($handle, array $saves): void
    {
        $json = json_encode(
            $saves,
            JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR
        );

        // Write the JSON from the beginning of the file.
        rewind($handle);

        $length = strlen($json);
        $written = 0;

        // Continue writing until all bytes have been written.
        while ($written < $length) {
            $bytes = fwrite(
                $handle,
                substr($json, $written)
            );

            if ($bytes === false || $bytes === 0) {
                throw new RuntimeException(
                    "Unable to write player save."
                );
            }

            $written += $bytes;
        }

        // Remove any leftover bytes from older, longer JSON.
        if (!ftruncate($handle, $length)) {
            throw new RuntimeException(
                "Unable to truncate save storage."
            );
        }

        if (!fflush($handle)) {
            throw new RuntimeException(
                "Unable to flush save storage."
            );
        }
    }


    function loadPlayerSave(): ?array
    {
        if (!isset($_SESSION["user"])) {
            return null;
        }

        $file = __DIR__ . "/../storage/saves.json";

        if (!is_file($file)) {
            throw new RuntimeException("Save storage is missing.");
        }

        $handle = fopen($file, "rb");

        if ($handle === false) {
            throw new RuntimeException("Unable to open save storage.");
        }

        try {
            if (!flock($handle, LOCK_SH)) {
                throw new RuntimeException("Unable to lock save storage.");
            }

            $contents = stream_get_contents($handle);
            $saves = json_decode($contents, true);

            if (!is_array($saves)) {
                throw new RuntimeException("Save storage contains invalid JSON.");
            }

            $userId = (string) $_SESSION["user"];
            $save = $saves[$userId] ?? null;

            if ($save !== null && !is_array($save)) {
                throw new RuntimeException("Invalid player save.");
            }

            return $save;
        } finally {
            flock($handle, LOCK_UN);
            fclose($handle);
        }
    }


    function savePlayerProgress(array $progress): void
    {
        // Only authenticated users can save progress.
        if (!isset($_SESSION["user"])) {
            throw new RuntimeException("Player is not authenticated.");
        }

        $file = __DIR__ . "/../storage/saves.json";
        $userId = (string) $_SESSION["user"];

        // Open the file for reading and writing without erasing it.
        $handle = fopen($file, "c+b");

        if ($handle === false) {
            throw new RuntimeException("Unable to open save storage.");
        }

        try {
            // Prevent simultaneous writes.
            if (!flock($handle, LOCK_EX)) {
                throw new RuntimeException("Unable to lock save storage.");
            }

            rewind($handle);
            $contents = stream_get_contents($handle);

            // A new, empty file starts with no saves.
            $saves = ($contents === "")
                ? []
                : json_decode($contents, true);

            if (!is_array($saves)) {
                throw new RuntimeException("Save storage contains invalid JSON.");
            }

            // Update only the currently authenticated player's save.
            $saves[$userId] = $progress;

            writeSaveJson($handle, $saves);

        } finally {
            flock($handle, LOCK_UN);
            fclose($handle);
        }
    }


    function deletePlayerSave(): void
    {
        // Require an authenticated account.
        if (!isset($_SESSION["user"])) {
            throw new RuntimeException("Player is not authenticated.");
        }

        $file = __DIR__ . "/../storage/saves.json";
        $userId = (string) $_SESSION["user"];

        // Open without automatically erasing existing data.
        $handle = fopen($file, "c+b");

        if ($handle === false) {
            throw new RuntimeException("Unable to open save storage.");
        }

        try {
            // Prevent simultaneous modifications.
            if (!flock($handle, LOCK_EX)) {
                throw new RuntimeException("Unable to lock save storage.");
            }

            rewind($handle);
            $contents = stream_get_contents($handle);

            $saves = json_decode($contents, true);

            if (!is_array($saves)) {
                throw new RuntimeException("Save storage contains invalid JSON.");
            }

            // Delete only this player's save.
            if (!array_key_exists($userId, $saves)) {
                return;
            }

            unset($saves[$userId]);

            writeSaveJson($handle, $saves);

        } finally {
            flock($handle, LOCK_UN);
            fclose($handle);
        }
    }


    function collectPlayerProgress(): array
    {
        $keys = [
            "champion",
            "story_node",
            "story_flags",
            "story_progress",
            "inventory",
            "choices_log",
            "combat",
            "last_choice_summary"
        ];

        $progress = [];

        foreach ($keys as $key) {
            if (array_key_exists($key, $_SESSION)) {
                $progress[$key] = $_SESSION[$key];
            }
        }

        return $progress;
    }


    function restorePlayerProgress(array $progress): void
    {
        $keys = [
            "champion",
            "story_node",
            "story_flags",
            "inventory",
            "choices_log",
            "combat",
            "last_choice_summary"
        ];

        // Remove old game state before restoring a save.
        foreach ($keys as $key) {
            unset($_SESSION[$key]);
        }

        // Restore only recognized game-state fields.
        foreach ($keys as $key) {
            if (array_key_exists($key, $progress)) {
                $_SESSION[$key] = $progress[$key];
            }
        }
    }




?>