<?php session_start(); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./assets/css/style-slide-bar.css" rel="stylesheet">
</head>
<body>
    <div class="slideBar"> <!--For the bar on the left -->
        <div class="slidetitle">
            <img src="./assets/images/Logo-Saint-Vincent.png" alt="logo Saint-Vincent">
            <div class="titles">
                <h1>Math Index</h1>
                <h3>Lycée Saint-Vincent-Senlis</h3>
            </div>
        </div>

        <div class="slide home">
            <img src="./assets/images/Logo-Home.png" alt="Logo home">
            <h3><a href="./index.php">Accueil</a></h3>
        </div>

        <div class="slide search">
            <img src="assets/images/Logo-loupe.png" alt="Logo loupe">
          <h3><a href="research.php">Recherche</a></h3>
        </div>

        <div class="slide exercice">
            <img src="./assets/images/logo-fonction.png" alt="Logo fonction Exercice">
            <h3><a href="./mathematique.php">Exercices</a></h3>
        </div>

        <?php 
            if (isset($_SESSION["first_name"])) {
                echo('<div class="slide exercice">
                        <img src="./assets/images/logo-fonction.png" alt="Logo fonction Mes Exercice">
                         <h3><a href="./mathematique.php">Mes exercices</a></h3>
                    </div>

                <div class="slide submit">
                    <img src="./assets/images/logo-fonction.png" alt="Logo fonction submit exercice">
                    <h3><a href="./submit-exercice.php">Soumettre</a></h3>
                </div>');

                echo '<div class="disconnection"><img src="assets/images/Frame.png"><a href="deconnexion.php">Déconnexion</a></div>';
            }
        
        ?>

    </div>
</body>
