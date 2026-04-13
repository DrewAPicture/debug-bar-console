# Project Overview

## Purpose

Debug Bar Console adds a PHP/SQL console panel to the Debug Bar plugin so privileged users can execute snippets from the admin debug interface.

## Runtime Context

- WordPress plugin loaded via `debug-bar-console.php`.
- Depends on Debug Bar plugin panel APIs and WordPress hook APIs.
- PHP runtime target in Composer is `^7.4|^8`; plugin header currently declares `Requires PHP: 8.0`.

## Boundaries

- This plugin provides panel integration, panel rendering, and AJAX execution logic.
- It does not provide core Debug Bar functionality; it extends Debug Bar by registering a panel.
- It includes a compatibility layer in `compat.php` for legacy global symbols and migration safety.

## Key Dependencies

- Runtime:
  - WordPress (`add_action`, `add_filter`, AJAX hooks, escaping/sanitization helpers).
  - Debug Bar (`Debug_Bar_Panel` and `debug_bar_panels` filter).
- Development/testing:
  - PHPUnit (`phpunit/phpunit`)
  - PHPStan + WordPress extension (`phpstan/phpstan`, `szepeviktor/phpstan-wordpress`)
  - Pint (`laravel/pint`)
  - Brain Monkey (`brain/monkey`)

## Entry Points

- `debug-bar-console.php`: plugin bootstrap and initialization.
- `compat.php`: legacy symbols and backward-compat shims.
- `src/Integration.php`: panel registration and asset enqueuing hooks.
- `src/Panel.php`: panel UI rendering.
- `src/PanelAjax.php`: AJAX callback execution for PHP/SQL modes.
