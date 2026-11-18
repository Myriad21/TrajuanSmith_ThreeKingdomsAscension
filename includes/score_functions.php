
<?php

function calculateFinalScore(
    array $storyFlags,
    string $storyNode,
    int $championLevel
): int {

    $score = 0;

    $validEndings = [
        "act3_faction_victory",
        "act3_faction_defeat",
        "act3_secret_ending"
    ];


    // Three major decisions: 50 points each.
    if (
        !empty($storyFlags["act1_rival_cooperated"]) ||
        !empty($storyFlags["act1_rival_defeated"])
    ) {
        $score += 50;
    }

    // Award this only if the decision was actually recorded.
    if (
        array_key_exists(
            "act3_injured_cultivator_rescued",
            $storyFlags
        )
    ) {
        $score += 50;
    }

   // Award completion points only after reaching an ending.
    if (in_array($storyNode, $validEndings, true)) {
        $score += 50;
    }

    // Story achievements.
    if (!empty($storyFlags["act3_mana_beast_defeated"])) {
        $score += 150;
    }

    if (!empty($storyFlags["act3_injured_cultivator_rescued"])) {
        $score += 75;
    }

    if (!empty($storyFlags["act1_rival_cooperated"])) {
        $score += 75;
    }

    if (!empty($storyFlags["act2_zenith_path_completed"])) {
        $score += 100;
    }

    if (
        !empty($storyFlags["act2_first_zenith_absorbed"]) &&
        !empty($storyFlags["act2_second_zenith_absorbed"])
    ) {
        $score += 100;
    }

    // Champion progression.
    if ($championLevel >= 4) {
        $score += 50;
    }

    if ($championLevel >= 5) {
        $score += 100;
    }

    // Secret ending bonus.
    if ($storyNode === "act3_secret_ending") {
        $score += 200;
    }

    return $score;
}
