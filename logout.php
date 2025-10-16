<?php
session_start();

include 'config.php';

if (
    isset($_GET['action']) && $_GET['action'] === 'out' &&
    isset($_GET['who'])
) {
    // Clear session
    session_unset();
    session_destroy();

    // Redirect based on role
    if ($_GET['who'] === 'admin') {
        header("Location: " . site_url('adminlogin.php'));
    } else {
        header("Location: " . site_url('login.php'));
    }
    exit;
}
?>
