# Time model: lazy-on-read continuous state + event table with in-process scheduler

Game time advances two ways. **Continuous state** (resource production) is computed lazily from a `last_update` timestamp and the current production rate whenever an entity is read — no background work. **Discrete events** (fleet arrival, building/research/shipyard completion) are rows in an `events` table with a `scheduled_at`; an **in-process scheduler** in the modular monolith resolves them at their due time, independent of whether any player is online. On read, an entity also re-checks its own due events as an idempotent **safety net**, so a crashed scheduler never leaves stale state.

The old system was pure lazy-on-read: it piggybacked a whole-`fleets`-table scan — under a table lock — onto *every* page request from *any* player (`ManageFleets()` at `common.php:105`). Correct (timestamp diffing is idempotent) but it puts a per-request whole-table lock on the hot path and only resolves events when someone is browsing. We keep its idempotent lazy recompute and drop the per-request whole-table lock in favor of the scheduler.

Rejected: a global cron "tick" that updates the whole universe on a timer (does not scale with player count).
