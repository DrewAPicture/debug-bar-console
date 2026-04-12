<?php
/**
 * Code that exists for compat reasons
 *
 * @since     1.0.0
 *
 * @package   DebugBarConsole
 *
 * @copyright Copyright (c) 2026, Drew Jaynes
 * @copyright Copyright (c) 2011-2024, Daryl Koopersmith
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

use DebugBarConsole\{Integration, Panel, PanelAjax};

// Bail if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Globally-namespaced panel class.
 *
 * This Debug_Bar_Console class alias solely still exists today to mitigate for
 * Debug Bar's incompatibility with namespaced panel class names. If/when
 * namespace support is added upstream, this class will be deprecated and removed.
 *
 * @since 1.0.0 Relocated to compat.php
 * @since 0.1
 */
class Debug_Bar_Console extends Panel
{
    /**
     * Legacy panel AJAX callback.
     *
     * @since 1.0.0 Reloated to compat.php
     * @since 0.1
     */
    public function ajax()
    {
        _deprecated_function(
            __METHOD__,
            '1.0.0',
            PanelAjax::class.'::printOutput(). Scheduled for removal in Debug Bar Console v2.0.0.'
        );

        (new PanelAjax())->printOutput();
    }

    public function print_mysql_table($data, $query = '')
    {
        _deprecated_function(
            __METHOD__,
            '1.0.0',
            PanelAjax::class.'::printMySqlTable(). Scheduled for removal in Debug Bar Console v2.0.0.'
        );

        // Invoke protected printMySqlTable() method.
        (new ReflectionClass(PanelAjax::class))->getMethod('printMySqlTable')
            ->invoke(new PanelAjax(), $data, $query);
    }
}

/**
 * Legacy panel registration callback.
 *
 * This function will be removed in 2.0.0
 *
 * @deprecated since 1.0.0, see Integration::registerPanel().
 * @since      1.0.0 Relocated to compat.php
 * @since      0.1
 *
 * @param $panels
 *
 * @return array
 */
function debug_bar_console_panel($panels)
{
    _deprecated_function(
        __FUNCTION__,
        '1.0.0',
        Integration::class.'::registerPanel(). Scheduled for removal in Debug Bar Console v2.0.0.'
    );

    return array_merge($panels, [new Debug_Bar_Console()]);
}

/**
 * Legacy panel scripts register/enqueue callback.
 *
 * This function will be removed in 2.0.0
 *
 * @deprecated since 1.0.0, see Integration::registerScripts().
 * @since      1.0.0 Relocated to compat.php
 * @since      0.1
 *
 * @return void
 */
function debug_bar_console_scripts()
{
    _deprecated_function(
        __FUNCTION__,
        '1.0.0',
        Integration::class.'::registerScripts(). Scheduled for removal in Debug Bar Console v2.0.0.'
    );
}
