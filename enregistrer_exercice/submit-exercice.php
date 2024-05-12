<?php
require_once('slide-bar.php');
require_once('connexion_db.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include ('header.php'); ?>
    <title>Soumettre un exercice</title>
</head>
<body>
<div class="container">
    <?php require_once('connect-bar.php'); ?>

    <div class="grey-bloc">
        <h1> Soumettre un exercice</h1>

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
                <h2>Informations générales</h2>

                <div class="container-bloc">
                    <div class="bloc1">
                        <label for="exercise-name">Nom de l'exercice * :</label><br>
                        <input type="text" class="holder" id="exercise-name" name="exercise-name" placeholder="Nom de l'exercice">
                        <br>
                        <label for="exercise-subject">Matière * :</label>
                        <br>
                        <select id="exercise-subject" name="exercise-subject" class="holder">
                            <option value="" disabled selected>Mathématique</option>
                            <option value="mathematique">Mathématique</option>
                            <option value="francais">Français</option>
                        </select>
                        <br>

                        <label for="exercise-level">Classe * :</label><br>
                        <select id="exercise-level" name="exercise-level"class="holder">
                            <option value="" disabled selected>Seconde</option>
                            <option value="seconde">Seconde</option>
                            <option value="premiere">Première</option>
                            <option value="terminale">Terminale</option>
                        </select>
                        <br>

                        <label for="exercise-type">Type d'exercice * :</label><br>
                        <select id="exercise-type" name="exercise-type"class="holder">
                            <option value="" disabled selected>Suites</option>
                            <option value="suites">Suites</option>
                            <option value="matriciel">Matriciel</option>
                            <option value="continuite">Continuité</option>
                        </select>
                        <br>

                        <label for="exercise-chapitre">Chapitre du cours :</label><br>
                        <input type="text" id="exercise-chapitre" name="exercise-chapitre" placeholder="Chapitre 1"class="holder">
                        <br>
                        <br>
                        <button type="button" class="custom-submit-button" id="continue-btn">Continuer</button>
                    </div>

                    <div class="bloc2">
                        <label>Compétences :</label><br>
                        <div class="radio-container">
                            <div class="radio-splitter">
                                <label><input class="square-radio" type="checkbox" value="chercher" name="exercise-skills[]"> Chercher</label><br>
                                <label><input class="square-radio" type="checkbox" value="represente" name="exercise-skills[]"> Représenter</label><br>
                                <label><input class="square-radio" type="checkbox" value="calculer" name="exercise-skills[]"> Calculer</label><br>
                            </div>
                            <div class="radio-splitter">
                                <label><input class="square-radio" type="checkbox" value="modeliser" name="exercise-skills[]"> Modéliser</label><br>
                                <label><input class="square-radio" type="checkbox" value="raisonner" name="exercise-skills[]"> Raisonner</label><br>
                                <label><input class="square-radio" type="checkbox" value="communiquer" name="exercise-skills[]"> Communiquer</label><br>
                            </div>
                        </div>
                        <br>

                        <label for="exercise-difficulty">Mots clés :</label>
                        <br>
                        <div class="holder tag-container">
                            <input name="exercise-chapitre" class="holder tag-container"/>
                        </div>

                        <label for="exercise-difficulty">Difficulté * :</label>
                        <br>
                        <select class="holder" id="exercise-difficulty" name="exercise-difficulty">
                            <option value="" disabled selected>Niveau 11</option>
                            <option value="niveau-1">Niveau 1</option>
                            <option value="niveau-2">Niveau 2</option>
                            <option value="niveau-3">Niveau 3</option>
                            <option value="niveau-4">Niveau 4</option>
                            <option value="niveau-5">Niveau 5</option>
                            <option value="niveau-6">Niveau 6</option>
                            <option value="niveau-7">Niveau 7</option>
                            <option value="niveau-8">Niveau 8</option>
                            <option value="niveau-9">Niveau 9</option>
                            <option value="niveau-10">Niveau 10</option>
                            <option value="niveau-11">Niveau 11</option>
                        </select>
                        <br>

                        <label for="exercise-duration">Durée (en heures) :</label><br>
                        <input class="holder" type="text" id="exercise-duration" name="exercise-duration" placeholder="4">
                        <br>
                        <br>
                        <br>
                    </div>
                </div>
            </div>

            <div class="tab-content">
                <h2>Sources</h2>
                <div class="container-bloc">
                    <div class="bloc1">
                        <div class="tab-content-sources-form">
                            <label for="origines">Origines <span>*</span> :</label>
                            <div>
                                <select name="origines" id="origines">
                                    <option value="livre">Livre</option>
                                    <option value="professeur">Professeur</option>
                                    <option value="internet">Internet</option>
                                </select>
                            </div>
                        </div>

                        <div class="tab-content-sources-form">
                            <label for="source-site">Nom de la source/lien du site <span>*</span>:</label>
                            <div>
                                <input type="text" id="source-site" size="125" placeholder="Maths Tout-en-un MP/MP*-MPI -6e éd." name="source-site">
                            </div>
                        </div>

                        <div class="tab-content-sources-form">
                            <label for="info-comp">Informations complémentaires :</label>
                            <div>
                                <textarea name="info-comp" id="info-comp" cols="125" rows="6" placeholder="Page 12, 2ème paragraphe" name="exercise-additional-info"></textarea>
                            </div>
                        </div>

                        <div>
                            <div class="tab-content-sources-form-btn">
                                <input type="button" id="continue-to-files-btn" value="Continuer" name="Continuer">
                            </div>
                        </div>
                    </div>
                    <div class="bloc2">
                        <div class="tab-content-sources-form">
                            <label for="origines">Ou proposé par un:</label>
                            <div>
                                <select name="origines" id="origines">
                                    <option value="livre">Etudiant</option>
                                    <option value="professeur">Professeur</option>
                                </select>
                            </div>
                        </div>

                        <div class="tab-content-sources-form">
                            <label for="source-site">Nom:</label>
                            <div>
                                <textarea name="info-comp" id="info-comp" cols="125" rows="6" placeholder="" name="student-name"></textarea>
                            </div>
                        </div>

                        <div class="tab-content-sources-form">
                            <label for="info-comp">Prénom:</label>
                            <div>
                                <textarea name="info-comp" id="info-comp" cols="125" rows="6" placeholder="" name="student-surname"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="tab-content">
                <h2>Fichiers</h2>
                <div class="tab-content-file-form">
                    <div>
                        <p>
                            Fiche exercice (PDF, word) <span>*</span>:
                        </p>
                    </div>
                    <label for="fichier">
                        <input type="file" id="fichier" size="125" placeholder="Sélectionner un fichier à télécharger" accept=".pdf,.word">
                        <h3 id="fileName">Selectionnez un fichier à télécharger</h3>
                        <img id="upload-img" src="assets\images\upload.png" alt="logo of upload">
                    </label>

                    <div class="tab-content-file-form-2">
                        <div>
                            <p>
                                Fiche corrigé (PDF,word) <span>*</span>:
                            </p>
                        </div>
                        <label for="fichier-corrigé">
                            <input type="file" id="fichier-corrigé" size="125" placeholder="Sélectionner un fichier à télécharger" accept=".pdf,.word">
                            <h3 id="fileName">Selectionnez un fichier à télécharger</h3>
                            <img id="upload-img" src="assets\images\upload.png" alt="logo of upload">
                    </div>
                    
                    <div class="tab-content-sources-form-btn">
                        <input onclick="submitForm()" type="button" value="Enregistrer">
                    </div>
                </div>

                <!-- Script pour l'affichage des onglets selon celui qui est selectionné -->

            </div>
        </div>

    </div>


</body>
<?php require_once('footer.php') ?>


<script>
    const tagContainer = document.querySelector(".tag-container");
    const input = document.querySelector(".tag-container input");

    let tags = [];

    function createTag(tag) {
        const div = document.createElement("div");
        div.setAttribute("class", "keyword");
        const span = document.createElement("span");
        span.innerHTML = tag;
        const icon = document.createElement("ion-icon");
        icon.setAttribute("name", "close-outline");
        icon.setAttribute("data-item", tag);
        div.appendChild(span);
        div.appendChild(icon);
        return div;
    }

    function reset() {
        const tagElements = document.querySelectorAll(".keyword");
        tagElements.forEach((tag) => {
            tag.parentElement.removeChild(tag);
        });
    }

    function addTags() {
        reset();
        tags.slice().reverse().forEach((tag) => {
            if (tag !== '') {
                tagContainer.prepend(createTag(tag));
            }
        });
    }

    input.addEventListener("keyup", function (event) {
        if (event.key === ",") {
            const data = input.value.trim();
            const list_of_tags = data.split(",").filter(elm => elm.trim() !== "");
            tags.push(...list_of_tags);

            tags = [...new Set(tags)];

            input.value = "";
            addTags();
        }
    });

    document.addEventListener("click", function (e) {
        if (e.target.tagName === "ION-ICON") {
            const data = e.target.getAttribute("data-item");
            tags = tags.filter((tag) => {
                return tag !== data;
            });
            addTags();
        }
    });

    let submitExerciseData = {}

    document.getElementById('continue-btn').addEventListener('click', function() {
        // Récupérer les valeurs des champs
        let exerciseName = document.getElementById('exercise-name').value.trim();
        let exerciseSubject = document.getElementById('exercise-subject').value.trim();
        let exerciseLevel = document.getElementById('exercise-level').value.trim();
        let exerciseType = document.getElementById('exercise-type').value.trim();
        let exerciseDifficulty = document.getElementById('exercise-difficulty').value.trim();

        // Vérifier si tous les champs obligatoires sont remplis
        if (exerciseName === '' || exerciseSubject === '' || exerciseLevel === '' || exerciseType === '' || exerciseDifficulty === '') {
            alert('Veuillez remplir tous les champs obligatoires.');
            return;
        }

        submitExerciseData.generalInfo = {
            "exerciseName": exerciseName,
            "exerciseSubject": exerciseSubject,
            "exerciseLevel": exerciseLevel,
            "exerciseType": exerciseType,
            "exerciseDifficulty": exerciseDifficulty
        };

        document.querySelector('.tabs-btn-container .active').classList.remove('active');
        document.querySelector('.tabs .active-tab-content').classList.remove('active-tab-content');

        // Ajouter la classe 'active' au deuxième bouton et au deuxième contenu
        document.querySelectorAll('.tabs-btn-container button')[1].classList.add('active');
        document.querySelectorAll('.tabs .tab-content')[1].classList.add('active-tab-content');
    });

    // Écouteur d'événement pour le bouton "Continuer" dans la section "Sources"
    document.getElementById('continue-to-files-btn').addEventListener('click', function() {
        // Récupérer les valeurs des champs nécessaires dans la section "Sources"
        let origine = document.getElementById('origines').value.trim();
        let sourceSite = document.getElementById('source-site').value.trim();

        // Vérifier si les champs obligatoires sont remplis
        if (origine === '' || sourceSite === '') {
            alert('Veuillez remplir tous les champs obligatoires dans la section "Sources".');
            return;
        }

        submitExerciseData.sources = {
            "origine": origine,
            "sourceSite": sourceSite,
        };

        document.querySelectorAll('.tabs-btn-container button')[1].classList.remove('active');
        document.querySelectorAll('.tabs .tab-content')[1].classList.remove('active-tab-content');

        // Ajouter la classe 'active' au troisième bouton et au troisième contenu
        document.querySelectorAll('.tabs-btn-container button')[2].classList.add('active');
        document.querySelectorAll('.tabs .tab-content')[2].classList.add('active-tab-content');
    });


    function submitForm() {
        submitExerciseData = JSON.stringify(submitExerciseData)
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'enregistrer_exercice.php');
        xhr.setRequestHeader("X-Requested-With", "xmlhttprequest");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Gérez ici ce que vous voulez faire après l'enregistrement réussi
                    alert('Les informations générales ont été enregistrées avec succès.');
                } else {
                    alert('Erreur : ' + response.message);
                }
            }
        };
        xhr.send(submitExerciseData);
    }
    // Assurez-vous que ce script est inclus dans votre page HTML
</script>

<script src="./assets/scripts/tabs.js"></script>

</html>