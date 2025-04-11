<?php
require '/xampp/htdocs/mydashboard/CyteaPipe/db.php';
// 1. Avvia la sessione PRIMA di qualsiasi output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Gestione registrazione utente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $email, $password]);
        
        $registration_success = "🎩 Registrazione completata con stile! Ora puoi accedere.";
    } catch (PDOException $e) {
        $registration_error = "🤠 Ops! Qualcosa è andato storto: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
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
            linear-gradient(rgba(43, 29, 25, 0.95), rgba(43, 29, 25, 0.95));
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
        margin-bottom: 3rem;
    }

    .logo {
        font-size: 2.5rem;
        color: var(--rich-amber);
        text-decoration: none;
        font-weight: bold;
    }

    .main-title {
        text-align: center;
        font-size: 4rem;
        margin: 2rem 0;
        color: var(--rich-amber);
        text-shadow: 2px 2px var(--dark-leaf);
    }

    .subtitle {
        text-align: center;
        font-size: 1.5rem;
        margin-bottom: 3rem;
        font-family: 'Cormorant Garamond', serif;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .btn {
        padding: 1rem 2rem;
        border: none;
        border-radius: 6px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: var(--rich-amber);
        color: var(--dark-leaf);
    }

    .btn-primary:hover {
        background: var(--warm-parchment);
        transform: translateY(-3px);
    }

    .btn-secondary {
        background: var(--dark-leaf);
        color: var(--warm-parchment);
        border: 1px solid var(--rich-amber);
    }

    .btn-secondary:hover {
        background: var(--deep-brown);
        transform: translateY(-3px);
    }

    .search-container {
        max-width: 800px;
        margin: 0 auto 3rem;
        position: relative;
    }

    .search-form {
        display: flex;
        gap: 1rem;
    }

    .search-input {
        flex: 1;
        padding: 1rem;
        border: 1px solid var(--rich-amber);
        background: rgba(255, 255, 255, 0.05);
        color: var(--warm-parchment);
        font-family: 'Playfair Display', serif;
        border-radius: 4px;
        font-size: 1rem;
    }

    .search-btn {
        padding: 0 1.5rem;
        background: var(--rich-amber);
        color: var(--dark-leaf);
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: rgba(30, 20, 18, 0.95);
        border: 1px solid var(--rich-amber);
        border-radius: 12px;
        padding: 2.5rem;
        width: 100%;
        max-width: 500px;
        position: relative;
    }

    .close-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--rich-amber);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--rich-amber);
    }

    .form-group input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--rich-amber);
        background: rgba(255, 255, 255, 0.05);
        color: var(--warm-parchment);
        border-radius: 4px;
    }

    .submit-btn {
        width: 100%;
        padding: 1rem;
        background: var(--rich-amber);
        color: var(--dark-leaf);
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }

    .message {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 4px;
        text-align: center;
    }

    .success {
        background: rgba(214, 167, 92, 0.15);
        border-left: 4px solid var(--rich-amber);
        color: var(--tea-green);
    }

    .error {
        background: rgba(200, 0, 0, 0.15);
        border-left: 4px solid #ff0000;
        color: #ff9999;
    }

    .features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 4rem;
    }
    .feature-card {
    background: rgba(30, 20, 18, 0.95);
    border: 1px solid var(--rich-amber);
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    color: var(--warm-parchment);
    margin-bottom: 2rem;
}

.feature-card:hover {
    transform: scale(1.02);
    box-shadow: 0 15px 30px rgba(0,0,0,0.6);
}

.feature-image img {
    width: 100%;
    max-height: 200px;
    object-fit: cover;
    border-radius: 6px;
    border: 0.2px solid var(--rich-amber);
}

.feature-icon {
    font-size: 2rem;
    color: var(--tea-green);
    margin: 1rem 0 0.5rem;
}
/* Aggiungi al tuo stile esistente */
.btn-secondary {
    background: rgba(214, 167, 92, 0.2);
    color: var(--rich-amber);
    border: 1px solid var(--rich-amber);
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: var(--rich-amber);
    color: var(--dark-leaf);
    transform: translateY(-2px);
}
.feature-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem;
    color: var(--rich-amber);
    margin-bottom: 0.5rem;
}

