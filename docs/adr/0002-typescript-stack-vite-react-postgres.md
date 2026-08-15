# TypeScript full-stack, Vite + React SPA, Postgres

The rewrite uses **TypeScript everywhere** — backend and frontend, including the battle simulation. The frontend is unavoidably JS/TS in the browser, so a single-language stack means the backend is TS too; this also lets game formulas (build costs, fleet ETAs) be written once and shared between the authoritative backend and the frontend preview.

- **Frontend**: Vite + React, a pure SPA. This is a post-login game view with no SEO/SSR need, so Next.js's server rendering would add a layer with little payoff.
- **Database**: Postgres. The game state is highly relational (planets belong to users, fleets reference planets, alliances have members), so a document/NoSQL store is rejected. Postgres also gives strict types, constraints, and `jsonb` for the flexible per-planet data. The old schema's bloat is a design problem (wide tables with one column per building), not a MySQL-engine problem — it will be redesigned and normalized, not merely ported.

Rejected: Python or PHP backend (would mean two languages alongside the JS frontend); NoSQL (fights the relational game state); Next.js (SSR unneeded).
