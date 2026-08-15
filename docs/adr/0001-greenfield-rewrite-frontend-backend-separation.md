# Greenfield rewrite with frontend/backend separation

The existing codebase is ~35k lines of PHP 5.x that cannot run on modern PHP (`mysql_*`, `preg_replace /e`, `magic_quotes`), has no architecture layering, and mixes DB access, game rules, `eval()`ed formulas, and inline HTML in single files. Since this is an open-source project with no live players or data to preserve, we will rewrite from scratch as a new project with a clean frontend/backend split, rather than incrementally strangling the old code.

The asset being preserved is not the code but the **game design** encoded in it — building/research formulas, tech tree, fleet mechanics, combat rules, missions. The rewrite must faithfully reproduce these; that porting effort, not the framework work, is the main cost and risk.
