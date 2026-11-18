# Development Journal — Three Kingdoms Ascension

**Course:** CSC 4370 — Web Development  
**Project:** Project 2 — Choose Your Path (Three Kingdoms Ascension)  
**Team:** Trajuan Smith and Hien Dao  
**Repository:** https://github.com/Myriad21/TrajuanSmith_ThreeKingdomsAscension  
**Development period documented:** November 10–18, 2026

## Roles and workflow

- **Trajuan Smith — Scrum Master:** character creation, PHP story engine, combat, character statistics, Insight Relic, save integration, endings, Hero Summary, and game integration.
- **Hien Dao — Product Owner:** homepage, shared visual assets, registration/login/logout, authentication interface, and initial leaderboard implementation.
- **Shared responsibilities:** GitHub integration, resolving merge and asset issues, testing, documentation, and presentation preparation.

We used a GitHub repository and feature branches/pull requests to combine contributions. Trello was established to track planned tasks across six short sprints. The sprint labels below group related work for reporting; actual Trello card movements, meetings, and sprint reviews must be verified against the board rather than inferred from commits.

## Sprint 1 — November 10–11: Repository and environment setup

**Contributors:** Trajuan Smith and Hien Dao

### Work completed
- Created the repository and initialized the development journal.
- Verified the PHP command-line environment, local PHP server, and CODD access.
- Established the Trello board and assigned preliminary development responsibilities.
- Hien added starter project files.
- Trajuan adjusted shared CSS and created a temporary login placeholder to allow early navigation work before the real authentication system was integrated.

### Testing and evidence
- PHP CLI, repository access, local server, and CODD access were reported as working in the original journal.
- Initial homepage rendering and navigation were still pending confirmation at this stage.

### Issues and decisions
- Used a temporary login page as a development placeholder, not as the final authentication implementation.
- The original journal recorded instructor proposal approval as pending at this stage; later approval status is not established by the commit history.

### Selected commits
- `f4c22ae` — Trajuan: first commit (Nov. 10)
- `bb394a5` — Trajuan: initialize Sprint 1 development journal (Nov. 10)
- `0415b37` — Hien: add starter files (Nov. 11)
- `615ddc2` — Trajuan: update Styles.css (Nov. 11)
- `5078847` — Trajuan: temporary login placeholder (Nov. 11)

### Next steps
Develop the homepage, shared styling, and character creation while authentication is implemented in parallel.

## Sprint 2 — November 12–13: Homepage, character creation, and shared UI

**Contributors:** Trajuan Smith and Hien Dao

### Trajuan's work
- Implemented initial champion creation and PHP validation.
- Set faction relationship starting values and created a starting-statistics preview.
- Built the character confirmation and adventure initialization flow.
- Added dynamic Warrior, Mage, and Rogue background images and faction-responsive styling.
- Began the main game interface, including champion statistics, story area, and supporting layout.
- Refactored shared CSS and navigation to reduce inconsistent page styling.

### Hien's work
- Updated homepage styling variables, header, footer, and favicon.
- Added the homepage hero and about sections.
- Developed the registration page foundation.
- Integrated homepage work through a feature branch and resolved a merge issue.

### Testing and debugging
- The original journal records successful tests of faction backgrounds, starting-stat changes, champion confirmation, reset, and adventure initialization.
- A `404 Not Found` image-loading problem was traced to relative CSS image paths and corrected.
- Shared styling and navigation were reviewed during integration.

### Decisions and trade-offs
- Kept faction artwork behind darkened/blurred overlays to preserve text readability.
- Used separate CSS assets for faction backgrounds and shared navigation.
- Preserved a PHP-session-based champion setup flow.

