<?php
    require_once 'slide-bar.php';

    session_start();
    session_destroy();

    echo '<p>La déconnexion a été effectuée avec succès.</p>';
?>