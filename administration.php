<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include ('./header.php') ?>
    <title>Soumettre un exercice</title>
</head>
<?php
require_once('slide-bar.php');
require_once('connexion_db.php');
?>
<link rel="stylesheet" href="assets/css/administration.css">
<body>
<div class="container">
    <?php require_once('connect-bar.php'); ?>
    <div class="grey-bloc">
        <h1>
            Administration
        </h1>

        <div class="tabs">
            <div class="tabs-btn-container">
                <button class="tab">Contributeurs</button>
                <button class="tab">Exercices </button>
                <button class="tab">Matières</button>
                <button class="tab">Classes0</button>
                <button class="tab">Thématiques</button>
                <button class="tab">Compétences</button>
                <button class="tab">Origines</button>
            </div>

            <div class="tab-content active-tab-content">
                <div class="contributeurs">
                    <h2>Gestion des contributeurs</h2>
                    <label for="search">Rechercher un contributeur par nom, prénom ou email :</label>
                    <div class="search">
                        <form>
                            <input type="text" id="search" name="search">
                            <input type="submit" id="buttonSearch" value="Rechercher">
                            <input type="button" id="buttonAdd" value="Ajouter +">
                        </form>
                    </div>
                    <!-- Mettre ici php -->
                </div>
                
            </div>
            
            <div class="tab-content">
                <h2>Sources</h2>
            </div>

            <div class="tab-content">
                <h2>Fichiers</h2>
            </div>

            <!-- Script pour l'affichage des onglets selon celui qui est selectionné -->
            <script src="./assets/scripts/tabs.js"></script>
        </div>
    </div>
</div>
<script>
    // Sélectionnez le bouton Ajouter
    const addButton = document.querySelector('input[value="Ajouter +"]');

    // Ajoutez un gestionnaire d'événements click au bouton
    addButton.addEventListener('click', function(event) {
        // Empêchez le formulaire d'être soumis (ce qui rafraîchirait la page)
        event.preventDefault();

        // Sélectionnez la div contributeurs
        const contributorsDiv = document.querySelector('.contributeurs');

        // Changez le contenu de la div
        contributorsDiv.innerHTML =`
            <h3>Ajouter un contributeur</h3>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" placeholder="Saisissez le nom du contributeur">

            <label for="role">Rôle :</label>
            <select id="role" name="role">
                <option value="Enseignant">Enseignant</option>
                <option value="Elève">Elève</option>
            </select>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" placeholder="Saisissez le prénom">

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" placeholder="Saisissez l'email">

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" placeholder="Saisissez le mot de passe">

            <input type="button" value="Retour à la liste">
            <input type="submit" value="Enregistrer">
        `;

        // Ajoutez le formulaire à la div contributeurs
        contributorsDiv.appendChild(form);
    });
</script>
<?php require_once('footer.php');?>
</body>
</html>
