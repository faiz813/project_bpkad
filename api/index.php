<?php

// 1. Set environment indicators for serverless Vercel
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';
putenv('VERCEL=1');

// 2. Prepare writable temporary storage directory in /tmp
$storagePath = '/tmp/storage';
$dirs = [
    $storagePath . '/framework/views',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/logs',
    $storagePath . '/app/public',
    '/tmp/cache',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// 3. Set environment overrides for serverless read-only filesystem
putenv("APP_CONFIG_CACHE=/tmp/cache/config.php");
putenv("APP_EVENTS_CACHE=/tmp/cache/events.php");
putenv("APP_PACKAGES_CACHE=/tmp/cache/packages.php");
putenv("APP_ROUTES_CACHE=/tmp/cache/routes.php");
putenv("APP_SERVICES_CACHE=/tmp/cache/services.php");
putenv("VIEW_COMPILED_PATH={$storagePath}/framework/views");

// 4. Delegate to Laravel public entry point
require __DIR__ . '/../public/index.php';
