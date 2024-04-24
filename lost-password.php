<?php

// Fonction pour afficher les erreurs de validation du formulaire
function displayErrors($errors, $field) {
    if (!empty($errors[$field])) {
        echo '<p class="errorMessage">' . $errors[$field] . '</p>';
    }
}

// Include the database connection file
require_once 'slide-bar.php';
require_once 'connexion_db.php';

// Define variables to store user input
$email = '' ;
$errors = array();
$message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate email
    if (empty($_POST['email'])) {
        $errors['email'] = 'Un email est requis pour continuer.';
    } else {
        $email = $_POST['email'];
    }

    // If there are no validation errors, proceed with login
    if (empty($errors)) {
        // Create a new mysqli instance
        $mysqli = new mysqli('localhost', 'root', '', 'math_index');

        if ($mysqli->connect_errno) {
            die('Failed to connect to MySQL: ' . $mysqli->connect_error);
        }

        if (isset($_POST['submit'])) {
            $email = $_POST['email'];

            // Preparation de la requête SQL
            $query = $mysqli->prepare('SELECT email FROM utilisateurs WHERE email = ?');

            // Si la requête échoue, afficher un message d'erreur
            if ($query === false) {
                die('Failed to prepare the SQL query: ' . $mysqli->error);
            }

            // Utilisation des BindParam pour sécuriser la requête
            $query->bind_param('s', $email);

            // Execute the query
            $query->execute();

            // Stockage du résultat de la requête dans une variable $result
            $result = $query->get_result();

            // Fetch the row
            $row = $result->fetch_assoc();

            // Vérification de l'existence de l'email dans la base de données.
            if ($row) {
                // Si l'email existe dans la base de données
            } else {
                // Si l'email n'existe pas dans la base de données, afficher un message d'erreur
                $errors['email'] = 'L\'adresse email n\'existe pas, Veuillez réessayer.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include ('./header.php'); ?>
    <link rel="stylesheet" href="assets\css\lost-password.css">
    <title>Connexion</title>
</head>

<body>
    <div class="container">

        <?php require_once("connect-bar.php"); ?>

        <div class="grey-bloc">
            <h1>Connexion</h1>

            <div class="description-form">
                <p>
                Cet espace est réservé aux enseignants du lycée Saint-Vincent - Senlis.
                Si vous avez perdu votre mot de passe, veuillez renseigner votre email ci-dessous
                pour envoyer automatiquement un mail à l'administrateur via le mail <a href="">contact@lyceestvincent.net</a>
                </p>

                <form action="lost-password.php" method="POST" name="login">
                    <div class="form-email">
                        <label for="email">Email : <br></label>
                        <input id="email" type="text" name="email" placeholder="Saisissez votre adresse email">
                        <?php displayErrors($errors, 'email'); ?>
                    </div>

                    <div class="form-option">
                        <input type="submit" value="Envoyer" name="submit">
                        <a href="lost-password.php">Mot de passe oublié ?</a>
                    </div>
                </form>
            </div>
            <?php require_once("footer.php"); ?>
        </div>
    </div>
</body>

</html>
