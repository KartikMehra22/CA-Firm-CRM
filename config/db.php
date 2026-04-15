<?php
/**
 * Database Configuration
 * Returns a PDO connection to the ca_firm database.
 */

$host = '127.0.0.1'; // Use IP instead of 'localhost' to force TCP (avoids macOS socket errors)
$db   = 'ca_firm';
$user = 'root';
$pass = 'root'; // Update this if you set a different password during MySQL reset
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    return new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // In a production environment, you would log this instead of outputting it
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
