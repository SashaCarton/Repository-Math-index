<head>
    <link href="./assets/css/connect-bar.css" rel="stylesheet">
</head>

<div class="connect">
    <img src="assets/images/Icon-login.png" alt="logo connexion">
    <?php


    if (isset($_COOKIE['loggedin']) == true && $_COOKIE['role'] === 'admin') {
            echo "<p>Bonjour,</p><a href=\"administration.php\">" . $_COOKIE['first_name'] . "</a>";
        } else if (isset($_COOKIE['loggedin']) == true && isset($_COOKIE['role']) == 'contributor') {
            echo "<p>Bonsoir,</p>" . $_COOKIE['first_name'];
        } else {
        echo '<a href="connexion.php">Connexion</a>';
    }
    ?>
</div>