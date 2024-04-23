<?php
// référence a la config SMTP du mailcatcher
    require_once 'config-SMTP.php';

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
        $errors['email'] = 'Email is required';
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

            // Prepare the query
            $query = $mysqli->prepare('SELECT * FROM user WHERE email = ?');

            if ($query === false) {
                die('Failed to prepare the SQL query: ' . $mysqli->error);
            }

            // Bind the parameters
            $query->bind_param('s', $email);

            // Execute the query
            $query->execute();

            // Get the result
            $result = $query->get_result();

            // Fetch the row
            $row = $result->fetch_assoc();

            if (empty($row)) 
                // If the query returns no rows, the user does not exist in the database, display an error message
                $errors['email'] = "L'Email est incorrect.";
             
            
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

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
                    Si vous avez perdu votre mot de passe, veuille renseigner votre email si dessous
                    pour envoyer automatiquement un mail a l'administrateur via le mail <a href="">contact@lyceestvincent.net</a>
                </p>

                <form action="lost-password.php" method="POST" name="login">
                    <div class="form-email">
                        <label for="email">Email : <br></label>
                        <input id="email" type="text" name="email" placeholder="Saisissez votre adresse email">
                        <?php displayErrors($errors, 'email'); ?>
                    </div>

                    <div class="form-option">
                        <input type="submit" value="Connexion" name="submit">
                        <a href="lost-password.php">Mot de passe oublié ?</a>
                    </div>
                </form>
            </div>
            <?php require_once("footer.php"); ?>
        </div>
    </div>
</body>

</html>
