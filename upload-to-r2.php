<?php

define('BASEPATH', __DIR__ . '/');
define('APPPATH', BASEPATH . 'application/');

require_once APPPATH . 'libraries/R2Storage.php';

$sourceDir = BASEPATH . 'scraped-files/';
$r2 = new R2Storage();

if (!$r2->isConfigured()) {
    fwrite(STDERR, "R2 is not configured. Set R2_ENDPOINT, R2_BUCKET, R2_ACCESS_KEY_ID, and R2_SECRET_ACCESS_KEY.\n");
    exit(1);
}

if (!is_dir($sourceDir)) {
    fwrite(STDERR, "Directory not found: {$sourceDir}\n");
    exit(1);
}

$items = scandir($sourceDir);
if ($items === false) {
    fwrite(STDERR, "Unable to read directory: {$sourceDir}\n");
    exit(1);
}

$uploaded = 0;
$skipped = 0;
$failed = 0;

foreach ($items as $item) {
    if ($item === '.' || $item === '..') {
        continue;
    }

    $filePath = $sourceDir . $item;
    if (!is_file($filePath)) {
        $skipped++;
        continue;
    }

    $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($item));
    if ($safeName === '' || $safeName === null) {
        $safeName = uniqid('doc_', true);
    }

    $key = 'documents/' . $safeName;
    $contentType = function_exists('mime_content_type') ? mime_content_type($filePath) : 'application/octet-stream';

    $ok = $r2->upload($key, $filePath, $contentType ?: 'application/octet-stream');
    if ($ok) {
        $uploaded++;
        fwrite(STDOUT, "Uploaded: {$item} -> {$key}\n");
    } else {
        $failed++;
        fwrite(STDERR, "Failed: {$item}\n");
    }
}

fwrite(STDOUT, "Done. Uploaded: {$uploaded}, Failed: {$failed}, Skipped: {$skipped}\n");
exit($failed > 0 ? 1 : 0);
