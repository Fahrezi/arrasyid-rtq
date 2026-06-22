<?php

// Serve existing static files (JS, CSS, images, etc.) directly with correct MIME types
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

require __DIR__ . '/index.php';
