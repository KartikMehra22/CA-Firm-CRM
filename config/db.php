<?php
// DB connection — returns a PDO instance, just require() this file wherever needed
// Using 127.0.0.1 instead of localhost because macOS sometimes has socket issues with 'localhost'

$host    = '127.0.0.1';
$db      = 'ca_firm';
$user    = 'root';
$pass    = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   // throw exceptions on error, not silent failures
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,         // always get associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                     // use real prepared statements
];

try {
    return new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Don't expose DB errors to users in production — just log and die
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
