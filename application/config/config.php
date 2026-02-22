<?php
/**
 * Application Configuration
 */

$config = [
    'base_url'        => getenv('APP_BASE_URL') ?: 'http://localhost:8080/',
    'site_title'      => 'CorpFile',
    'encryption_key'  => 'tw_sec_2024_corporate_key',
    'csrf_protection' => true,
    'csrf_token_name' => 'ci_csrf_token',
    'session_expiry'  => 7200, // 2 hours
    
    // reCAPTCHA v3 keys (replace with your own)
    'recaptcha_site_key'   => '6Lf2dhQjAAAAADDUnWcjXlCwDvOtGnL5ifJ3FMbe',
    'recaptcha_secret_key' => 'YOUR_RECAPTCHA_SECRET_KEY',
    
    // Upload settings
    'upload_path'     => BASEPATH . 'uploads/',
    'max_file_size'   => 10485760, // 10MB
    
    // Pagination
    'per_page'        => 25,
    
    // Company logo path
    'company_logo'    => 'public/images/company_logo.png',
    
    // Firebase Authentication
    'firebase' => [
        'apiKey'            => 'AIzaSyCCLaJJ0ZIAYRi18R7N0N0HoqHgbqATRlY',
        'authDomain'        => 'teamwork-demo-1771579077.firebaseapp.com',
        'projectId'         => 'teamwork-demo-1771579077',
        'appId'             => '1:200625340749:web:5c8475fd2721533dddf704',
    ],
];

// Make config globally accessible
$GLOBALS['config'] = $config;

function config_item($key) {
    return isset($GLOBALS['config'][$key]) ? $GLOBALS['config'][$key] : null;
}

function base_url($path = '') {
    return rtrim($GLOBALS['config']['base_url'], '/') . '/' . ltrim($path, '/');
}

function site_url($path = '') {
    return base_url($path);
}
