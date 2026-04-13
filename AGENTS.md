# Debug Bar Console — Agent Notes

## Unit Testing

- **Namespaces** — test class namespaces should mirror the source namespace they cover, with a primary namespace of `Tests\Unit` (e.g. `Tests\Unit\Helpers` for tests covering `DebugBarConsole\Helpers`)
- **Test method names** — use dromedary case: `testMethodNameDoesThing()`
- **Data providers** — must return a `Generator` instance, with each test case yielded as an array
- **Data provider naming** — mirror the corresponding test method name, replacing the `test` prefix with `provider` (e.g. `testFoo()` → `providerFoo()`)
- **Avoid `shouldReceive()`** — prefer explicit mock setup; `shouldReceive()` fails silently and can mask real errors
- **Concrete test doubles** — when a test needs a concrete test class, define it at the bottom of the same test file rather than in a separate file
- **Imports** — avoid fully-qualified class names inline; import all classes via `use` statements at the top of the file

## Code Quality

All three tools must pass before code is considered complete:

- **PHPUnit** — all tests must pass (`./vendor/bin/phpunit`)
- **PHPStan** — no errors at level max (`./vendor/bin/phpstan analyse`)
- **Pint** — no style violations (`./vendor/bin/pint --test`)

## PHP Coding Standards

Although this is a WordPress plugin, it does not follow the WordPress coding standards for PHP. Do not apply or enforce WPCS rules when writing or reviewing PHP code.
