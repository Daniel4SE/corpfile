<?php
/**
 * PHP Built-in Server Router
 * 
 * Usage: php -S localhost:8080 router.php
 * 
 * Serves static files from /public directly, routes everything else to index.php
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Serve static files from /public directory
if (preg_match('#^/public/#', $uri)) {
    $filePath = __DIR__ . $uri;
    if (file_exists($filePath) && is_file($filePath)) {
        // Set appropriate content type
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $mimeTypes = [
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif'  => 'image/gif',
            'svg'  => 'image/svg+xml',
            'ico'  => 'image/x-icon',
            'woff' => 'font/woff',
            'woff2'=> 'font/woff2',
            'ttf'  => 'font/ttf',
            'eot'  => 'application/vnd.ms-fontobject',
            'map'  => 'application/json',
            'json' => 'application/json',
        ];
        if (isset($mimeTypes[$ext])) {
            header('Content-Type: ' . $mimeTypes[$ext]);
        }
        readfile($filePath);
        return true;
    }
}

// Serve uploaded files
if (preg_match('#^/uploads/#', $uri)) {
    $filePath = __DIR__ . $uri;
    if (file_exists($filePath) && is_file($filePath)) {
        // Don't serve PHP files from uploads
        if (pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
            http_response_code(403);
            echo 'Forbidden';
            return true;
        }
        return false; // Let PHP built-in server handle it
    }
}

// Route everything else through index.php
require __DIR__ . '/index.php';
