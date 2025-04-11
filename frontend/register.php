<?php
require '/xampp/htdocs/mydashboard/CyteaPipe/db.php';

// Avvia la sessione per i messaggi flash
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $email_confirm = trim($_POST['email_confirm']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Validazioni
    $errors = [];
    
    if (empty($username)) {
        $errors[] = "Il campo username è obbligatorio";
    } elseif (strlen($username) < 3) {
        $errors[] = "L'username deve essere di almeno 3 caratteri";
    }

    if (empty($email)) {
        $errors[] = "Il campo email è obbligatorio";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email inserita non è valida";
    } elseif ($email !== $email_confirm) {
        $errors[] = "Le email non corrispondono";
    }

    if (empty($password)) {
        $errors[] = "Il campo password è obbligatorio";
    } elseif (strlen($password) < 8) {
        $errors[] = "La password deve essere di almeno 8 caratteri";
    } elseif ($password !== $password_confirm) {
        $errors[] = "Le password non corrispondono";
    }

    if (empty($errors)) {
        try {
            // Verifica se l'utente esiste già
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                $errors[] = "Un utente con questa email esiste già";
            } else {
                // Crea la tabella users se non esiste
                $pdo->exec("
                    CREATE TABLE IF NOT EXISTS users (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        username VARCHAR(50) NOT NULL,
                        email VARCHAR(100) NOT NULL UNIQUE,
                        password VARCHAR(255) NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    )
                ");

                // Inserisce il nuovo utente
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                
                if ($stmt->execute([$username, $email, $hashedPassword])) {
                    $_SESSION['registration_success'] = "Registrazione completata! Ora puoi effettuare il login.";
                    header('Location: login.php');
                    exit;
                }
            }
        } catch (PDOException $e) {
            $errors[] = "Errore durante la registrazione: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione | Te e Tabacco</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --deep-brown: #3B2F2F;
            --rich-amber: #D6A75C;
            --warm-parchment: #F1E6D6;
            --dark-leaf: #2E1F1F;
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
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-container {
            max-width: 500px;
            width: 100%;
            padding: 2rem;
        }

        .register-card {
            background: rgba(30, 20, 18, 0.95);
            border: 1px solid var(--rich-amber);
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: 0 12px 35px rgba(0,0,0,0.5);
        }

        .register-title {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 2rem;
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
            font-family: 'Playfair Display', serif;
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: var(--rich-amber);
            color: var(--dark-leaf);
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 1rem;
        }

        .message {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
            text-align: center;
        }

        .success {
            background: rgba(214, 167, 92, 0.15);
            border-left: 4px solid var(--rich-amber);
            color: var(--warm-parchment);
        }

        .error {
            background: rgba(200, 0, 0, 0.15);
            border-left: 4px solid #ff0000;
            color: #ff9999;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .login-link a {
            color: var(--rich-amber);
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <h1 class="register-title">
                <i class="fas fa-user-plus"></i> Registrazione
            </h1>

            <?php if(isset($success)): ?>
                <div class="message success">
                    <?= $success ?> <a href="landing.php" style="color: var(--rich-amber);">Torna alla Home</a>
                </div>
            <?php endif; ?>

            <?php if(!empty($errors)): ?>
    <div class="message error">
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

            <form method="POST" action="">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label for="email_confirm">Conferma Email</label>
        <input type="email" id="email_confirm" name="email_confirm" value="<?= htmlspecialchars($_POST['email_confirm'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label for="password">Password (minimo 8 caratteri)</label>
        <input type="password" id="password" name="password" required>
    </div>

    <div class="form-group">
        <label for="password_confirm">Conferma Password</label>
        <input type="password" id="password_confirm" name="password_confirm" required>
    </div>

    <button type="submit" class="submit-btn">
        Registrati
    </button>
</form>

            <div class="login-link">
                Hai già un account? <a href="login.php">Accedi</a>
            </div>
        </div>
    </div>
</body>
</html>