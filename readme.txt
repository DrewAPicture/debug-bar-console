=== Debug Bar Console ===
Contributors: drewapicture, koopersmith
Tags: debug, developer, console
Tested up to: 7.0
Stable tag: 1.0.0
Requires at least: 3.1
Requires Plugins: debug-bar
License: GPLv2

Adds a PHP/SQL console panel to the Debug Bar. Requires the [Debug Bar](https://wordpress.org/plugins/debug-bar/) plugin.

Release note: Companion `-agent` prerelease ZIPs are also published and include agent documentation files.

== Description ==

Adds a PHP/SQL console panel to the Debug Bar. Requires the [Debug Bar plugin](http://wordpress.org/extend/plugins/debug-bar/) (v0.5 or later).

This plugin was adopted in 2024 from the previous author, [@koopersmith](https://profiles.wordpress.org/koopersmith/).

== Upgrade Notice ==

= 1.0.0 =
* New – Modernized codebase with autoloading and clearer architecture
* Fixed – Output display logic: when PHP execution outputs HTML, the Formatted tab now renders it and the Raw tab shows unrendered markup (previously these were inverted).
* Misc - Minimum PHP requirement raised to 7.4.
* Misc - Updated for WordPress 7.0 compatibility
* Misc - GitHub releases now contain an agent-friendly version

= 0.3 =
* New - Added syntax highlighting using the CodeMirror text editor.
* Misc - Explicit PHP/SQL modes.
* Misc - UI changes to reflect updated debug bar UI.

= 0.2 =
* Misc - Improvements to MySQL detection and display.
* Misc – Bug fixes.

= 0.1 =
* Initial Release

== Changelog ==

= 1.0.0 =
* New – Code modernization: full rewrite with Composer autoloading, namespaced classes, and full test coverage.
* Fixed – Output display logic: when PHP execution outputs HTML, the Formatted tab now renders it and the Raw tab shows unrendered markup (previously these were inverted).
* Misc – Improved escaping in SQL results table: column keys and values are now more thoroughly escaped; non-scalar cell values render as empty strings.
* Misc – Minimum PHP requirement raised to 7.4.
* Misc - Updated for WordPress 7.0 compatibility
* Misc - GitHub releases now contain an agent-friendly version

**Deprecated (scheduled for removal in 2.0.0)**

* The global `Debug_Bar_Console` class is deprecated in favor of the new namespaced equivalent.
* The `debug_bar_console_panel()` and `debug_bar_console_scripts()` functions are deprecated.
* `class-debug-bar-console.php` remains as a compatibility shim but will be removed in the next major release.

= 0.3 =
* New - Added syntax highlighting using the CodeMirror text editor.
* Misc - Explicit PHP/SQL modes.
* Misc - UI changes to reflect updated debug bar UI.

= 0.2 =
* Misc - Improvements to MySQL detection and display.
* Misc – Bug fixes.

= 0.1 =
* Initial Release

== Installation ==

Install the [Debug Bar plugin](http://wordpress.org/extend/plugins/debug-bar/).

Use automatic installer.
