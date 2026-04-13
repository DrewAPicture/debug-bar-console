# Testing And Quality

All three quality tools must pass before work is considered complete:

- PHPUnit: `./vendor/bin/phpunit`
- PHPStan (max level): `./vendor/bin/phpstan analyse`
- Pint (style test): `./vendor/bin/pint --test`

## Test Conventions

- **Namespaces**: test class namespaces mirror source namespaces under `Tests\Unit` (for example, `Tests\Unit\Helpers` for `DebugBarConsole\Helpers`).
- **Test method names**: use dromedary case such as `testMethodNameDoesThing()`.
- **Data providers**: return a `Generator`; each yielded case is an array.
- **Data provider naming**: mirror the test method name and replace `test` with `provider` (`testFoo()` -> `providerFoo()`).
- **Avoid `shouldReceive()`**: prefer explicit mock setup to avoid silent failures.
- **Concrete test doubles**: define file-local concrete doubles at the bottom of the same test file when needed.
- **Imports**: avoid fully-qualified class names inline; import classes with `use` statements.

## Suite Layout

- Unit tests live in `tests/Unit`.
- Compatibility tests live in `tests/Compat`.
- Test bootstrap lives in `tests/bootstrap.php`.

## Alignment Checks

When changing tests or tooling behavior, keep these files aligned:

- `composer.json`
- `phpunit.xml`
- `phpstan.neon`
