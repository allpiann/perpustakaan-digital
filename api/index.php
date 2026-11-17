<?php

// Filesystem Vercel read-only kecuali /tmp: pindahkan semua folder tulis Laravel ke sana.
$tmp = '/tmp';

foreach ([
    "$tmp/storage/framework/views",
    "$tmp/storage/framework/cache/data",
    "$tmp/storage/framework/sessions",
    "$tmp/storage/logs",
    "$tmp/bootstrap/cache",
] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

$env = [
    'LARAVEL_STORAGE_PATH' => "$tmp/storage",
    'VIEW_COMPILED_PATH'   => "$tmp/storage/framework/views",
    'APP_CONFIG_CACHE'     => "$tmp/bootstrap/cache/config.php",
    'APP_EVENTS_CACHE'     => "$tmp/bootstrap/cache/events.php",
    'APP_PACKAGES_CACHE'   => "$tmp/bootstrap/cache/packages.php",
    'APP_ROUTES_CACHE'     => "$tmp/bootstrap/cache/routes.php",
    'APP_SERVICES_CACHE'   => "$tmp/bootstrap/cache/services.php",
];

foreach ($env as $key => $value) {
    putenv("$key=$value");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

// Teruskan ke pintu masuk Laravel
require __DIR__ . '/../public/index.php';