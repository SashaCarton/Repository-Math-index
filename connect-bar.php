<head>
    <link href="./assets/css/connect-bar.css" rel="stylesheet">
</head>

<div class="connect">
    <img src="assets/images/Icon-login.png" alt="logo connexion">
    <?php

    if (isset($_COOKIE['role']) && $_COOKIE['role'] == 'admin') {
        if (date('H') < 18) {
            echo "<a class=\"nonA\">Bonjour,</a><a class=\"admin\" href=\"administration.php\">" . $_COOKIE['first_name'] . "</a>";
        } else {
            echo "<a class='nonA'>Bonsoir,</a><a class='admin' href=\"administration.php\">" . $_COOKIE['first_name'] . "</a>";
        }
    } elseif (isset($_COOKIE['role']) && $_COOKIE['role'] == 'Enseignant') {
        if (date('H') < 18) {
            echo "<a>Bonjour, " . $_COOKIE['first_name'] . "</a>";
        } else {
            echo "<a>Bonsoir, " . $_COOKIE['first_name'] . "</a>";
        }
    } elseif (isset($_COOKIE['role']) && $_COOKIE['role'] == 'Elève') {
        if (date('H') < 18) {
            echo "<a>Bonjour, " . $_COOKIE['first_name'] . "</a>";
        } else {
            echo "<a>Bonsoir, " . $_COOKIE['first_name'] . "</a>";
        }
    } else { 
        if (date('H') < 18) {
            echo "<a href=\"connexion.php\">Se connecter</a>";
        } else {
            echo "<a href=\"connexion.php\">Se connecter</a>";
        }
    }

    ?>
</div>