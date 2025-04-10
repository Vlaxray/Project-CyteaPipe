<?php
require 'db.php';

// Distruggi la sessione
$_SESSION = array();
session_destroy();

// Redirect alla pagina di login
header('Location: login.php');
exit;
?>