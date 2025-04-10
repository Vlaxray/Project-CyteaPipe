<?php
require '/xampp/htdocs/mydashboard/CyteaPipe/db.php';

$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    $success_message = "🤠 Prodottò aggiuntò con stile!";
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title> Tè e Tabacco</title>
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
        max-width: 780px;
        margin: 5vh auto;
        padding: 2rem;
    }

    h1 {
        text-align: center;
        font-size: 3.2rem;
        margin-bottom: 2rem;
        color: var(--rich-amber);
        padding-bottom: 0.6rem;
        text-shadow: 1px 1px var(--dark-leaf);
    }

    h2 {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 2rem;
        color: var(--rich-amber);
        text-shadow: 1px 1px var(--dark-leaf); 
        border-bottom: 2px solid var(--rich-amber);
        padding-bottom: 0.69rem;
    }

    .luxury-card {
        background: rgba(30, 20, 18, 0.95);
        border: 1px solid var(--rich-amber);
        border-radius: 12px;
        padding: 2.5rem;
        box-shadow: 0 12px 35px var(--shadow-smoke);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .luxury-card:hover {
        transform: scale(1.01);
        box-shadow: 0 15px 40px rgba(0,0,0,0.6);
    }

    .form-group {
        margin-bottom: 1.8rem;
    }

    label {
        display: block;
        margin-bottom: 0.6rem;
        color: var(--rich-amber);
        font-size: 1.1rem;
        letter-spacing: 1px;
    }

    .background-slider {
    position: fixed;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: -1;
}

.background-track {
    display: flex;
    width: max-content;
    animation: slide-left 300s linear infinite; /* Cambia 60s per regolare la velocità */
}

.background-track img {
    height: 100vh;
    width: auto;
    object-fit: cover;
    flex-shrink: 0;
}

/* Animazione per far scorrere a sinistra */
@keyframes slide-left {
    from { transform: translateX(0); }
    to   { transform: translateX(-50%); }
}

    input, select, textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--rich-amber);
        background: rgba(255, 255, 255, 0.05);
        color: var(--warm-parchment);
        font-family: 'Playfair Display', serif;
        border-radius: 4px;
        font-size: 1rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input:focus, select:focus, textarea:focus {
        border-color: var(--tea-green);
        box-shadow: 0 0 8px var(--tea-green);
        outline: none;
    }

    textarea {
        resize: vertical;
        min-height: 120px;
    }

    .btn-submit {
        background: linear-gradient(to right, var(--dark-leaf), var(--rich-amber));
        color: var(--warm-parchment);
        border: none;
        padding: 1rem;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        cursor: pointer;
        border-radius: 6px;
        transition: background 0.3s ease, transform 0.2s ease;
        width: 100%;
    }

    .btn-submit:hover {
        background: linear-gradient(to right, var(--rich-amber), var(--dark-leaf));
        transform: scale(1.01);
    }

    .success-message {
        background: rgba(214, 167, 92, 0.15);
        border-left: 4px solid var(--rich-amber);
        padding: 1rem;
        margin-bottom: 2rem;
        font-size: 1.1rem;
        color: var(--tea-green);
        text-align: center;
    }
</style>

</head>
<body>
<div class="background-slider">
    <div class="background-track">
        <img src="close-up-metallic-cigar-ring.jpg" alt="Tè">
        <img src="delicious-terere-drink-still-life.jpg" alt="Tabacco">
        <img src="cigars_many.jpg" alt="Sigaro">
        <img src="close-up-metallic-cigar-ring.jpg" alt="Tè">
        <img src="delicious-terere-drink-still-life.jpg" alt="Tabacco">
        <img src="cigars_many.jpg" alt="Sigaro">
        <img src="close-up-metallic-cigar-ring.jpg" alt="Tè">
        <img src="delicious-terere-drink-still-life.jpg" alt="Tabacco">
        <img src="tea-winter-drink-burlap-fabric.jpg" alt="Sigaro">
        <img src="cigars_many.jpg" alt="Tè">
        <img src="delicious-terere-drink-still-life.jpg" alt="Tabacco">
        <img src="tea-winter-drink-burlap-fabric.jpg" alt="Sigaro">
        
        <!-- Ripeti le immagini per continuità -->
    </div>
</div>

    <div class="container">
    <?php if(isset($success_message)): ?>
    <div class="success-message" id="successMessage">
        <i class="fas fa-star"></i> <?= $success_message ?>
    </div>
<?php endif; ?>


        <h1>Tè e Tabacco</h1>
        <h2>Registra nell'archivio</h2>
        <div class="luxury-card">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="category_id"><i class="fas fa-tag"></i> CATEGORIA:</label>
                    <select name="category_id" id="category_id" required>
                        <option value="">-- Scegli --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>">
                                <?php 
                                    $icon_class = match($cat['name']) {
                                        'Tabacco' => 'tobacco-icon',
                                        'Sigari' => 'cigar-icon',
                                        'Tè' => 'tea-icon',
                                        default => ''
                                    };
                                ?>
                                <i class="fas fa-<?= 
                                    $cat['name'] === 'Tabacco' ? 'leaf' : 
                                    ($cat['name'] === 'Sigari' ? 'smoking' : 'mug-hot') 
                                ?> <?= $icon_class ?>"></i>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="name"><i class="fas fa-chess-queen"></i> NOME:</label>
                    <input type="text" name="name" id="name" required>
                </div>

                <div class="form-group">
                    <label for="brand"><i class="fas fa-crown"></i> MARCA:</label>
                    <input type="text" name="brand" id="brand">
                </div>

                <div class="form-group">
                    <label for="origin"><i class="fas fa-map-marked-alt"></i> ORIGINE:</label>
                    <input type="text" name="origin" id="origin">
                </div>

                <div class="form-group">
                    <label for="aroma"><i class="fas fa-wind"></i> AROMA:</label>
                    <input type="text" name="aroma" id="aroma">
                </div>

                <div class="form-group">
                    <label for="description"><i class="fas fa-scroll"></i> DESCRIZIONE:</label>
                    <textarea name="description" id="description" rows="5"></textarea>
                </div>

                <div class="form-group">
                    <label for="rating"><i class="fas fa-star"></i> VALUTAZIONE:</label>
                    <select name="rating" id="rating" required>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?> ⭐</option>
                        <?php endfor; ?>
                    </select>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-hat-cowboy"></i> AGGIUNGI PRODOTTO
                </button>
            </form>
        </div>
    </div>
    <footer><?php include 'footer.php'; ?></footer>
        <script>
        // Aggiunge un effetto hover alla card
        const luxuryCard = document.querySelector('.luxury-card');
        luxuryCard.addEventListener('mousemove', (e) => {
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;
            
            luxuryCard.style.boxShadow = `
                ${(x - 0.5) * 20}px ${(y - 0.5) * 20}px 30px rgba(0, 0, 0, 0.7),
                0 0 0 1px var(--chanel-gold)
            `;
        });
        
    const msg = document.getElementById('successMessage');
    if (msg) {
        setTimeout(() => {
            msg.style.transition = 'opacity 0.8s ease';
            msg.style.opacity = '0';
            setTimeout(() => msg.remove(), 1000); // rimuove l'elemento dopo la dissolvenza
        }, 8000);
    }


        luxuryCard.addEventListener('mouseleave', () => {
            luxuryCard.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.5)';
        });
    </script>
</body>
</html>