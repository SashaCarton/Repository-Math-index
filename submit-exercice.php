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

                </div>

                <div class="tab-content">
                    <h2>
                        Sources
                    </h2>
                    <div class="tab-content-sources-form">
                        <label for="origines">Origines <span>*</span> :</label>
                        <div>
                            <select name="origines" id="origines">
                                <option value="livre">
                                    Livre
                                </option>

                                <option value="professeur">
                                    Professeur
                                </option>

                                <option value="internet">
                                    Internet
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="tab-content-sources-form">
                        <label for="source-site">Nom de la source/lien du site <span>*</span>:</label>
                        <div>
                            <input type="text" id="source-site" size="125" placeholder="Maths Tout-en-un MP/MP*-MPI -6e éd.">
                        </div>
                    </div>

                    <div class="tab-content-sources-form">
                        <label for="info-comp">Informations complémentaires :</label>
                        <div>
                            <textarea name="info-comp" id="info-comp" cols="125" rows="6" placeholder="Page 12, 2ème paragraphe"></textarea>
                        </div>
                    </div>

                    <div>
                        <div class="tab-content-sources-form-btn">
                            <input type="button" value="Continuer" name="Continuer">
                        </div>
                    </div>


                </div>

                <div class="tab-content">
                    <h2>
                        Fichiers
                    </h2>
                        <div class="tab-content-file-form">
                            <div>
                                <p>
                                    Fiche exercice (PDF, word) <span>*</span>:
                                </p>
                            </div>
                            <label for="fichier">
                                <input type="file" id="fichier" size="125" placeholder="Sélectionner un fichier à télécharger" accept=".pdf,.word" required>
                                <h3 id="fileName">
                                    Selectionnez un fichier à envoyer
                                </h3>
                                <img id="upload-img" src="assets\images\upload.png" alt="logo of upload">
                            </label>

                        <div class="tab-content-file-form-2">
                            <div>
                                <p>
                                    Fiche corrigé (PDF,word) <span>*</span>:
                                </p>
                            </div>
                            <label for="fichier-corrigé">
                                <input type="file" id="fichier-corrigé" size="125" placeholder="Sélectionner un fichier à télécharger" accept=".pdf,.word" required>
                                <h3 id="fileName-corrigé">
                                    Selectionnez un fichier à envoyer
                                </h3>
                                <img id="upload-img" src="assets\images\upload.png" alt="logo of upload">
                            </label>
                        </div>

                        <div class="tab-content-file-form-btn">
                            <input type="button" value="Enregistrer" name="Enregistrer" >
                        </div>
                </div>

                <!-- Script pour modifier le texte qui sert de placeholder pour afficher le nom du fichier téléchargé (pour le fichier de l'exercice) -->

                <script>
                    document.getElementById('fichier').addEventListener('change', function(e) {
                        var fileName = e.target.files[0].name;
                        document.getElementById('fileName').textContent = "Fichier téléchargé: " + fileName;
                    });
                </script>

                <!-- Script pour modifier le texte qui sert de placeholder pour afficher le nom du fichier téléchargé (pour le fichier corrigé) -->

                <script>
                    document.getElementById('fichier-corrigé').addEventListener('change', function(e) {
                        var fileName = e.target.files[0].name;
                        document.getElementById('fileName-corrigé').textContent = "Fichier téléchargé: " + fileName;
                    });
                </script>

        <!-- Script pour l'affichage des onglets selon celui qui est selectionné -->
                <script src="assets\scripts\tabs.js"></script>

            </div>
        </div>
        
        <?php 
                require_once('footer.php')
        ?>
    </div>
    

</body>
</html>