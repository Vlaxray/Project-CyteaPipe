<?php
// db.php - Configurazione connessione database

// 1. Avvia la sessione PRIMA di qualsiasi output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// 2. Configurazione database
$host = 'localhost';
$dbname = 'cigar_tobacco_tea_app';
$username = 'root';
$password = ''; // Se usi XAMPP, la password è spesso vuota
$charset = 'utf8mb4';

// 3. Stringa di connessione
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // 4. Crea la connessione PDO
    $pdo = new PDO($dsn, $username, $password, $options);
    
    // 5. Crea la tabella users se non esiste (opzionale)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
} catch (\PDOException $e) {
    // 6. Gestione degli errori più dettagliata
    die("Errore di connessione al database: " . $e->getMessage());
}
