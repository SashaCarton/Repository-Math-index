<head>
    <link href="assets/css/connect-bar.css" rel="stylesheet">
</head>

<div class="connect">
            <img src="assets/images/Icon-login.png" alt="logo connexion">
            <?php
            if (isset($_SESSION['nom'])) {
                echo "Bonjour, " . $_SESSION['nom'];
                echo '<a href="deconnexion.php">Déconnexion</a>';
            } else {
                echo '<a href="connexion.php">Connexion</a>';
            }
            ?>
</div>