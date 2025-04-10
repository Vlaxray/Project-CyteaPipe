<?php
require 'db.php';

if (!isset($_SESSION['logged_in'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php');
    exit;
}