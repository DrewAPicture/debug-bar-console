<?php
/**
 * Plugin Name: Debug Bar Console
 * Plugin URI: http://wordpress.org/extend/plugins/debug-bar-console/
 * Description: Adds a PHP/SQL console panel to the Debug Bar plugin. Requires the Debug Bar plugin.
 * Author: Drew Jaynes
 * Author URI: https://werdswords.com
 * Version: 1.0.0
 * License: GPLv2
 * Requires PHP: 7.4
 * Text Domain: debug-bar-console
 * Domain Path: /languages/
 *
 * Copyright (c) 2026, Drew Jaynes
 * Copyright (c) 2011-2024, Daryl Koopersmith
 * http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

use DebugBarConsole\Integration;

// Bail if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main plugin class.
 *
 * @since 1.0.0
 */
class DebugBarConsole
{
    public const VERSION = '1.0.0';
    public const FILE = __FILE__;

    /**
     * Initializes the plugin.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function init() : void
    {
        require_once __DIR__.'/vendor/autoload.php';
        require_once __DIR__.'/compat.php';

        (new Integration())->start();
    }
}

add_action('init', fn() => (new DebugBarConsole())->init());
