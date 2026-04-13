# Debug Bar Console — Agent Notes

This file is the lean gateway for agent work. Detailed guidance lives in `.agent/`.

## Table Of Contents

- [Agent docs index](.agent/README.md)
- [Project overview](.agent/project-overview.md)
- [Architecture](.agent/architecture.md)
- [Development workflow](.agent/dev-workflow.md)
- [Testing and quality](.agent/testing-and-quality.md)
- [PHP standards](.agent/php-standards.md)
- [Decision log](.agent/decision-log.md)

## Stop Conditions

Work is not complete until all of the following are true:

1. Required quality checks pass:
   - `./vendor/bin/phpunit`
   - `./vendor/bin/phpstan analyse`
   - `./vendor/bin/pint --test`
2. Any newly introduced docs links are valid and non-broken.
3. Behavior-changing code includes updated tests, or a clear rationale is documented when tests are not feasible.
4. Agent docs do not contradict source-of-truth config in `composer.json`, `phpunit.xml`, and `phpstan.neon`.
