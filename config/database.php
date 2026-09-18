<?php
/**
 * Configuration de la base de données MySQL
 */

return [
    APP_URL="https://ongalhikmah.infinityfreeapp.com"
    'driver' => 'mysql',
    'host'     => $_ENV['DB_HOST'] ?? 'sql208.infinityfree.com',
    'port'     => (int) ($_ENV['DB_PORT'] ?? 3306),
    'database' => $_ENV['DB_NAME'] ?? 'if0_42942784_ong_crm',
    'username' => $_ENV['DB_USER'] ?? 'if0_42942784',
    'password' => $_ENV['DB_PASS'] ?? 'Bonjour07092026',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
    ]
];
