<?php
/**
 * Database Configuration
 */

$db_config = [
    'host'     => getenv('DB_HOST')     ?: 'localhost',
    'username' => getenv('DB_USER')     ?: 'root',
    'password' => getenv('DB_PASS')     ?: '',
    'database' => getenv('DB_NAME')     ?: 'corporate_secretary',
    'charset'  => 'utf8mb4',
    'port'     => (int)(getenv('DB_PORT') ?: 3306),
];

$GLOBALS['db_config'] = $db_config;
