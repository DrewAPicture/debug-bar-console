<?php
/**
 * Panel: Ajax logic
 *
 * @since     1.0.0
 *
 * @copyright Copyright (c) 2026, Drew Jaynes
 * @copyright Copyright (c) 2011-2024, Daryl Koopersmith
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

namespace DebugBarConsole;

// Bail if accessed directly
if (! defined('ABSPATH')) {
    exit;
}

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
     */
    public function init(): void
    {
        add_action('wp_ajax_debug_bar_console', [$this, 'printOutput']);
    }

    /**
     * Ajax callback to print output for the 'debug_bar_console' action.
     *
     * @since 1.0.0
     */
    public function printOutput(): void
    {
        global $wpdb;
        /** @var \wpdb $wpdb */
        if (check_ajax_referer('debug_bar_console', 'nonce', false) === false) {
            exit();
        }

        if (! is_super_admin()) {
            exit();
        }

        $rawData = $_REQUEST['data'] ?? ''; // phpcs:ignore (It's literally PHP code)
        $rawMode = $_REQUEST['mode'] ?? 'php';
        $rawTab = $_REQUEST['tab'] ?? 'formatted';

        $data = wp_unslash(is_string($rawData) ? $rawData : '');
        $mode = sanitize_key(wp_unslash(is_string($rawMode) ? $rawMode : 'php'));
        $tab = sanitize_key(wp_unslash(is_string($rawTab) ? $rawTab : 'formatted'));

        if ($mode === 'php') {
            // Trim the data
            $data = '?>'.trim($data);

            // Do we end the string in PHP?
            $open = strrpos($data, '<?php');
            $close = strrpos($data, '?>');

            // If we're still in PHP, ensure we end with a semicolon.
            if ($open > $close) {
                $data = rtrim($data, ';').';';
            }

            eval($data);
            exit();
        } elseif ($mode === 'sql') {
            $queries = explode(";\n", $data);
            foreach ($queries as $query) {
                $query = str_replace('$wpdb->', $wpdb->prefix, $query);
                $results = $wpdb->get_results($query, ARRAY_A);

                if ($tab === 'formatted') {
                    // phpcs:ignore (No placeholders to prepare)
                    $this->printMySqlTable($results ?? [], $query);
                } else {
                    var_dump(print_r($results, true));
                }
            }
            exit();
        }
    }

    /**
     * Prints the MySQL table.
     *
     * @since 1.0.0
     *
     * @param  list<array<array-key, mixed>>  $data  Found rows.
     * @param  string  $query  Optional. Query text. Default empty string.
     */
    public function printMySqlTable(array $data, string $query = ''): void
    {
        $keys = array_keys($data[0] ?? []);

        if (empty($keys)) {
            esc_html_e('Your query produced no output; this does not necessarily mean it failed.');
            return;
        }
        ?>
        <table class="mysql">
            <thead>
            <tr class="query">
                <td colspan="<?php echo esc_attr((string) count($keys)); ?>"><?php echo esc_sql($query); ?></td>
            </tr>
            <tr>
                <?php foreach ($keys as $key) { ?>
                    <th class="<?php echo esc_attr((string) $key); ?>"><?php echo esc_html((string) $key); ?></th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $row) { ?>
                <tr>
                    <?php foreach ($row as $key => $value) { ?>
                        <td class="<?php echo esc_attr((string) $key); ?>"><?php echo esc_html(is_scalar($value) ? (string) $value : ''); ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        </div>
        <?php
    }
}
