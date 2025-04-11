<?php
session_start();

require  '/xampp/htdocs/mydashboard/CyteaPipe/db.php';
require '/xampp/htdocs/mydashboard/CyteaPipe/auth_check.php';
// Recupera tutti i prodotti con nome categoria
$sql = "SELECT products.*, categories.name AS category_name 
        FROM products 
        LEFT JOIN categories ON products.category_id = categories.id
        ORDER BY products.created_at DESC";

$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="it">
<head>
<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
<link rel="manifest" href="favicon/site.webmanifest">
    <meta charset="UTF-8">
    <title>Tè e Tabacco</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600&family=Playfair+Display:wght@700&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --deep-brown: #3B2F2F;
        --rich-amber: #D6A75C;
        --warm-parchment: #F1E6D6;
        --shadow-smoke: rgba(0,0,0,0.5);
        --dark-leaf: #2E1F1F;
        --tea-green: #A5A58D;
    }

    body {
        font-family: 'Playfair Display', serif;
        background: 
            linear-gradient(rgba(43, 29, 25, 0.95), rgba(43, 29, 25, 0.95)),
            url('https://images.unsplash.com/photo-1617196031260-dc9bd8f6d4db?auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-blend-mode: overlay;
        color: var(--warm-parchment);
        margin: 0;
        min-height: 100vh;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid var(--rich-amber);
        margin-bottom: 2rem;
    }

    .logo {
        font-size: 2rem;
        color: var(--rich-amber);
        text-decoration: none;
        font-weight: bold;
    }

    h1 {
        text-align: center;
        font-size: 2.8rem;
        margin: 2rem 0;
        color: var(--rich-amber);
        border-bottom: 2px solid var(--rich-amber);
        padding-bottom: 1rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: var(--rich-amber);
        color: var(--dark-leaf);
        border: none;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }

    .btn:hover {
        background: var(--warm-parchment);
        transform: translateY(-2px);
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .product-card {
        background: rgba(30, 20, 18, 0.8);
        border: 1px solid var(--rich-amber);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.4);
    }

    .product-actions {
        position: absolute;
        top: 1rem;
        right: 1rem;
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        background: rgba(214, 167, 92, 0.2);
        border: 1px solid var(--rich-amber);
        color: var(--rich-amber);
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        background: var(--rich-amber);
        color: var(--dark-leaf);
    }

    .product-category {
        display: inline-block;
        background: var(--dark-leaf);
        color: var(--rich-amber);
        padding: 0.25rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        margin-bottom: 1rem;
    }

    .product-name {
        font-size: 1.8rem;
        margin: 0.5rem 0;
        color: var(--rich-amber);
        border-bottom: 1px solid var(--rich-amber);
        padding-bottom: 0.5rem;
    }

    .product-brand {
        font-size: 1.1rem;
        color: var(--tea-green);
        margin-bottom: 0.5rem;
        font-style: italic;
    }

    .product-detail {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .product-detail i {
        color: var(--rich-amber);
        width: 20px;
    }

    .product-rating {
        margin: 1rem 0;
    }

    .product-description {
        font-size: 1rem;
        line-height: 1.6;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px dashed var(--rich-amber);
    }

    .empty-message {
        text-align: center;
        font-size: 1.5rem;
        color: var(--tea-green);
        margin: 3rem 0;
        grid-column: 1 / -1;
    }

    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 1rem;
        border: 1px solid var(--rich-amber);
    }
    </style>
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
    <div class="container">
    <header>
    <a href="landing.php" class="logo">Western Chanel</a>
    <div>
        <?php if(isset($_SESSION['logged_in'])): ?>
            <span style="color: var(--rich-amber); margin-right: 1rem;">
                <i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['username']) ?>
            </span>
            <a href="logout.php" class="btn btn-secondary">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        <?php else: ?>
            <a href="login.php" class="btn btn-secondary">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        <?php endif; ?>
    </div>
</header>

        <h1>Archivio</h1>

        <?php if (count($products) === 0): ?>
            <div class="empty-message">
                <i class="fas fa-box-open"></i> Nessun prodotto trovato
            </div>
        <?php else: ?>
            <div class="products-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="product-actions">
                            <a href="edit_product.php?id=<?= $product['id'] ?>" class="action-btn" title="Modifica">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="delete_product.php?id=<?= $product['id'] ?>" class="action-btn" title="Elimina" onclick="return confirm('Sei sicuro di voler eliminare questo prodotto?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>

                        <?php if (!empty($product['image_url'])): ?>
                            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                        <?php endif; ?>

                        <div class="product-category">
                            <?= htmlspecialchars($product['category_name']) ?>
                        </div>

                        <h2 class="product-name"><?= htmlspecialchars($product['name']) ?></h2>

                        <div class="product-brand">
                            <?= htmlspecialchars($product['brand']) ?>
                        </div>

                        <div class="product-detail">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?= htmlspecialchars($product['origin']) ?></span>
                        </div>

                        <div class="product-detail">
                            <i class="fas fa-wind"></i>
                            <span><?= htmlspecialchars($product['aroma']) ?></span>
                        </div>

                        <div class="product-rating">
                            <?php
                                $rating = (int)$product['rating'];
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $rating ? "⭐" : "☆";
                                }
                            ?>
                        </div>

                        <div class="product-description">
                            <?= nl2br(htmlspecialchars($product['description'])) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <footer><?php include '/xampp/htdocs/mydashboard/CyteaPipe/frontend/footer.php'; ?></footer>
</body>
</html>