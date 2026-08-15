# XNova Redesigned

An OGame-style browser strategy game, being rewritten from PHP 5.x to a
TypeScript full-stack. See `CONTEXT.md` for the domain glossary and
`docs/adr/` for the architecture decisions driving the rewrite.

## Layout

- `packages/shared` — game formulas, types, constants (shared by api + web)
- `apps/api` — tRPC backend, service layer, event scheduler (Postgres)
- `apps/web` — Vite + React SPA
- `legacy/` — the original PHP game, kept as a reference for game formulas and
  numbers until the rewrite reaches parity, then removed.

First slice tracked in issue #47 (planet resources + building queue).
