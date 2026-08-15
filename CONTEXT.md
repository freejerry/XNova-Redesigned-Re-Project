# XNova Redesigned

An OGame-style browser strategy game: players manage planets, build structures, research technology, and send fleets on missions across a shared universe. This glossary pins the project's vocabulary; it holds domain concepts only, no implementation detail.

## Language

**Skin**:
A player-selectable visual theme (colors, fonts, assets) applied over the same UI structure. A server has one or more skins installed; each player picks one. Modelled as data (a set of design tokens + assets), not as page templates.
_Avoid_: Template (the old `.tpl` string-replace engine — a retired implementation, not a domain concept), Theme.

**Event**:
A discrete thing scheduled to happen at a future wall-clock time — a fleet arriving, a building or research finishing. Distinct from continuous resource production, which is not an event but is computed from elapsed time on read.
_Avoid_: Job, Task, Tick.
