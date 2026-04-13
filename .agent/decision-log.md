# Decision Log

Use this file for short, dated architecture/process decisions that matter to agents.

## Entry Template

```
## YYYY-MM-DD - Decision title

Context:
- Why the decision was needed.

Decision:
- What was chosen.

Consequences:
- Tradeoffs, follow-up work, or constraints.
```

## 2026-04-12 - Agent docs split model

Context:
- Agent guidance had grown into a single `AGENTS.md` file with mixed policy and reference content.
- The team wanted `AGENTS.md` to stay lean and stable while preserving comprehensive instructions.

Decision:
- Keep `AGENTS.md` as a gateway doc containing only a TOC to `.agent/` docs and stop conditions.
- Move detailed architecture, workflow, testing, and standards content into dedicated files under `.agent/`.

Consequences:
- Discoverability improves and topic ownership becomes clearer.
- Future policy or architecture changes should update only the relevant `.agent/*` file.
