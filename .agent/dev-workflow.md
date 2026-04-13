# Development Workflow

## Setup

- Install dependencies with `composer install`.
- Work from the plugin root directory.
- Ensure Debug Bar plugin is active when validating runtime behavior in WordPress.

## Common Commands

- Run tests: `./vendor/bin/phpunit`
- Static analysis: `./vendor/bin/phpstan analyse`
- Style checks: `./vendor/bin/pint --test`
- Auto-fix style (when needed): `./vendor/bin/pint`

## Asset Minification

Minified assets are committed to the repository and must be regenerated whenever source assets change.

Run the minifier:

```
composer minify
```

Source → output mappings:

| Source | Output |
|---|---|
| `src/assets/css/debug-bar-console.css` | `assets/css/debug-bar-console.min.css` |
| `assets/css/iframe.css` | `assets/css/iframe.min.css` |
| `src/assets/js/debug-bar-console.js` | `assets/js/debug-bar-console.min.js` |

The CodeMirror files under `src/assets/codemirror/` are third-party and loaded as-is — do not minify them.

The script lives in `bin/minify.php` and uses `matthiasmullie/minify`. The `bin/` directory is excluded from release packages via `.gitattributes`.

## Standard Change Flow

1. Make focused changes to source/tests/docs.
2. Update agent docs in `.agent/` when architecture, tooling, or policy changes.
3. Run required quality checks locally.
4. Verify no contradictions between docs and repo config (`composer.json`, `phpunit.xml`, `phpstan.neon`).
5. Prepare PR with concise rationale and test evidence.

## Docs Maintenance Rules

- Keep `AGENTS.md` lean: TOC + stop conditions only.
- Keep detailed guidance in `.agent/` files.
- Prefer updating the single canonical file for a topic instead of duplicating guidance.

## PR Hygiene

- Keep changes scoped to one intent where possible.
- Include or update tests for behavior changes.
- If tests are not practical, document why in the PR context.

## Release Packaging Variants

- Stable package defaults are controlled by repository `.gitattributes`.
- Stable packages must exclude agent docs and development-only files:
  - `.agent/`, `AGENTS.md`, `CLAUDE.md`
  - `tests/`, `.github/`, `.claude/`
  - `phpstan.neon`, `phpunit.xml`, `pint.json`
- Agent variant packaging uses `.agent/.gitattributes.agent` as a `git archive` override so the package includes:
  - `.agent/`
  - `AGENTS.md`
  - `CLAUDE.md`
- Agent variant still excludes tests and development metadata.

## Agent Release Workflow

- Workflow file: `.github/workflows/agent-release.yaml`.
- Primary trigger: `release.released`.
- Manual trigger: `workflow_dispatch` with `release_tag` input for dry runs or reruns.
- Output:
  - prerelease tag `<releaseTag>-agent`
  - asset `debug-bar-console-<releaseTag>-agent.zip`
  - checksum `debug-bar-console-<releaseTag>-agent.zip.sha256`
