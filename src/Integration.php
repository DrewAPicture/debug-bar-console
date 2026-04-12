<?php

/**
 * Debug Bar integration
 *
 * @since     1.0.0
 *
 * @copyright Copyright (c) 2026, Drew Jaynes
 * @copyright Copyright (c) 2011-2024, Daryl Koopersmith
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

namespace DebugBarConsole;

use Debug_Bar_Console;
use DebugBarConsole\Helpers\AssetsHelper;

// Bail if accessed directly
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Sets up the integration with Debug Bar.
 *
 * @since 1.0.0
 */
class Integration
{
    /**
     * Starts the Debug Bar integration.
     *
     * @since 1.0.0
     */
    public function start(): void
    {
        add_filter('debug_bar_panels', [$this, 'registerPanel']);
        add_action('debug_bar_enqueue_scripts', [$this, 'enqueueScripts']);
    }

    /**
     * Registers the panel.
     *
     * @param  array<int, \Debug_Bar_Panel>  $panels
     * @return array<int, \Debug_Bar_Panel>
     */
    public function registerPanel(array $panels): array
    {
        $panels[] = new Debug_Bar_Console;

        return $panels;
    }

    /**
     * Enqueues scripts and styles.
     *
     * @since 1.0.0
     */
    public function enqueueScripts(): void
    {
        $cmBasePath = 'src/assets/codemirror';

        // Codemirror
        wp_enqueue_style(
            'debug-bar-console-cm',
            AssetsHelper::getAssetUrl(
                "{$cmBasePath}/lib/codemirror.css",
                false
            ),
            [],
            '2.22'
        );
        wp_enqueue_script(
            'debug-bar-console-cm',
            AssetsHelper::getAssetUrl(
                "{$cmBasePath}/debug-bar-codemirror.js",
                false
            ),
            [],
            '2.22',
            ['in_footer' => false]
        );

        wp_enqueue_style(
            'debug-bar-console',
            AssetsHelper::getAssetUrl('assets/css/debug-bar-console.min.css'),
            ['debug-bar', 'debug-bar-console-cm'],
            \DebugBarConsole::VERSION
        );
        wp_enqueue_script(
            'debug-bar-console',
            AssetsHelper::getAssetUrl('assets/js/debug-bar-console.min.js'),
            ['debug-bar', 'debug-bar-console-cm'],
            \DebugBarConsole::VERSION,
            ['in_footer' => false]
        );
    }
}
