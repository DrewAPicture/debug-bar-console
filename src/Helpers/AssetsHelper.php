<?php

/**
 * Assets Helpers
 *
 * @since   1.0.0
 */

namespace DebugBarConsole\Helpers;

// Bail if accessed directly
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Assets helper class.
 *
 * @since 1.0.0
 */
class AssetsHelper
{
    /**
     * Gets a SCRIPT_DEBUG-aware asset URL.
     *
     * @since 1.0.0
     *
     * @param  string  $assetPath  Relative asset path.
     * @param  bool  $allowDev  Whether to allow returning development asset URLs.
     */
    public static function getAssetUrl(
        string $assetPath,
        bool $allowDev = true
    ): string {
        $assetPath = self::maybeConvertToSrc($assetPath, $allowDev);

        return plugins_url($assetPath, \DebugBarConsole::FILE);
    }

    /**
     * (Maybe) converts the asset path to src/.
     *
     * @since 1.0.0
     */
    protected static function maybeConvertToSrc(
        string $assetPath,
        bool $allowDev = true
    ): string {
        $useSrc = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG;

        // Use source instead.
        if ($allowDev === true && $useSrc) {
            $assetPath = 'src/'.str_replace('.min', '', $assetPath);
        }

        return $assetPath;
    }
}
