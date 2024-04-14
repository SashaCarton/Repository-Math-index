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

                    <form action="">
                        <label for="">Label-test</label>
                    </form>
                    
                    <button>
                        Continuer
                    </button>
                    <br>
                    <br>
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