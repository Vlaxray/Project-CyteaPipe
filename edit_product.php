<?php
require '../CyteaPipe/db.php';
require '../CyteaPipe/ProductModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Controlla l'esistenza e la validità dell'ID
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo "ID prodotto non valido.";
        exit;
    }

    $id = (int)$_GET['id'];
    // Recupera il prodotto tramite una funzione definita nel modello
    $product = getProductById($pdo, $id);

    if (!$product) {
        echo "Prodotto non trovato.";
        exit;
    }
    ?>

    <!DOCTYPE html>
    <html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Modifica Prodotto</title>
    </head>
    <body>
        <h1>Modifica Prodotto</h1>
        <form method="POST" action="edit_product.php">
            <!-- Campo nascosto per l'ID del prodotto -->
            <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">

            <p>
                <label>Nome: 
                    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                </label>
            </p>
            <p>
                <label>Marca: 
                    <input type="text" name="brand" value="<?= htmlspecialchars($product['brand']) ?>">
                </label>
            </p>
            <p>
                <label>Origine: 
                    <input type="text" name="origin" value="<?= htmlspecialchars($product['origin']) ?>">
                </label>
            </p>
            <p>
                <label>Aroma: 
                    <input type="text" name="aroma" value="<?= htmlspecialchars($product['aroma']) ?>">
                </label>
            </p>
            <p>
                <label>Descrizione: 
                    <textarea name="description" rows="4" cols="50"><?= htmlspecialchars($product['description']) ?></textarea>
                </label>
            </p>
            <p>
                <label>Rating: 
                    <input type="number" name="rating" value="<?= htmlspecialchars($product['rating']) ?>" min="1" max="5">
                </label>
            </p>
            <!-- Se necessario, aggiungi altri campi come l'URL dell'immagine o la categoria -->
            
            <p>
                <button type="submit">Aggiorna Prodotto</button>
            </p>
        </form>
    </body>
    </html>

    <?php
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Elabora i dati inviati dal form per aggiornare il prodotto
    $id = (int)$_POST['id'];
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $origin = $_POST['origin'];
    $aroma = $_POST['aroma'];
    $description = $_POST['description'];
    $rating = (int)$_POST['rating'];

    try {
        // Prepariamo e eseguiamo la query di aggiornamento
        $stmt = $pdo->prepare("UPDATE products SET name = ?, brand = ?, origin = ?, aroma = ?, description = ?, rating = ? WHERE id = ?");
        $stmt->execute([$name, $brand, $origin, $aroma, $description, $rating, $id]);

        // Dopo l'aggiornamento, reindirizza alla pagina dei prodotti (modifica il percorso se necessario)
        header("Location: products.php");
        exit;
    } catch (PDOException $e) {
        echo "Errore nell'aggiornamento del prodotto: " . $e->getMessage();
    }
}
?>
