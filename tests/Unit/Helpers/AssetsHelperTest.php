<?php

namespace Tests\Unit\Helpers;

use Brain\Monkey;
use Brain\Monkey\Functions;
use DebugBarConsole\Helpers\AssetsHelper;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\TestCase;

class AssetsHelperTest extends TestCase
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

    public function testGetAssetUrlCallsPluginsUrl(): void
    {
        Functions\expect('plugins_url')
            ->once()
            ->with('assets/css/style.css', \DebugBarConsole::FILE)
            ->andReturn('https://example.com/plugins/debug-bar-console/assets/css/style.css');

        $result = AssetsHelper::getAssetUrl('assets/css/style.css', false);

        $this->assertSame(
            'https://example.com/plugins/debug-bar-console/assets/css/style.css',
            $result
        );
    }

    public function testGetAssetUrlPassesThroughPathWhenScriptDebugNotDefined(): void
    {
        Functions\expect('plugins_url')
            ->once()
            ->andReturnUsing(fn ($path) => 'https://example.com/'.$path);

        $result = AssetsHelper::getAssetUrl('assets/css/style.min.css', true);

        $this->assertStringContainsString('assets/css/style.min.css', $result);
        $this->assertStringNotContainsString('src/', $result);
    }

    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function testGetAssetUrlConvertsToSrcPathWhenScriptDebugTrue(): void
    {
        define('SCRIPT_DEBUG', true);

        Functions\expect('plugins_url')
            ->once()
            ->andReturnUsing(fn ($path) => 'https://example.com/'.$path);

        $result = AssetsHelper::getAssetUrl('assets/css/style.min.css', true);

        $this->assertStringContainsString('src/', $result);
    }

    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function testGetAssetUrlStripsMinSuffixInDevMode(): void
    {
        define('SCRIPT_DEBUG', true);

        Functions\expect('plugins_url')
            ->once()
            ->andReturnUsing(fn ($path) => 'https://example.com/'.$path);

        $result = AssetsHelper::getAssetUrl('assets/css/style.min.css', true);

        $this->assertStringNotContainsString('.min', $result);
        $this->assertStringContainsString('style.css', $result);
    }

    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function testGetAssetUrlIgnoresScriptDebugWhenAllowDevFalse(): void
    {
        define('SCRIPT_DEBUG', true);

        Functions\expect('plugins_url')
            ->once()
            ->andReturnUsing(fn ($path) => 'https://example.com/'.$path);

        $result = AssetsHelper::getAssetUrl('assets/css/style.min.css', false);

        $this->assertStringNotContainsString('src/', $result);
        $this->assertStringContainsString('style.min.css', $result);
    }
}
