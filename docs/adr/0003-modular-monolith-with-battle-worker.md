# Modular monolith with the battle simulation as a separate worker

The backend is built as a **modular monolith** — one deployable unit with clean internal module boundaries (resources, buildings, fleets, alliances, …) — not a set of microservices. For a greenfield open-source game with limited early manpower, premature service decomposition would trade distributed-transaction and cross-service-consistency complexity for scalability that isn't needed yet. Module boundaries are kept clean so a service can be extracted later if a real scaling need appears.

The one exception is the **battle simulation**, extracted as a separate worker/function. It is CPU-bound and bursty, which is a genuine seam worth isolating from the request path.

Rejected: full microservices / per-domain lambdas up front.
