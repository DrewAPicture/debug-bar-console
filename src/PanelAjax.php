<?php
/**
 * Panel: Ajax logic
 *
 * @since 1.0.0
 *
 * @package DebugBarConsole
 *
 * @copyright Copyright (c) 2024, Drew Jaynes
 * @copyright Copyright (c) 2011-2024, Daryl Koopersmith
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

namespace WW\DebugBarConsole;

/**
 * Panel ajax class.
 *
 * @since 1.0.0
 */
class PanelAjax
{
	/**
	 * Initializes the panel ajax logic.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init()
	{
		add_action('wp_ajax_debug_bar_console', [$this, 'printOutput']);
	}

	/**
	 * Ajax callback to print output for the 'debug_bar_console' action..
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function printOutput()
	{
		global $wpdb;

		if ( false === check_ajax_referer('Debug_Bar_Console', 'nonce', false)) {
			die();
		}

		if (!is_super_admin()) {
			die();
		}

		// phpcs:ignore (It's literally PHP code)
		$data = wp_unslash($_REQUEST['data'] ?? '');
		$mode = sanitize_key(wp_unslash($_REQUEST['mode'] ?? 'php'));

		if ( 'php' === $mode ) {
			// Trim the data
			$data = '?>' . trim($data);

			// Do we end the string in PHP?
			$open  = strrpos($data, '<?php');
			$close = strrpos($data, '?>');

			// If we're still in PHP, ensure we end with a semicolon.
			if ($open > $close) {
				$data = rtrim($data, ';') . ';';
			}

			eval($data);
			die();

		} elseif ('sql' === $mode) {
			$data = explode(";\n", $data);
			foreach ($data as $query ) {
				$query = str_replace('$wpdb->', $wpdb->prefix, $query);
				// phpcs:ignore (No placeholders to prepare)
				$this->printMysqlTable($wpdb->get_results($query, ARRAY_A), $query);
			}
			die();
		}
	}

	/**
	 * Prints the MySQL table.
	 *
	 * @param array<mixed> $data Found rows.
	 * @param string $query Optional. Query text. Default empty string.
	 * @return void
	 */
	protected function printMysqlTable($data, $query = '')
	{
		$keys = array_keys($data[0] ?? []);

		if (empty($keys)) {
			return;
		}
		?>
		<table class="mysql" cellpadding="0">
			<thead>
			<tr class="query">
				<td colspan="<?php echo esc_attr(count($keys)); ?>"><?php echo esc_sql($query); ?></td>
			</tr>
			<tr>
				<?php foreach ($keys as $key): ?>
					<th class="<?php echo esc_attr($key); ?>"><?php echo esc_html($key); ?></th>
				<?php endforeach; ?>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($data as $row): ?>
				<tr>
					<?php foreach ($row as $key => $value): ?>
						<td class="<?php echo esc_attr($key); ?>"><?php echo esc_html($value); ?></td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		</div>
		<?php
	}
}
