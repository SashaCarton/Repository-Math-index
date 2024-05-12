<head>
    <link href="./assets/css/connect-bar.css" rel="stylesheet">
</head>

<div class="connect">
    <img src="assets/images/Icon-login.png" alt="logo connexion">
    <?php
    $heure = date("H");

    if (isset($_SESSION['first_name'])) {
        if($heure < 18 && $heure > 5) {
            echo "<p>Bonjour,</p><a href=\"administration.php\">" . $_SESSION['first_name'] . "</a>";
        } else {
            echo "<p>Bonsoir,</p><a href=\"administration.php\">" . $_SESSION['first_name'] . "</a>";

        }
    } else {
        echo '<a href="connexion.php">Connexion</a>';
    }
    ?>
</div>