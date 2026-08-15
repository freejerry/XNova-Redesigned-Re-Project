# Transport-agnostic service layer: tRPC now, thin WebSocket for realtime, REST later

Business logic lives in plain TypeScript **service functions** that know nothing about how they are called. Transports sit on top:

- **tRPC** for client↔server calls — end-to-end types, and game formulas shared from the `shared` package so the frontend can preview what the backend authoritatively computes.
- A **thin WebSocket gateway** for realtime, scoped to pushing **discrete notifications only** — chat messages, incoming-fleet / battle alerts, event completions. It does **not** sync game state; state stays computed on the client from shared formulas plus lazy reads. No presence, rooms, or realtime sync engine.

Because logic is transport-agnostic, adding a **REST/OpenAPI** surface later — for a native iOS/Android client — is additive over the same services, not a rewrite. So REST is not built now (no non-TS client exists yet).

Rejected: adopting REST up front for a client that doesn't exist; `trpc-openapi` (extra maturity risk, not needed until mobile lands); full game-state sync over WebSocket.
