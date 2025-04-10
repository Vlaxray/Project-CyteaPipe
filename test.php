<?php
$host = 'localhost';
$user = 'root';  // Nome utente predefinito di MySQL
$password = '';  // Password predefinita di MySQL (vuota in XAMPP)
$dbname = 'prodotto';  // Nome del database che hai creato

// Creazione della connessione
$conn = new mysqli($host, $user, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

echo "Connessione al database riuscita!";
?>
