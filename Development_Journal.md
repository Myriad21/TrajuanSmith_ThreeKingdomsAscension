# Development Journal — Three Kingdoms Ascension

## November 10, 2026 — Sprint 1: Project Setup

**Team:** Trajuan Smith and Hien Dao

### Work Completed
- Created and connected the GitHub repository.
- Verified the local PHP installation.
- Successfully tested the local PHP development server.
- Confirmed access to the CODD server.
- Established the Trello board and sprint tasks.
- Confirmed the proposed division of team responsibilities.

### Team Responsibilities
- Trajuan Smith: Scrum Master, PHP game logic, combat,
  and story progression.
- Hien Dao: Product Owner, UI, authentication,
  and leaderboard.
- Both: Integration, testing, documentation,
  and presentation.

### Testing
- PHP command-line verification: Passed.
- Git repository verification: Passed.
- Local PHP server verification: Passed.
- CODD access verification: Passed.

### Issues and Resolutions
- No technical setup issues encountered.
- Instructor proposal approval remains pending.

### Next Steps
- Obtain instructor approval.
- Begin Sprint 2: UI foundation and character creation.

### AI Assistance
- ChatGPT assisted with planning, environment
  verification instructions, and documentation.

## November 10, 2026 — Sprint 2: UI Foundation

**Developer:** Trajuan Smith

### Work Completed
- Established the initial project folder structure.
- Started developing `index.php` as the homepage for Three Kingdoms Ascension.
- Added the game's title, introduction, and character creation placeholder.
- Added semantic HTML elements, including the header, main section, and footer.
- Linked the homepage to the shared stylesheet (`assets/css/styles.css`).

### Testing
- Homepage browser rendering: Pending confirmation.
- Navigation testing: Not started.

### Issues and Resolutions
- No implementation issues reported so far.

### Next Steps
- Verify the homepage displays correctly.
- Implement shared CSS styling.
- Create reusable navigation and page components.
- Begin the character creation interface.

### November 13, 2026 — Character Creation and Faction Backgrounds

**Work Completed:**
- Continued developing the character creation system and its confirmation flow.
- Implemented a champion confirmation page displaying the selected name, faction, starting statistics, and level.
- Added functionality to return to character creation and reset the previously selected champion.
- Created a temporary adventure initialization process using PHP sessions.
- Implemented dynamic faction backgrounds for Warrior, Mage, and Rogue using CSS.
- Added illustrated fantasy environments representing each faction's territory.
- Organized the background styling into a separate `faction_background.css` file to improve maintainability.
- Applied background blur, dark overlays, and smooth transitions to maintain readability.

**Testing and Debugging:**
- Verified that all three faction selections display the appropriate background images.
- Confirmed that the selected faction's starting statistics update correctly.
- Tested the champion confirmation, reset, and adventure initialization functionality.
- Encountered a `404 Not Found` error when loading the background images.
- Resolved the image-loading issue by correcting the relative paths in the CSS.
- Confirmed that the background images remain behind the character creation panel without interfering with user interactions.

**AI Assistance:**
- Received guidance on CSS selectors, background layering, blur effects, transitions.
- Reviewed and tested the generated code, making adjustments as needed.

**Next Steps:**
- Continue developing the adventure flow and story progression.
- Connect character confirmation to the actual game interface.
- Implement additional PHP session-based game mechanics.
