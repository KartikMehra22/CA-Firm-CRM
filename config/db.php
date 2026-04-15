<?php
/**
 * Database Configuration
 * Returns a PDO connection to the ca_firm database.
 */

$host = 'localhost';
$db   = 'ca_firm';
$user = 'root';
$pass = ''; // Default password for local development
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
