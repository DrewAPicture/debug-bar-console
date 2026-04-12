<?php

namespace Tests\Unit;

use Brain\Monkey;
use Brain\Monkey\Actions;
use Brain\Monkey\Functions;
use DebugBarConsole\PanelAjax;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PanelAjaxTest extends TestCase
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

    public function testInitRegistersAjaxAction(): void
    {
        Actions\expectAdded('wp_ajax_debug_bar_console')->once();

        (new PanelAjax)->init();

        $this->addToAssertionCount(1);
    }

    #[DataProvider('providerPrintMySqlTableReturnsEarlyForEmptyInput')]
    public function testPrintMySqlTableReturnsEarlyForEmptyInput(array $data): void
    {
        Functions\expect('esc_attr')->never();
        Functions\expect('esc_html')->never();

        ob_start();
        (new PanelAjax)->printMySqlTable($data);
        $output = ob_get_clean();

        $this->assertSame('', $output);
    }

    public static function providerPrintMySqlTableReturnsEarlyForEmptyInput(): \Generator
    {
        yield 'empty array' => [[]];
        yield 'first row is empty' => [[[]]];
    }

    public function testPrintMySqlTableOutputsTable(): void
    {
        Functions\stubs(['esc_attr', 'esc_html', 'esc_sql']);

        ob_start();
        (new PanelAjax)->printMySqlTable([['col' => 'val']]);
        $output = ob_get_clean();

        $this->assertStringContainsString('<table', $output);
        $this->assertStringContainsString('</table>', $output);
    }

    public function testPrintMySqlTableOutputsColumnHeaders(): void
    {
        Functions\stubs(['esc_attr', 'esc_html', 'esc_sql']);

        ob_start();
        (new PanelAjax)->printMySqlTable([['name' => 'Alice', 'email' => 'alice@example.com']]);
        $output = ob_get_clean();

        $this->assertStringContainsString('<th', $output);
        $this->assertStringContainsString('name', $output);
        $this->assertStringContainsString('email', $output);
    }

    public function testPrintMySqlTableOutputsRowValues(): void
    {
        Functions\stubs(['esc_attr', 'esc_html', 'esc_sql']);

        ob_start();
        (new PanelAjax)->printMySqlTable([['name' => 'Alice']]);
        $output = ob_get_clean();

        $this->assertStringContainsString('<td', $output);
        $this->assertStringContainsString('Alice', $output);
    }

    public function testPrintMySqlTableEscapesColumnKeys(): void
    {
        $xssKey = '<script>alert(1)</script>';

        Functions\expect('esc_attr')
            ->with($xssKey)
            ->andReturn(htmlspecialchars($xssKey));
        Functions\expect('esc_html')
            ->with($xssKey)
            ->andReturn(htmlspecialchars($xssKey));

        // esc_attr/esc_html also called for colspan and the query
        Functions\expect('esc_attr')->andReturnFirstArg();
        Functions\expect('esc_sql')->andReturnFirstArg();

        ob_start();
        (new PanelAjax)->printMySqlTable([[$xssKey => 'value']]);
        $output = ob_get_clean();

        $this->assertStringNotContainsString($xssKey, $output);
    }

    public function testPrintMySqlTableEscapesRowValues(): void
    {
        $xssValue = '<script>alert(1)</script>';

        Functions\expect('esc_html')
            ->with($xssValue)
            ->andReturn(htmlspecialchars($xssValue));
        Functions\expect('esc_html')->andReturnFirstArg();
        Functions\expect('esc_attr')->andReturnFirstArg();
        Functions\stubs(['esc_sql']);

        ob_start();
        (new PanelAjax)->printMySqlTable([['col' => $xssValue]]);
        $output = ob_get_clean();

        $this->assertStringNotContainsString($xssValue, $output);
    }

    public function testPrintMySqlTableRendersNonScalarValueAsEmptyString(): void
    {
        Functions\stubs(['esc_attr', 'esc_html', 'esc_sql']);

        ob_start();
        (new PanelAjax)->printMySqlTable([['col' => ['nested', 'array']]]);
        $output = ob_get_clean();

        // The cell should be present but contain no serialised array output
        $this->assertStringContainsString('<td', $output);
        $this->assertStringNotContainsString('nested', $output);
    }

    public function testPrintMySqlTableIncludesQueryInHeader(): void
    {
        Functions\stubs(['esc_attr', 'esc_html', 'esc_sql']);

        $query = 'SELECT * FROM wp_posts';

        ob_start();
        (new PanelAjax)->printMySqlTable([['ID' => '1']], $query);
        $output = ob_get_clean();

        $this->assertStringContainsString($query, $output);
    }

    public function testPrintMySqlTableUsesColumnCountForColspan(): void
    {
        Functions\stubs(['esc_attr', 'esc_html', 'esc_sql']);

        ob_start();
        (new PanelAjax)->printMySqlTable([['a' => '1', 'b' => '2', 'c' => '3']]);
        $output = ob_get_clean();

        $this->assertStringContainsString('colspan="3"', $output);
    }
}
