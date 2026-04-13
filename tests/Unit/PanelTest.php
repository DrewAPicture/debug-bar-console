<?php

namespace Tests\Unit;

use Brain\Monkey;
use Brain\Monkey\Functions;
use DebugBarConsole\Panel;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Panel::class)]
#[CoversMethod(Panel::class, 'init')]
#[CoversMethod(Panel::class, 'prerender')]
class PanelTest extends TestCase
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

    public function testPreRenderSetsVisible(): void
    {
        $panel = new class extends Panel
        {
            public bool $visibleSet = false;

            public function set_visible($visible): void
            {
                $this->visibleSet = $visible;
            }
        };

        $panel->prerender();

        $this->assertTrue($panel->visibleSet);
    }

    public function testInitSetsPanelTitle(): void
    {
        Functions\expect('__')
            ->once()
            ->with('Console', 'debug-bar-console')
            ->andReturn('Console');

        Functions\expect('add_action')->once();

        $panel = new class extends Panel
        {
            public ?string $titleSet = null;

            public function title($title = null): void
            {
                $this->titleSet = $title;
            }
        };

        $panel->init();

        $this->assertSame('Console', $panel->titleSet);
    }
}
