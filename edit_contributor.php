<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    include ('./header.php');
    require_once 'connexion_db.php';
    require 'config.php';
    $connection = mysqli_connect($server, $user, $pass, $dbName);
    
    // Retrieve the ID from the URL parameter
    $id = $_GET['id'];
    
    // Fetch the contributor information from the database based on the ID
    $query = "SELECT * FROM contributors WHERE id = $id";
    $result = mysqli_query($connection, $query);
    $contributor = mysqli_fetch_assoc($result);
    ?>
    <link rel="stylesheet" href="assets/css/administration.css">
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
                <button class="tab">Classes</button>
                <button class="tab">Thématiques</button>
                <button class="tab">Compétences</button>
                <button class="tab">Origines</button>
            </div>

            <div class="tab-content active-tab-content">
                <div class="add-contributor">
                    <h3>Modifier un contributeur</h3>
                    <form method="POST" action="update_contributor.php" class="update-contributor">
                        <label for="id">ID :</label>
                        <input type="text" id="id" name="id" value="<?php echo $contributor['id']; ?>" required>

                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="nom" value="<?php echo $contributor['nom']; ?>" required>

                        <label for="role">Rôle :</label>
                        <select id="role" name="role" required>
                            <option value="Enseignant" <?php if($contributor['role'] == 'Enseignant') echo 'selected'; ?>>Enseignant</option>
                            <option value="Elève" <?php if($contributor['role'] == 'Elève') echo 'selected'; ?>>Elève</option>
                        </select>

                        <label for="prenom">Prénom :</label>
                        <input type="text" id="prenom" name="prenom" value="<?php echo $contributor['prenom']; ?>" required>

                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email" value="<?php echo $contributor['email']; ?>" required>

                        <label for="password">Mot de passe :</label>
                        <input type="password" id="password" name="password" placeholder="Saisissez le mot de passe" required>

                        <input type="submit" value="Modifier">
                        <input type="button" value="Retour à la liste" onclick="window.location.href='administration.php'">
                    </form>
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
<?php require_once('footer.php');?>
</body>
</html>
