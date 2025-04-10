<?php
require 'db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);

    // Dopo l'eliminazione, torna alla pagina principale
    header("Location: products.php"); // cambia il nome se il tuo file è diverso
    exit;
} else {
    echo "ID non valido.";
}
