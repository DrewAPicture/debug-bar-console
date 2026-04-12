<?php

/**
 * PHPUnit bootstrap file.
 */

require_once dirname(__DIR__).'/vendor/autoload.php';

/**
 * Stub for Debug_Bar_Panel to satisfy the Panel class hierarchy
 * without requiring the Debug Bar plugin to be present.
 */
class Debug_Bar_Panel
{
    public function title($title = null) {}

    public function set_visible($visible) {}
}
