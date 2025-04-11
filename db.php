<?php
// db.php - Configurazione connessione database
// 2. Configurazione database
$host = 'localhost';
$dbname = 'cigar_tobacco_tea_app';
$username = 'root';
$password = ''; // Se usi XAMPP, la password è spesso vuota
$charset = 'utf8mb4';







$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}