<?php

namespace Tests\Compat;

use Brain\Monkey;
use Brain\Monkey\Functions;
use DebugBarConsole\PanelAjax;
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__, 2).'/compat.php';

class CompatTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();
    }

    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }

    public function testAjaxTriggersDeprecationNotice(): void
    {
        Functions\expect('_deprecated_function')
            ->once()
            ->with('Debug_Bar_Console::ajax', '1.0.0', \Mockery::type('string'));

        Functions\expect('check_ajax_referer')->andReturn(false);

        (new \Debug_Bar_Console)->ajax();
    }

    public function testPrintMysqlTableTriggersDeprecationNotice(): void
    {
        Functions\expect('_deprecated_function')
            ->once()
            ->with('Debug_Bar_Console::print_mysql_table', '1.0.0', \Mockery::type('string'));

        Functions\stubs(['esc_attr', 'esc_html', 'esc_sql']);

        ob_start();
        (new \Debug_Bar_Console)->print_mysql_table([['col' => 'val']]);
        ob_get_clean();
    }

    public function testDebugBarConsolePanelTriggersDeprecationNotice(): void
    {
        Functions\expect('_deprecated_function')
            ->once()
            ->with('debug_bar_console_panel', '1.0.0', \Mockery::type('string'));

        debug_bar_console_panel([]);
    }

    public function testDebugBarConsolePanelAppendsPanelToArray(): void
    {
        Functions\stubs(['_deprecated_function']);

        $result = debug_bar_console_panel([]);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(\Debug_Bar_Console::class, $result[0]);
    }

    public function testDebugBarConsolePanelPreservesExistingPanels(): void
    {
        Functions\stubs(['_deprecated_function']);

        $existing = new \Debug_Bar_Panel;
        $result   = debug_bar_console_panel([$existing]);

        $this->assertCount(2, $result);
    }

    public function testDebugBarConsoleScriptsTriggersDeprecationNotice(): void
    {
        Functions\expect('_deprecated_function')
            ->once()
            ->with('debug_bar_console_scripts', '1.0.0', \Mockery::type('string'));

        debug_bar_console_scripts();
    }
}
