<?php
// Assicurati che non ci sia output prima degli header
if (ob_get_level()) ob_end_clean();

// Avvia la sessione se non è già attiva
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Distruggi completamente la sessione
$_SESSION = array();


// Distruggi la sessione
session_destroy();

// Reindirizza alla home page con percorso relativo
header('Location: mydashboard/CyteaPipe/frontend/index.php'); 
exit;
?>