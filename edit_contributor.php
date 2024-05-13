<?php
include ('./header.php');
require_once 'connexion_db.php';
require 'config.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "math_index";
$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("La connexion a échoué : " . $connection->connect_error);
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connection, $_GET['id']);

    $query = "SELECT * FROM user WHERE id = $id";
    $result = mysqli_query($connection, $query);
    $contributor = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un contributeur</title>
    <link rel="stylesheet" href="assets/css/administration.css">
</head>
<body>
    <?php require_once('slide-bar.php'); ?>
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
                $query = "UPDATE user SET last_name = '$nom', role = '$role', first_name = '$prenom', email = '$email', password = '$hashedPassword' WHERE id = $id";
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
            <h1>Administration</h1>
            <div class="tabs">
                <div class="tabs-btn-container">
                    <button class="tab">Contributeurs</button>
                    <button class="tab">Exercices</button>
                    <button class="tab">Matières</button>
                    <button class="tab">Classes</button>
                    <button class="tab">Thématiques</button>
                    <button class="tab">Compétences</button>
                    <button class="tab">Origines</button>
                </div>
                <div class="tab-content active-tab-content">
                    <div class="contributeurs">
                    <div class="add-contributor">
                        <h3>Modifier un contributeur</h3>
                        <form method="POST" action="edit_contributor.php" class="add-contributor">
                            <div class="container_form">
                                <div class="section_form_1">
                                    <label for="nom">Nom :</label>
                                    <input class="text_form" type="text" id="nom" name="nom" placeholder="Saisissez le nom du contributeur" value="<?php echo $contributor['last_name']; ?>" required>
                                    <label for="prenom">Prénom :</label>
                                    <input class="text_form" type="text" id="prenom" name="prenom" placeholder="Saisissez le prénom" value="<?php echo $contributor['first_name']; ?>" required>
                                    <label for="email">Email :</label>
                                    <input class="text_form" type="email" id="email" name="email" placeholder="Saisissez l'email" value="<?php echo $contributor['email']; ?>" required>
                                    <label for="password">Mot de passe :</label>
                                    <input class="text_form" type="password" id="password" name="password" placeholder="Saisissez le mot de passe" >
                                    <div class="container_input">
                                        <input class="btn_add_exercise_1" type="button" value="< Retour à la liste" onclick="window.location.href='administration.php'"> 
                                        <input class="btn_add_exercise_2" type="submit" value="Enregistrer">
                                    </div>
                                </div>
                                <div class="section_form_2">
                                    <label for="role">Rôle :</label>
                                    <div class="custom_select">
                                        <select class="text_form_1" id="role" name="role" required>
                                            <option value="Enseignant" <?php if($contributor['role'] == 'Enseignant') echo 'selected'; ?>>Enseignant</option>
                                            <option value="Elève" <?php if($contributor['role'] == 'Elève') echo 'selected'; ?>>Elève</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                        </form>
                    </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <?php include_once ('footer.php'); ?>
</body>
</html>
