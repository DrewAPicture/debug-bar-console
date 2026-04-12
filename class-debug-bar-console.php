<?php
/**
 * Legacy Debug_Bar_Console class file.
 *
 * This file will be removed in 2.0.0.
 *
 * @deprecated since 1.0.0, see DebugBarConsole\Panel instead
 * @since      0.1
 *
 * @package    DebugBarConsole
 *
 * @copyright  Copyright (c) 2026, Drew Jaynes
 * @copyright  Copyright (c) 2011-2024, Daryl Koopersmith
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Bail if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

_deprecated_file(
    __FILE__,
    '1.0.0',
    'DebugBarConsole\Panel',
    'Scheduled for removal in Debug Bar Console v2.0.0.'
);

require_once __DIR__.'/compat.php';
