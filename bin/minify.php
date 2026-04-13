<?php

/**
 * Minifies plugin CSS and JS assets.
 *
 * Usage: composer minify
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use MatthiasMullie\Minify\CSS;
use MatthiasMullie\Minify\JS;

$root = dirname(__DIR__);

$assets = [
    'css' => [
        "{$root}/src/assets/css/debug-bar-console.css" => "{$root}/assets/css/debug-bar-console.min.css",
        "{$root}/assets/css/iframe.css"                => "{$root}/assets/css/iframe.min.css",
    ],
    'js' => [
        "{$root}/src/assets/js/debug-bar-console.js" => "{$root}/assets/js/debug-bar-console.min.js",
    ],
];

foreach ($assets['css'] as $source => $output) {
    (new CSS($source))->minify($output);
    echo "Minified: {$source}\n       -> {$output}\n";
}

foreach ($assets['js'] as $source => $output) {
    (new JS($source))->minify($output);
    echo "Minified: {$source}\n       -> {$output}\n";
}

echo "Done.\n";