.feature-description {
    font-size: 1rem;
    line-height: 1.5;
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
    <h1 class="logo">Tè e Tabacco<h1/>
    <div>
        <?php if(isset($_SESSION['logged_in'])): ?>
            <span style="color: var(--rich-amber); margin-right: 1rem;">
                <i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['username']) ?>
            </span>
            <a href="/xampp/htdocs/mydashboard/CyteaPipe/logout.php class="btn btn-secondary">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        <?php else: ?>
            <button id="loginBtn" class="btn btn-secondary" style="margin-bottom: 1rem;">
                <a href="http://localhost/mydashboard/CyteaPipe/login.php" style="color: var(--rich-amber); text-decoration: none;">
                <i class="fas fa-sign-in-alt"></i> Login
            </a></button>
            <button id="registerBtn" class="btn btn-secondary" style="margin-bottom: 1rem;">
            <i class="fas fa-user-plus"></i> Registrati
        </button>
        <?php endif; ?>
    </div>
</header>
        <h1 class="main-title" >Benvenuto!</h1>
        <p class="subtitle">L'essenza di ogni attimo catturata per sempre</p>

        <?php if(isset($registration_success)): ?>
            <div class="message success">
                <i class="fas fa-star"></i> <?= $registration_success ?>
            </div>
        <?php endif; ?>

        <?php if(isset($registration_error)): ?>
            <div class="message error">
                <i class="fas fa-exclamation-triangle"></i> <?= $registration_error ?>
            </div>
        <?php endif; ?>

        <div class="action-buttons">
            <a href="aggiungi.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Aggiungi
            </a>
            <a href="/mydashboard/CyteaPipe/products.php" class="btn btn-secondary">
                <i class="fas fa-list"></i> Visualizza Archivio
            </a>
        </div>

        <div class="search-container">
            <form action="products.php" method="GET" class="search-form">
                <input type="text" name="search" class="search-input" placeholder="Cerca prodotti...">
                <select name="category" class="search-input">
                    <option value="">Tutte le categorie</option>
                    <?php 
                    $categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="rating" class="search-input">
                    <option value="">Qualsiasi valutazione</option>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?> ⭐</option>
                    <?php endfor; ?>
                </select>
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i> Cerca
                </button>
            </form>
        </div>

        <div class="features">
            <div class="feature-card">
            <div class="feature-image">
                <img src="close-up-metallic-cigar-ring.jpg" alt="Tè e relax" img-size="fit">
                </div>
                <div class="feature-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3 class="feature-title">Tabacchi Preferiti</h3>
                <p>Annota i tabacchi e i sigari che hai preferito o quelli che non ti sono piaciuti</p>
            </div>
            <div class="feature-card">
            <div class="feature-image">
                <img src="delicious-terere-drink-still-life.jpg" alt="Tè e relax">
                </div>
                <div class="feature-icon">
                    <i class="fas fa-mug-hot"></i>
                </div>
                <h3 class="feature-title">Tè ed altro</h3>
                <p class="feature-description">Registra gli infusi che ti hanno dato la carica giusta</p>
            </div>

            <div class="feature-card">
            <div class="feature-image">
                <img src="coppa.jpg" alt="Tè e relax">
                </div>
                <div class="feature-icon">
                    <i class="fas fa-award"></i>
                </div>
                <h3 class="feature-title">Cerca nella banca dati</h3>
                <p>I prodotti che hai salvato nel diario per tipo o valutazione!</p>
            </div>
        </div>
    </div>

    <!-- Modal Registrazione -->
    <div class="modal" id="registerModal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2 style="text-align: center; color: var(--rich-amber); margin-bottom: 2rem;">Registrazione</h2>
            <form method="POST" action="">
                <input type="hidden" name="register" value="1">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-user-plus"></i> Registrati
                </button>
            </form>
        </div>
    </div>
<footer><?php include 'footer.php'; ?></footer>
    <script>
        // Gestione modal registrazione
        const modal = document.getElementById('registerModal');
        const registerBtn = document.getElementById('registerBtn');
        const closeBtn = document.querySelector('.close-btn');

        registerBtn.addEventListener('click', () => {
            modal.style.display = 'flex';
        });

        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Animazione per i messaggi
        const messages = document.querySelectorAll('.message');
        messages.forEach(msg => {
            setTimeout(() => {
                msg.style.transition = 'opacity 0.8s ease';
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 1000);
            }, 5000);
        });
    </script>
</body>
</html>