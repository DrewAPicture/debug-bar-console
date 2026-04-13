# Agent Documentation Index

This directory contains the detailed, agent-facing documentation for this plugin.

## Read This First

- Start with `AGENTS.md` for stop conditions and quick navigation.
- Use this index to open only the docs relevant to the task at hand.

## Documentation Map

- [`project-overview.md`](project-overview.md): plugin purpose, runtime context, and dependency boundaries.
- [`architecture.md`](architecture.md): system structure and request/data flow across the core PHP classes.
- [`dev-workflow.md`](dev-workflow.md): local execution workflow, commands, and contributor expectations.
- [`testing-and-quality.md`](testing-and-quality.md): test conventions and required quality gates.
- [`php-standards.md`](php-standards.md): PHP coding standards and policy notes.
- [`decision-log.md`](decision-log.md): short, append-only ADR notes for future agent decisions.

## Which File To Read

- Behavior change in runtime logic: `project-overview.md` + `architecture.md`.
- Test authoring/updating: `testing-and-quality.md`.
- Style or static-analysis issues: `php-standards.md` + `testing-and-quality.md`.
- Workflow or command questions: `dev-workflow.md`.
- Architectural tradeoff or policy choice: add a short entry in `decision-log.md`.

## Update Checklist

When code, tooling, or process changes, update these docs in the same PR:

- If bootstrap, hooks, panel behavior, or AJAX flow changes, update `architecture.md`.
- If dependency/runtime constraints change, update `project-overview.md`.
- If commands or quality gates change, update `dev-workflow.md` and `testing-and-quality.md`.
- If standards policy changes, update `php-standards.md`.
- If a project-level decision is made, append a dated note in `decision-log.md`.
