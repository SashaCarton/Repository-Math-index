<?php
    require_once 'slide-bar.php';
    session_destroy();
    header('Location: index.php');
    exit;
?>