### Selected commits
- `3883d9a` — Trajuan: initial character creation and validation (Nov. 12)
- `4c98e17` — Trajuan: initial faction relationship values (Nov. 12)
- `ac6ec50` — Hien: homepage color variables, header/footer/favicon (Nov. 12)
- `5661899` — Trajuan: character creation UI and stats preview (Nov. 12)
- `7617cd7` — Trajuan: champion confirmation and adventure setup (Nov. 12)
- `3ec5701` — Trajuan: faction backgrounds (Nov. 12)
- `1ab5dc3` — Trajuan: shared CSS/navigation refactor (Nov. 13)
- `e5488be` — Trajuan: main game interface foundation (Nov. 13)
- `0940412` — Hien: homepage hero section (Nov. 13)
- `819e2a3` / `7b15ec9` — Hien: homepage merge and merge fix (Nov. 13)
- `daa15b1` — Hien: homepage about section (Nov. 13)
- `e8aede0` — Hien: register.php (Nov. 13)

### Next steps
Connect the character flow to story state and implement real registration/login alongside story choice mechanics.

## Sprint 3 — November 14–15: Story systems, Insight Relic, and authentication

**Contributors:** Trajuan Smith and Hien Dao

### Trajuan's work
- Implemented story choice rewards and session-based inventory management.
- Added inventory item addition/removal and an expandable inventory display.
- Implemented dynamic faction relationships and story flags.
- Added advanced story choice requirements based on player state.
- Implemented choice consequence previews and dynamic Insight Relic guidance.
- Improved the accuracy of story consequence notifications.
- Reorganized image assets under `assets/`.

### Hien's work
- Added login and logout pages and initial user storage.
- Updated `.gitignore` and storage tracking rules.
- Corrected registration/login page details, including the login title and removal of the registration email requirement.
- Moved homepage images into `assets/images/` and corrected image references in the homepage and CSS.

### Testing and debugging
- The original journal records tests confirming that inventory/stat changes and story flags persisted across refreshes.
- Relationship values were restricted to the intended range of 0–100, with descriptive tiers used in the interface.
- A session-variable naming mismatch produced a PHP error and was corrected.
- Asset locations and paths required cleanup during folder reorganization.

### Design decisions
- Keep numeric trust values internal while showing readable relationship tiers to players.
- Reuse the same story engine for all three factions through dynamic relationship lookup.
- Keep the Insight Relic advisory: explain consequences without making decisions for the player.
- Store game decisions and consequences on the server rather than relying on browser-side scripts.

### Selected commits
- `cda8d03` — Trajuan: inventory and story choice rewards (Nov. 14)
- `4819095` — Trajuan: move images into assets (Nov. 14)
- `c5656f5` — Trajuan: dynamic relationships and flags (Nov. 14)
- `01d40e7` — Trajuan: advanced choice requirements (Nov. 14)
- `536950a` — Trajuan: consequence previews (Nov. 14)
- `e78e5cc` — Trajuan: dynamic Insight Relic guidance (Nov. 14)
- `337ad93` — Hien: login, logout, and user JSON storage (Nov. 14)
- `5537de4` / `6bf5554` — Hien: storage tracking and `.gitignore` (Nov. 14)
- `57f1093` — Trajuan: accurate story consequence notifications (Nov. 15)
- `18b2c35` — Hien: image moves and homepage path corrections (Nov. 15)
- `e19bda4` — Hien: login title and registration form update (Nov. 15)

### Next steps
Develop playable Act I encounters and turn-based combat; integrate the registration/login pages with protected game routes.

## Sprint 4 — November 16: Act I gameplay and combat

**Contributors:** Trajuan Smith (gameplay); Hien Dao (authentication styling work continuing into Nov. 17)

### Work completed
- Expanded Act I exploration and recorded player choices.
- Built the initial combat interface in `combat.php`.
- Added combat item use, healing potions, and class ability actions.
- Added escape handling and special ability restrictions.
- Added faction-specific weapons and equipment.
- Integrated the combat interface with existing champion statistics and inventory mechanics.
- Merged gameplay changes through a pull request.

### Testing and debugging
- Development discussions covered tests of combat actions, healing items, restrictions, and progression. A complete cross-faction regression test is not established by the Git log alone.
- Continued checking transitions between narrative nodes and combat encounters.

### Decisions
- Use server-side PHP for turn-based combat and action validation.
- Preserve distinct faction equipment and abilities while sharing combat functions.
- Restrict special ability use to avoid repeated unrestricted actions.

