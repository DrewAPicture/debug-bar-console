# PHP Standards

## Project Policy

Although this is a WordPress plugin, it does not follow WordPress PHP coding standards as the source-of-truth style policy.

- Do not apply or enforce WPCS rules when writing or reviewing PHP code for this project.
- Follow the project's formatter/analyzer expectations (`pint`, `phpstan`) and established local style in existing files.

## Additional Guidance

- Keep code readable and strongly typed where practical.
- Prefer explicit imports (`use`) over inline fully-qualified names in implementation and tests.
- Match existing naming and structure patterns in `src/` and `tests/`.
