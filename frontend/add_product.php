<?php
require 'db.php'; // Connessione al DB
require '/xampp/htdocs/mydashboard/CyteaPipe/auth_check.php';
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
    <link rel="preload" as="script" href="https://cdn.iubenda.com/cs/iubenda_cs.js"/>
<link rel="preload" as="script" href="https://cdn.iubenda.com/cs/tcf/stub-v2.js"/>
<script src="https://cdn.iubenda.com/cs/tcf/stub-v2.js"></script>
<script>
(_iub=self._iub||[]).csConfiguration={
	cookiePolicyId: 11202545,
	siteId: 3994511,
	localConsentDomain: 'teatabacco.altervista.org',
	timeoutLoadConfiguration: 30000,
	lang: 'it',
	enableTcf: true,
	tcfVersion: 2,
	tcfPurposes: {
		 "2": "consent_only",
		 "3": "consent_only",
		 "4": "consent_only",
		 "5": "consent_only",
		 "6": "consent_only",
		 "7": "consent_only",
		 "8": "consent_only",
		 "9": "consent_only",
		"10": "consent_only"
	},
	invalidateConsentWithoutLog: true,
	googleAdditionalConsentMode: true,
	consentOnContinuedBrowsing: false,
	banner: {
		position: "top",
		acceptButtonDisplay: true,
		customizeButtonDisplay: true,
		closeButtonDisplay: true,
		closeButtonRejects: true,
		fontSizeBody: "14px",
	},
}
</script>
<script async src="https://cdn.iubenda.com/cs/iubenda_cs.js"></script>
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
