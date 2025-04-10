<?php
// Include la connessione al database e il modello del prodotto
require '../CyteaPipe/db.php';
require '../CyteaPipe/ProductModel.php';

// Imposta l'intestazione per il formato JSON
header("Content-Type: application/json");

// Recupera i prodotti dal database tramite il modello
try {
    $products = getAllProducts($pdo);
    if ($products) {
        // Restituisce i prodotti in formato JSON
        echo json_encode($products);
    } else {
        // Nessun prodotto trovato
        echo json_encode(['message' => 'Nessun prodotto trovato']);
    }
} catch (PDOException $e) {
    // Se c'è un errore nel database, restituisci un messaggio di errore
    echo json_encode(['error' => 'Errore nel recupero dei dati: ' . $e->getMessage()]);
}
?>
