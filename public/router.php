<?php

if (php_sapi_name() === 'cli-server') {
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $path = parse_url($uri, PHP_URL_PATH) ?: '/';

    // Normalize double-slashes caused by ASSET_URL with trailing slash
    $path = '/' . ltrim($path, '/');

    $file = __DIR__ . $path;

    if ($path !== '/' && is_file($file)) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $mimes = [
            'css'   => 'text/css',
            'js'    => 'application/javascript',
            'mjs'   => 'application/javascript',
            'png'   => 'image/png',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'gif'   => 'image/gif',
            'webp'  => 'image/webp',
            'svg'   => 'image/svg+xml',
            'ico'   => 'image/x-icon',
            'woff'  => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf'   => 'font/ttf',
            'otf'   => 'font/otf',
            'eot'   => 'application/vnd.ms-fontobject',
            'json'  => 'application/json',
            'map'   => 'application/json',
            'txt'   => 'text/plain',
            'xml'   => 'application/xml',
        ];

        if (isset($mimes[$ext])) {
            header('Content-Type: ' . $mimes[$ext]);
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }

        return false;
    }
}

require __DIR__ . '/index.php';