### Selected commits
- `8e5f785` — Trajuan: Act I exploration and choice tracking
- `771d039` — Trajuan: initial combat page
- `4f01451` — Trajuan: combat items, potions, and abilities
- `40c0892` — Trajuan: combat escape and ability restrictions
- `6c6bbce` — merge pull request #3
- `3fb8074` — Trajuan: faction weapons and equipment

### Next steps
Finish Act I, connect combat outcomes to story progression, add save/reload, and build the remaining acts.

## Sprint 5 — November 17: Authentication integration, saving, Act I completion, and leaderboard

**Contributors:** Trajuan Smith and Hien Dao

### Trajuan's work
- Added the first rival encounter to Act I and completed the Act I storyline.
- Connected level-up effects to the Insight Relic.
- Added authentication guards to protected game pages.
- Implemented functions to save player session progress and restore it when the player logs back in.
- Added Insight Relic relationship-tier descriptions.
- Merged story and user-storage changes through pull requests.

### Hien's work
- Improved registration and login styling and corrected page headers.
- Added the initial leaderboard page and related storage tracking configuration.
- Added user storage files needed for account data integration.

### Testing and integration notes
- Authentication guards were added so protected gameplay routes could check login state.
- Save/reload functions were committed; the complete logout/login restoration flow should be included in the final browser test checklist.
- The initial leaderboard was a separate milestone from the later live-scoring update on Nov. 18.

### Selected commits
- `ace26a5` — Hien: improve registration/login styling
- `c591c64` — Hien: fix registration/login header
- `f6da7e6` — Hien: track leaderboard.json
- `d732236` — Hien: initial leaderboard page
- `08247b3` — Trajuan: initial rival encounter
- `e81a057` — merge pull request #4
- `c443399` — Trajuan: authentication guards
- `f1f8bc0` — merge pull request #5
- `abf7d76` — Hien: add users.json
- `9ac674d` — Trajuan: complete Act I and add Insight Relic level-up effects
- `2bda13d` — Trajuan: save and restore player progress
- `61775c7` — Trajuan: Insight Relic relationship tiers

### Next steps
Complete Acts II–III, ending resolution, Hero Summary, and final leaderboard scoring; run end-to-end tests.

## Sprint 6 — November 18: Complete narrative, Hero Summary, and live leaderboard

**Contributors:** Trajuan Smith; earlier leaderboard/authentication foundations by Hien Dao

### Work completed
- Implemented the remaining narrative from Act I through Act III, including the endgame flow.
- Added the AI Hero Summary page to describe the completed adventure.
- Integrated final score calculation and saved player progress.
- Updated the leaderboard to rank saved player records by calculated score and display champion, faction, level, ending, and score.
- Added Hero Summary presentation improvements, including background glow, ending-banner pulse, and staggered content appearance.
- Merged the Hero Summary styling work through pull request #7.

### Testing and debugging
- The original Nov. 18 journal reports that the leaderboard displayed player information, sorted by score, and reflected progressing scores.
- The latest project ZIP contains the leaderboard, score functions, Hero Summary, and save functions; this confirms implementation presence, not exhaustive runtime correctness.
- Final browser checks still needed for each ending, secret-ending requirements, save restoration, leaderboard ordering, and protected-route access.

### Selected commits
- `cd9e805` — Trajuan: implement Act I through Act III
- `778b2a2` — merge pull request #6
- `f134d4e` — Trajuan: AI Hero Summary page
- `64f30d2` — Trajuan: live leaderboard scoring and Hero Summary animations (visible in supplied GitHub screenshot)
- `5d88972` — merge pull request #7, Hero Summary styling (visible in supplied GitHub screenshot)

### Next steps
- Verify PHP syntax, forms, sessions, registration/login/logout, and safe output.
- Perform full Warrior/Mage/Rogue playthroughs, including defeat and secret-ending cases.
- Verify saved progress after logging out and returning.
- Check responsive behavior and keyboard accessibility on core pages.
- Finish README, Trello sprint evidence, recorded presentation, Q&A, and submission links before the deadline.

## Important debugging and refactoring record

