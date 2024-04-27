<head>
    <link href="./assets/css/connect-bar.css" rel="stylesheet">
</head>

<div class="connect">
    <img src="assets/images/Icon-login.png" alt="logo connexion">
    <?php
    if (isset($_SESSION['first_name'])) {
        echo "Bonjour, <a href=\"administration.php\">" . $_SESSION['first_name'] . "</a>";
    } else {
        echo '<a href="connexion.php">Connexion</a>';
    }
    ?>
</div>
