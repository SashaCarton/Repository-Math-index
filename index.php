<!DOCTYPE html>
<?php session_start();?>
<html lang="fr">
<head>
    <?php include ('header.php'); ?>
    <title>Math Index</title>
</head>

<body>
    <?php require_once('slide-bar.php') ?>
    <div class="container"> <!--Everything next to the slide bar like containerHome and connect-->
        <?php require_once('connect-bar.php'); ?>
        <div class="containerHome"> <!--Rectangle background of the "Acceuil"-->
            <h1>Accueil</h1>
            <div>
                <p>Nous sommes ravis de vous accueillir sur <strong>Math Index</strong>, la plateforme mathématique exclusive du lycée Saint-Vincent Senlis. Développée avec passion pour enrichir l'expérience éducative de nos étudiants, cette ressource en ligne offre un accès simplifié à une vaste bibliothèque d'exercices mathématiques de qualité.</p>
                <h3>Explorez les Avantages Spécifiques à Notre Lycée :</h3>
                <ol>
                    <p>1. Exercices Personnalisés : Découvrez une collection soigneusement sélectionnée d'exercices qui complètent notre programme éducatif, adaptés aux niveaux et aux besoins spécifiques de nos élèves.</li>
                    <p>2. Soutien Pédagogique : <strong>Math Index</strong> sert de complément idéal à nos cours, offrant aux enseignants et aux étudiants un outil puissant pour renforcer la compréhension des concepts mathématiques enseignés en classe.</li>
                    <p>3. Collaboration Communautaire : En tant que membre de notre lycée, participez à la communauté en partageant vos propres exercices, collaborez avec d'autres enseignants et favorisez un environnement d'apprentissage collaboratif.</li>
                </ol>
            </div>
        </div>
    </div>
</body>
<?php require_once('./footer.php'); ?>

</html>
