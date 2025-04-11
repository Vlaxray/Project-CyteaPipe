<?php
// Assicurati che non ci sia output prima degli header
if (ob_get_level()) ob_end_clean();

// Avvia la sessione se non è già attiva
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Distruggi completamente la sessione
$_SESSION = array();

// Se vuoi distruggere anche il cookie di sessione
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Distruggi la sessione
session_destroy();

// Reindirizza alla home page con percorso relativo
header('Location: ../../frontend/index.php'); 
exit;
?>