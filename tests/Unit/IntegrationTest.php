<?php

namespace Tests\Unit;

use Brain\Monkey;
use Brain\Monkey\Actions;
use Brain\Monkey\Filters;
use Brain\Monkey\Functions;
use DebugBarConsole\Integration;
use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase
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

    public function testStartRegistersDebugBarPanelsFilter(): void
    {
        Filters\expectAdded('debug_bar_panels')->once();
        Actions\expectAdded('debug_bar_enqueue_scripts')->once();

        (new Integration)->start();

        $this->addToAssertionCount(1);
    }

    public function testStartRegistersEnqueueScriptsAction(): void
    {
        Filters\expectAdded('debug_bar_panels')->once();
        Actions\expectAdded('debug_bar_enqueue_scripts')->once();

        (new Integration)->start();

        $this->addToAssertionCount(1);
    }

    public function testRegisterPanelAppendsPanelToArray(): void
    {
        $panels = [];
        $result = (new Integration)->registerPanel($panels);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(\Debug_Bar_Console::class, $result[0]);
    }

    public function testRegisterPanelPreservesExistingPanels(): void
    {
        $existing = new \Debug_Bar_Panel;
        $result = (new Integration)->registerPanel([$existing]);

        $this->assertCount(2, $result);
        $this->assertSame($existing, $result[0]);
    }

    public function testRegisterPanelReturnsArray(): void
    {
        $result = (new Integration)->registerPanel([]);

        $this->assertIsArray($result);
    }

    public function testEnqueueScriptsEnqueuesCodemirrorStyle(): void
    {
        Functions\expect('plugins_url')->andReturn('https://example.com/asset');
        Functions\expect('wp_enqueue_style')
            ->with('debug-bar-console-cm', \Mockery::any(), \Mockery::any(), \Mockery::any())
            ->once();
        Functions\expect('wp_enqueue_script')->twice();
        Functions\expect('wp_enqueue_style')
            ->with('debug-bar-console', \Mockery::any(), \Mockery::any(), \Mockery::any())
            ->once();

        (new Integration)->enqueueScripts();

        $this->addToAssertionCount(1);
    }

    public function testEnqueueScriptsEnqueuesCodemirrorScript(): void
    {
        Functions\expect('plugins_url')->andReturn('https://example.com/asset');
        Functions\expect('wp_enqueue_style')->twice();
        Functions\expect('wp_enqueue_script')
            ->with('debug-bar-console-cm', \Mockery::any(), \Mockery::any(), \Mockery::any(), \Mockery::any())
            ->once();
        Functions\expect('wp_enqueue_script')
            ->with('debug-bar-console', \Mockery::any(), \Mockery::any(), \Mockery::any(), \Mockery::any())
            ->once();

        (new Integration)->enqueueScripts();

        $this->addToAssertionCount(1);
    }

    public function testEnqueueScriptsPassesVersionToConsoleAssets(): void
    {
        Functions\expect('plugins_url')->andReturn('https://example.com/asset');
        Functions\expect('wp_enqueue_style')->twice();
        Functions\expect('wp_enqueue_script')
            ->with('debug-bar-console-cm', \Mockery::any(), \Mockery::any(), '2.22', \Mockery::any())
            ->once();
        Functions\expect('wp_enqueue_script')
            ->with('debug-bar-console', \Mockery::any(), \Mockery::any(), \DebugBarConsole::VERSION, \Mockery::any())
            ->once();

        (new Integration)->enqueueScripts();

        $this->addToAssertionCount(1);
    }
}
