<?php
// productModel.php

// Funzione per recuperare tutti i prodotti dal database
function getAllProducts(PDO $pdo) {
    // Query per ottenere i dati dei prodotti
    $sql = "SELECT products.*, categories.name AS category_name 
            FROM products 
            LEFT JOIN categories ON products.category_id = categories.id
            ORDER BY products.created_at DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Funzione per recuperare un prodotto per ID
function getProductById(PDO $pdo, $id) {
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Funzione per eliminare un prodotto dal database
function deleteProduct(PDO $pdo, $id) {
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id]);
}

// Funzione per aggiornare un prodotto
function updateProduct(PDO $pdo, $id, $name, $brand, $category_id, $origin, $aroma, $description, $rating, $image_url) {
    $sql = "UPDATE products SET 
            name = ?, 
            brand = ?, 
            category_id = ?, 
            origin = ?, 
            aroma = ?, 
            description = ?, 
            rating = ?, 
            image_url = ? 
            WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$name, $brand, $category_id, $origin, $aroma, $description, $rating, $image_url, $id]);
}
?>
