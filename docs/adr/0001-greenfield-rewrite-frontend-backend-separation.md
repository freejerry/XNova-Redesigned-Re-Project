# Greenfield rewrite with frontend/backend separation

The existing codebase is ~35k lines of PHP 5.x that cannot run on modern PHP (`mysql_*`, `preg_replace /e`, `magic_quotes`), has no architecture layering, and mixes DB access, game rules, `eval()`ed formulas, and inline HTML in single files. Since this is an open-source project with no live players or data to preserve, we will rewrite from scratch as a new project with a clean frontend/backend split, rather than incrementally strangling the old code.

The asset being preserved is not the code but the **game design** encoded in it — building/research formulas, tech tree, fleet mechanics, combat rules, missions. The rewrite must faithfully reproduce these; that porting effort, not the framework work, is the main cost and risk.

The rewrite lives in the **same repository**, not a new one: the old PHP is moved to `legacy/` and kept as the reference for those formulas and numbers until the TypeScript version reaches parity, then deleted. This keeps the ADRs, glossary, and issue tracker already set up here, and keeps the reference code one `grep` away rather than in a separate repo. A new repo was rejected — its only benefit (a clean git history) does not justify losing that co-location.
