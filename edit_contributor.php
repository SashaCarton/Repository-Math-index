<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    include ('./header.php');
    require_once 'connexion_db.php';
    require 'config.php';
    $connection = mysqli_connect($server, $user, $pass, $dbName);
    
    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($connection, $_GET['id']);
    
        $query = "SELECT * FROM user WHERE id = $id";
        $result = mysqli_query($connection, $query);
        $contributor = mysqli_fetch_assoc($result);
    }
    ?>
    <link rel="stylesheet" href="assets/css/administration.css">
</head>
<?php
require_once('slide-bar.php');
?>
<link rel="stylesheet" href="assets/css/administration.css">
<body>
<div class="container">
    <?php require_once('connect-bar.php'); ?>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['nom']) && isset($_POST['role']) && isset($_POST['prenom']) && isset($_POST['email'])) {
            $nom = mysqli_real_escape_string($connection, $_POST['nom']);
            $role = mysqli_real_escape_string($connection, $_POST['role']);
            $prenom = mysqli_real_escape_string($connection, $_POST['prenom']);
            $email = mysqli_real_escape_string($connection, $_POST['email']);
            $password = mysqli_real_escape_string($connection, $_POST['password']);
            $id = mysqli_real_escape_string($connection, $_POST['id']);
            $hashedPassword = password_hash($password, PASSWORD_ARGON2I);
            $query = "UPDATE user SET last_name = '$nom', role = '$role', first_name = '$prenom', email = '$email', password = '$password' WHERE id = $id";
            $result = mysqli_query($connection, $query);

            if ($result) {
                header('Location: administration.php');
                exit;
            } else {
                echo "Error updating contributor: " . mysqli_error($connection);
            }
        } else {
            echo "Une erreur de saisie dans le formulaire s'est produite";
        }
    }
    ?>
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
                    <form method="POST"  class="update-contributor">
                        <label for="nom">Nom :</label>
                        <input class="text_form" type="text" id="nom" name="nom" value="<?php echo $contributor['last_name']; ?>" required>

                        <label for="role">Rôle :</label>
                        <div class="custom_select">
                            <select class="text_form_1" id="role" name="role" required>
                                <option value="Enseignant" <?php if($contributor['role'] == 'Enseignant') echo 'selected'; ?>>Enseignant</option>
                                <option value="Elève" <?php if($contributor['role'] == 'Elève') echo 'selected'; ?>>Elève</option>
                            </select>
                        </div>

                        <label for="prenom">Prénom :</label>
                        <input class="text_form" type="text" id="prenom" name="prenom" value="<?php echo $contributor['first_name']; ?>" required>

                        <label for="email">Email :</label>
                        <input class="text_form" type="email" id="email" name="email" value="<?php echo $contributor['email']; ?>" required>

                        <label for="password">Nouveau Mot de passe :</label>
                        <input class="text_form" type="password" id="password" name="password" value="">
                        
                        <div class="container_input">
                            <input class="btn_add_exercise_1" type="button" value="< Retour à la liste" onclick="window.location.href='administration.php'"> 
                            <input class="btn_add_exercise_2" type="submit" value="Enregistrer">
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-content">
        <h2>Sources</h2>
    </div>

    <div class="tab-content">
        <h2>Fichiers</h2>
    </div>
    
