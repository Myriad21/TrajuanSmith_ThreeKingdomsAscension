# Three Kingdoms Ascension

**CSC 4370 — Web Development | Project 2: Choose Your Path**

A browser-based, choice-driven fantasy role-playing game built with **PHP, HTML, and CSS**. Players create a champion from one of three kingdoms—**Warrior, Mage, or Rogue**—and explore a branching story, fight turn-based battles, manage resources and relationships, and reach an ending determined by their decisions.

## Team and responsibilities

| Developer | Role | Primary contributions |
| --- | --- | --- |
| Trajuan Smith | Scrum Master | Character creation, game/story engine, combat, Insight Relic, session saves, endings, Hero Summary, and scoring integration |
| Hien Dao | Product Owner | Homepage, registration/login/logout interfaces, shared visual assets, and initial leaderboard |

Both contributors participated in integration, debugging, and documentation.

## Main features

- **Account access:** Registration, login, logout, and protected gameplay pages.
- **Champion creation:** Select a faction with different starting statistics and a character confirmation step.
- **Branching story:** Three acts with conditional choices, story flags, faction relationships, multiple endings, and a path tracker.
- **Turn-based combat:** Attacks, class abilities, healing items, equipment, and escape mechanics.
- **Character progression:** HP, Mana, Strength, Agility, level progression, inventory, and rewards.
- **Insight Relic:** Rule-based, contextual guidance for story choices, including consequence previews, relationship tiers, and explanations for locked choices.
- **Saved progress:** Server-side save/restore integration for returning players.
- **Hero Summary and leaderboard:** Adventure summary and score-based ranking from saved player records.

## Getting started locally

1. Install **PHP** with command-line support.
2. Download or clone the repository and open a terminal in the project directory.
3. Start the PHP development server:

   ```bash
   php -S localhost:8000
   ```

4. Open `CODD LINK TO BE ADDED` in your browser.
5. Register or sign in, create a champion, and start the adventure.

The application uses PHP sessions and JSON-based server-side storage rather than a database. Ensure the PHP process can access and write to the required files in `storage/`. Do not publish real user records or saved games to a public repository.

## Project structure

| Path | Purpose |
| --- | --- |
| `index.php` | Homepage |
| `register.php`, `login.php`, `logout.php` | Account pages |
| `character.php`, `character_confirm.php` | Champion setup |
| `game.php` | Narrative and player-choice interface |
| `combat.php` | Turn-based battle interface |
| `hero_summary.php` | End-of-adventure summary |
| `leaderboard.php` | Player ranking display |
| `includes/` | Shared PHP functions, story data, authentication, combat, saves, and scoring |
| `assets/` | CSS and visual assets |
| `storage/` | Server-side JSON data and saved progress |
| `Development_Journal.md` | Sprint history, decisions, debugging, and test record |

## Insight Relic: AI-style guidance feature

The Insight Relic is **not a generative AI model** and does not use an external AI API. It is a **PHP rule-based guidance system** that uses predefined story metadata and current player state to explain likely consequences. It advises players without selecting a path for them. It can display requirement shortfalls, relationship context, stat rewards, and fallback guidance when a choice does not need a special preview.

**Limitation:** Predictions are limited to encoded rules and story outcomes; the feature cannot infer consequences that developers have not defined.

## Manual AI feature testing — November 18, 2026

Tests were conducted in **Brave** using the local PHP server.

| ID | Scenario | Observed result | Status |
| --- | --- | --- | --- |
| AI-01 | Consequence preview: Launch a Surprise Attack | Insight Relic warned of damaged relationships; the selected choice produced a relationship-worsened notice and described the surprise advantage | **PASS** |
| AI-02 | Strength boundary: Destroy the Monument | Mage at 7/15 Strength was locked with an 8-point shortfall; Warrior at exactly 15 was allowed; absorbing the crystal increased Strength from 15 to 20 | **PASS** |
| AI-03 | Fallback guidance: Continue the Expedition | Confirmed fallback path displayed guidance that unexplored discoveries would be left behind, without visible errors or invented stat changes | **PASS** |

**Evidence files:** `assets/evidence/AI_Testcase1_TrustDecrease01.png`, `assets/evidence/AI_Testcase1_TrustDecrease02.png`, and `TestCase02_StatBoundary01.png` through `assets/evidence/TestCase02_StatBoundary06.png`. The AI-03 screenshot should also be retained with submission evidence. These are separate screenshots, not automatically included in the repository.

These are targeted manual UI tests, not a claim of exhaustive coverage. Additional final checks should include all factions and endings, login/logout save restoration, leaderboard ordering, protected-route behavior, responsive layout, and CODD deployment.

## Development process

The team used GitHub branches and pull requests and organized development into six short sprint groupings from **November 10–18, 2026**. See `Development_Journal.md` for the chronological work record, contributor attribution, debugging notes, commit evidence, and outstanding verification tasks.

## Repository

https://github.com/Myriad21/TrajuanSmith_ThreeKingdomsAscension

## AI assistance disclosure

ChatGPT was used to assist with planning, explanations, debugging suggestions, testing checklists, and documentation drafting. The gameplay guidance system itself is implemented with PHP rules, not an external model.
