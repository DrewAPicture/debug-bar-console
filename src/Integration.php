<?php
/**
 * Debug Bar integration
 *
 * @since 1.0.0
 *
 * @package DebugBarConsole
 *
 * @copyright Copyright (c) 2024, Drew Jaynes
 * @copyright Copyright (c) 2011-2024, Daryl Koopersmith
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
namespace {

	use WW\DebugBarConsole\Panel;

	/**
	 * Globally-namespaced panel class to avoid Debug Bar's incompatibility with
	 * namespaces in panel class names.
	 *
	 * @since 1.0.0
	 */
	final class Debug_Bar_Console_Panel extends Panel{}
}

namespace WW\DebugBarConsole {

	use DebugBarConsole;
	use Debug_Bar_Console_Panel;
	use WW\DebugBarConsole\Helpers\AssetsHelper;

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
		 *
		 * @return void
		 */
		public function start() : void
		{
			add_filter('debug_bar_panels', [$this, 'registerPanel']);
			add_action('debug_bar_enqueue_scripts', [$this, 'enqueueScripts']);
		}

		/**
		 * Registers the panel.
		 *
		 * @param array<string, \Debug_Bar_Panel> $panels
		 *
		 * @return array
		 */
		public function registerPanel($panels)
		{
			$panels[] = new Debug_Bar_Console_Panel;

			return $panels;
		}

		/**
		 * Enqueues scripts and styles.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function enqueueScripts()
		{
			$basePath = "src/assets/codemirror";

			// Codemirror
			wp_enqueue_style(
				'debug-bar-console-cm',
				AssetsHelper::getStyleUrl("{$basePath}/lib/codemirror.css", false),
				[],
				'2.22'
			);
			wp_enqueue_script(
				'debug-bar-console-cm',
				AssetsHelper::getScriptUrl("{$basePath}/debug-bar-codemirror.js", false),
				[],
				'2.22',
				['in_footer' => false]
			);

			wp_enqueue_style(
				'debug-bar-console',
				AssetsHelper::getStyleUrl('assets/css/debug-bar-console.css'),
				['debug-bar', 'debug-bar-console-cm'],
				\DebugBarConsole::VERSION
			);
			wp_enqueue_script(
				'debug-bar-console',
				AssetsHelper::getScriptUrl('assets/js/debug-bar-console.js'),
				['debug-bar', 'debug-bar-console-cm'],
				\DebugBarConsole::VERSION,
				['in_footer' => false]
			);
		}
	}
}