1. **Missing faction backgrounds (Nov. 12–13):** CSS relative image paths initially produced 404 errors. Paths were corrected, and the original journal records successful display afterward.
2. **Session-variable naming mismatch (Nov. 14):** A PHP error occurred while implementing relationships/story flags. The mismatched session key was corrected, and the original journal records persistence tests afterward. The exact fixing commit is not identified; verify before citing it in Q12.
3. **Homepage merge conflict (Nov. 13):** Hien committed a merge correction (`7b15ec9`) after integrating homepage work.
4. **Asset organization (Nov. 14–15):** Both developers moved images into the assets directory and updated references to improve consistency.
5. **Authentication and protected routes (Nov. 17):** Trajuan added explicit game-page authentication guards (`c443399`) as part of integration.
6. **Leaderboard evolution (Nov. 17–18):** Hien implemented the original leaderboard; Trajuan later connected ranking to saved progress and live score calculation. The latest leaderboard reads saved player records rather than treating the earlier leaderboard JSON file as its sole source.

## AI assistance and disclosure

ChatGPT was used during development for planning, code explanation, debugging suggestions, testing checklists, and documentation drafting. The team made design decisions, wrote and integrated code into the repository, and reviewed changes through its development workflow. The in-game **Insight Relic** is a transparent PHP rule-based guidance system; it does not require an external AI API or model. Its purpose is to explain potential choice consequences and contextual relationship information without automatically choosing for the player.

**Limitations to disclose:** Rule-based guidance is constrained by the metadata and game state the developers encode; it cannot reason about unimplemented outcomes. The application depends on correct PHP session and saved-progress synchronization, and manual end-to-end testing remains important.

### AI Feature Testing Results — November 18, 2026

Three manual test cases were performed on the Insight Relic guidance system using the Brave browser and a local PHP development server.

**AI-01 — Normal Case:** The Insight Relic predicted that launching a surprise attack could provide a combat advantage while damaging relationships. After selecting the choice, the game confirmed the surprise advantage and displayed a relationship penalty. **Result: PASS.**

**AI-02 — Boundary Case:** A Mage with 7 Strength could not select a choice requiring 15 Strength. The system correctly identified the missing 8 Strength. A Warrior with exactly 15 Strength could select the choice, destroy the monument, absorb a crystal, and increase Strength to 20. **Result: PASS.**

**AI-03 — Fallback/Edge Case:** The team confirmed that the ordinary "Continue the Expedition" choice exercises the fallback-guidance path. The Insight Relic displayed "Moving forward will leave any unexplored discoveries behind." No PHP errors or misleading stat consequences appeared. **Result: PASS.**

**Evidence:** `assets/evidence/AI_Testcase1_TrustDecrease01.png` and `assets/evidence/AI_Testcase1_TrustDecrease02.png` show the prediction and relationship consequence for AI-01. `assets/evidence/TestCase02_StatBoundary01.png` through `assets/evidence/TestCase02_StatBoundary06.png` document the locked Mage choice, the Warrior path, the crystal reward, and the final Strength of 20 for AI-02. AI-03 was verified in the browser with the fallback guidance displayed; retain its screenshot with the submission evidence. Screenshot filenames refer to separate evidence files, not images embedded in this Markdown document.

**Conclusion:** All three manual UI tests passed. The tests demonstrate contextual consequence previews, dynamic requirement explanations, and appropriate guidance for an ordinary choice. The system is rule-based and relies on predefined story metadata and the player's current state rather than a generative AI model. Testing was limited to the observed scenarios and does not establish complete coverage of every story branch.

## Evidence and final verification checklist

- **GitHub:** Commit history identifies each contributor and records feature development, merges, and fixes.
- **Trello:** Confirm all six sprint cards, assignees, status transitions, and actual review/stand-up evidence before presenting them as completed Scrum events.
- **Application:** Demonstrate account registration/login, character creation, faction choice, stat-locked choices, Insight Relic previews, inventory, combat, save/reload, an ending, Hero Summary, and leaderboard.
- **Testing:** Three AI cases are documented above (normal, boundary/locked, and fallback guidance). Mobile/desktop, authentication, and full-game regression checks remain separate final-verification items.
- **Submission:** Confirm CODD deployment, GitHub URL, video link, Q&A responses, and each team member's submission file.

