# Debug Bar Console — Agent Notes

## Unit Testing

- **Namespaces** — test class namespaces should mirror the source namespace they cover, with a primary namespace of `Tests\Unit` (e.g. `Tests\Unit\Helpers` for tests covering `DebugBarConsole\Helpers`)
- **Test method names** — use dromedary case: `testMethodNameDoesThing()`
- **Data providers** — must return a `Generator` instance, with each test case yielded as an array
- **Data provider naming** — mirror the corresponding test method name, replacing the `test` prefix with `provider` (e.g. `testFoo()` → `providerFoo()`)
- **Avoid `shouldReceive()`** — prefer explicit mock setup; `shouldReceive()` fails silently and can mask real errors
- **Concrete test doubles** — when a test needs a concrete test class, define it at the bottom of the same test file rather than in a separate file
- **Imports** — avoid fully-qualified class names inline; import all classes via `use` statements at the top of the file; this applies to PHP attributes as well (e.g. `use PHPUnit\Framework\Attributes\CoversClass;`)
- **No deprecations** — tests must not trigger PHP deprecated notices or PHPUnit deprecation warnings; treat any deprecation as a test failure
- **`#[CoversClass]`** — add one `#[CoversClass(SourceClass::class)]` attribute at the class level for each test class, identifying the source class under test
- **`#[CoversMethod]`** — add one `#[CoversMethod(SourceClass::class, 'methodName')]` attribute at the class level per source method exercised by the test class; multiple `#[CoversMethod]` attributes are allowed on a single class
- **`#[DataProvider]`** — use the `#[DataProvider('providerMethodName')]` attribute on test methods backed by a data provider; do not use PHPDoc `@dataProvider`
- **`#[Override]`** — add to any source method that overrides a parent class or interface method; no `use` import is needed (`Override` is a PHP built-in attribute in the root namespace)

## PHP Coding Standards

Although this is a WordPress plugin, it does not follow the WordPress coding standards for PHP. Do not apply or enforce WPCS rules when writing or reviewing PHP code.
