
<?php

// Load konfigurasi aplikasi
require_once __DIR__ . '/../app/config/config.php';

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load helper
require_once ROOT_PATH . '/app/core/helpers.php';

// Load database
require_once ROOT_PATH . '/database/koneksi-teks.php';
require_once ROOT_PATH . '/database/Model.php';

// Autoload class aplikasi
spl_autoload_register(function ($class) {
    $directories = ['core', 'controllers', 'models'];

    foreach ($directories as $dir) {
        $file = ROOT_PATH . '/app/' . $dir . '/' . $class . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Routing URL
if (!isset($_GET['url'])) {
    $uri = parse_url(
        $_SERVER['REQUEST_URI'] ?? '/',
        PHP_URL_PATH
    );

    $basePath = str_replace(
        '\\',
        '/',
        dirname($_SERVER['SCRIPT_NAME'] ?? '')
    );

    if ($basePath !== '/' && str_starts_with($uri, $basePath)) {
        $uri = substr($uri, strlen($basePath));
    }

    $_GET['url'] = trim((string) $uri, '/');
}

// Jalankan aplikasi
new App();
