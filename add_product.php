<?php
require 'db.php'; // Connessione al DB

// Carica le categorie per il dropdown
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Se il form è stato inviato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $origin = $_POST['origin'];
    $aroma = $_POST['aroma'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];
    

    $sql = "INSERT INTO products (category_id, name, brand, origin, aroma, description, rating) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$category_id, $name, $brand, $origin, $aroma, $description, $rating]);

    echo "<p style='color:green;'>✅ Prodotto aggiunto con successo!</p>";
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Aggiungi Prodotto</title>
</head>
<body>
    <h1>Aggiungi un nuovo prodotto</h1>
    <form method="POST" action="">
        <label>Categoria:</label><br>
        <select name="category_id" required>
            <option value="">-- Seleziona --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Nome:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Marca:</label><br>
        <input type="text" name="brand"><br><br>

        <label>Origine:</label><br>
        <input type="text" name="origin"><br><br>

        <label>Aroma:</label><br>
        <input type="text" name="aroma"><br><br>

        <label>Descrizione:</label><br>
        <textarea name="description" rows="5" cols="40"></textarea><br><br>

        <label>Valutazione (1-5):</label><br>
        <select name="rating" required>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?> ⭐</option>
            <?php endfor; ?>
        </select><br><br>

        <button type="submit">Aggiungi</button>
    </form>
</body>
</html>
