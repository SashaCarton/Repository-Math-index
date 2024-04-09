
<?php session_start();?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/styleIndex.css" rel="stylesheet">
    <title>Math Index</title>
</head>
<body>
    <?php 
    require_once('slide-bar.php')
    ?>
    <div class="container"> <!--Everything next to the slide bar like containerHome and connect-->
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
        <div class="containerHome"> <!--Rectangle background of the "Acceuil"-->
            <h1>Accueil</h1>
            <div>
                <p>Nous sommes ravis de vous accueillir sur Math Index, la plateforme mathématique exclusive du lycée Saint-Vincent Senlis. Développée avec passion pour enrichir l'expérience éducative de nos étudiants, cette ressource en ligne offre un accès simplifié à une vaste bibliothèque d'exercices mathématiques de qualité.</p>
                <h3>Explorez les Avantages Spécifiques à Notre Lycée :</h3>
                <ol>
                    <li>Exercices Personnalisés : Découvrez une collection soigneusement sélectionnée d'exercices qui complètent notre programme éducatif, adaptés aux niveaux et aux besoins spécifiques de nos élèves.</li>
                    <li>Soutien Pédagogique : Math Index sert de complément idéal à nos cours, offrant aux enseignants et aux étudiants un outil puissant pour renforcer la compréhension des concepts mathématiques enseignés en classe.</li>
                    <li>Collaboration Communautaire : En tant que membre de notre lycée, participez à la communauté en partageant vos propres exercices, collaborez avec d'autres enseignants et favorisez un environnement d'apprentissage collaboratif.</li>
                </ol>
            </div>
            <?php 
                    require_once('footer.php')
            ?>
        </div>
    </div>
</body>
</html>
