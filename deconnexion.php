<?php
    require_once 'slide-bar.php';
    session_destroy();
    setcookie('first_name', '', time() - 3600, '/'); 
    setcookie('loggedin', '', time() - 3600, '/'); 
    setcookie('role', '', time() - 3600, '/'); 
    header('Location: index.php');
    exit;
?>
