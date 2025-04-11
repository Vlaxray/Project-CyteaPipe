<?php
// db.php - Configurazione connessione database
// 2. Configurazione database
$host = 'localhost';
$dbname = 'cigar_tobacco_tea_app';
$username = 'root';
$password = ''; // Se usi XAMPP, la password è spesso vuota
$charset = 'utf8mb4';



try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connessione fallita: " . $e->getMessage();
    $conn = null;
}
?>