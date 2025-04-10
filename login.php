<?php
require 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['logged_in'] = true;
        
        header('Location: landing.php');
        exit;
    } else {
        $error = "Email o password non validi";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Login | Western Chanel</title>
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

    .login-container {
        max-width: 500px;
        width: 100%;
        padding: 2rem;
    }

    .login-card {
        background: rgba(30, 20, 18, 0.95);
        border: 1px solid var(--rich-amber);
        border-radius: 12px;
        padding: 2.5rem;
        box-shadow: 0 12px 35px rgba(0,0,0,0.5);
    }

    .login-title {
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

    .error-message {
        color: #ff9999;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .register-link {
        text-align: center;
        margin-top: 1.5rem;
    }

    .register-link a {
        color: var(--rich-amber);
        text-decoration: none;
    }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1 class="login-title">
                <i class="fas fa-hat-cowboy"></i> Accesso
            </h1>

            <?php if($error): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-sign-in-alt"></i> Accedi
                </button>
            </form>

            <div class="register-link">
                Non hai un account? <a href="register.php">Registrati</a>
            </div>
        </div>
    </div>
</body>
</html>