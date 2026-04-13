<?php

/**
 * PHPUnit bootstrap file.
 */

require_once dirname(__DIR__).'/vendor/autoload.php';

if (! defined('ABSPATH')) {
    define('ABSPATH', '/tmp/');
}

/**
 * Stub for the main DebugBarConsole class so src/ classes that reference
 * \DebugBarConsole::FILE or \DebugBarConsole::VERSION can resolve without
 * loading the full plugin bootstrap file.
 */
class DebugBarConsole
{
    public const VERSION = '1.0.0';

    public const FILE = __FILE__;
}

/**
 * Stub for Debug_Bar_Panel to satisfy the Panel class hierarchy
 * without requiring the Debug Bar plugin to be present.
 */
class Debug_Bar_Panel
{
    public function title($title = null) {}

    public function set_visible($visible) {}

    public function init(): void {}

    public function prerender(): void {}

    public function render(): void {}
}
