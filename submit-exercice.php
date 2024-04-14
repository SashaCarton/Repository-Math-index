<?php
    require_once('slide-bar.php');
    require_once('connexion_db.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/SubmitExercice.css" rel="stylesheet">
    <title>Soumettre un exercice</title>
</head>
<body>
    <div class="container">
    <?php 
        require_once('connect-bar.php');
    ?>
        <div class="grey-bloc">
            <h1>
                Soumettre un exercice
            </h1>

            <div class="tabs">
                <div class="tabs-btn-container">
                    <button class="tab active tab">
                        Informations générales
                    </button>
                    
                    <button class="tab">
                        Sources
                    </button>

                    <button class="tab">
                        Fichiers
                    </button>
                </div>

                <div class="tab-content active-tab-content">
                    <h2>
                        Informations générales
                    </h2>
                    <div class="container-bloc">
                    <form action="">
                        <div class="bloc1">
                        <label for="exercise-name">Nom de l'exercice :</label><br>
                        <input type="text" id="exercise-name" name="exercise-name" placeholder="Nom de l'exercice">
                        <br>
                        <label for="exercise-subject">Matière :</label>
                        <br>
                        <select id="exercise-subject" name="exercise-subject">
                            <option value="" disabled selected>Mathématique</option>
                            <option value="mathematique">Mathématique</option>
                            <option value="francais">Français</option>
                        </select>
                        <br>
                        <label for="exercise-level">Classe :</label><br>
                        <select id="exercise-level" name="exercise-level">
                            <option value="" disabled selected>Seconde</option>
                            <option value="seconde">Seconde</option>
                            <option value="premiere">Première</option>
                            <option value="terminale">Terminale</option>
                        </select>
                        <br>
                        <label for="exercise-type">Type d'exercice :</label><br>
                        <select id="exercise-type" name="exercise-type">
                            <option value="" disabled selected>Choisissez un type d'exercice</option>
                            <option value="suites">Suites</option>
                            <option value="matriciel">Matriciel</option>
                            <option value="continuite">Continuité</option>
                        </select>
                        <br>
                        <label for="exercise-chapitre">Chapitre du cours :</label><br>
                        <input type="text" id="exercise-chapitre" name="exercise-chapitre" placeholder="Numéro du chapitre">
                        <br>
                        <br>
                    </div>
                        <div class="bloc2">
                            <label>Objectif :</label><br>
                            <label><input type="radio" name="objectif" value="chercher"> Chercher</label><br>
                            <label><input type="radio" name="objectif" value="represente"> Représenter</label><br>
                            <label><input type="radio" name="objectif" value="calculer"> Calculer</label><br>
                            <label><input type="radio" name="objectif" value="modeliser"> Modéliser</label><br>
                            <label><input type="radio" name="objectif" value="raisonner"> Raisonner</label><br>
                            <label><input type="radio" name="objectif" value="communiquer"> Communiquer</label><br>
                            
                        </div>
                    
                        <label for="">Label-test</label>
                    
                    <button>
                        Continuer
                    </button>
                    </form>
                    <br>
                    <br>
                    </div>
                </div>

                <div class="tab-content">
                    <h2>Sources</h2>
                </div>

                <div class="tab-content">
                    <h2>Fichiers</h2>
                </div>

        <!-- Script pour l'affichage des onglets selon celui qui est selectionné -->
                <script src="assets\scripts\tabs.js"></script>

            </div>
            <?php 
                require_once('footer.php')
            ?>
        </div>

    </div>

</body>
</html>