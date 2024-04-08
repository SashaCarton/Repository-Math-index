<?php
session_start();

// Fonction pour afficher les erreurs de validation du formulaire
function displayErrors($errors, $field) {
    if (!empty($errors[$field])) {
        echo '<p class="errorMessage">' . $errors[$field] . '</p>';
    }
}

// Include the database connection file
require_once '../assets/components/slide-bar.php';
require_once '../assets/database/connexion_db.php';

// Define variables to store user input
$email = $password = '';
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

    // Validate password
    if (empty($_POST['password'])) {
        $errors['password'] = 'Password is required';
    } else {
        $password = $_POST['password'];
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
            $query = $mysqli->prepare('SELECT * FROM utilisateurs WHERE email = ?');

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

            if (empty($row)) {
                // If the query returns no rows, the user does not exist in the database, display an error message
                $errors['email'] = "Le nom d'utilisateur est incorrect.";
            } else {
                $password_hash = $row["password"];
                $valid = password_verify($password, $password_hash);
                if ($valid) {
                    // Set the session variable 'nom' with the value from the database
                    $_SESSION['nom'] = $row['nom'];
                    echo "Bonjour, " . $_SESSION['nom'];
                    // Redirect to the index.php page
                    header("Location: ../index.php");
                    exit();
                } else {
                    // Set the error message for incorrect password
                    $errors['password'] = 'Le mot de passe est incorrect.';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="../assets/css/style-connexion.css" rel="stylesheet">
    <title>Connexion</title>
</head>

<body>
    <div class="container">
        <div class="connect">
            <img src="images/Icon-login.png" alt="logo connexion">
            <h2><a href="connexion.php">Connexion</a></h2>
        </div>

        <div class="grey-bloc">
            <h1>Connexion</h1>

            <div class="description-form">
                <p>
                    Cet espace est réservé aux enseignants du lycée Saint-Vincent - Senlis.
                    Si vous n'avez pas encore de compte, veuillez effectuer votre demande
                    directement en envoyant un email à <a href="">contact@lyceestvincent.net</a>
                </p>

                <form action="connexion.php" method="POST" name="login">
                    <div class="form-email">
                        <label for="email">Email : <br></label>
                        <input id="email" type="text" name="email" placeholder="Saisissez votre adresse email">
                        <?php displayErrors($errors, 'email'); ?>
                    </div>

                    <div class="form-password">
                        <label for="password">Mot de passe : <br></label>
                        <input type="password" id="password" name="password" placeholder="Saisissez votre mot de passe">
                        <?php displayErrors($errors, 'password'); ?>
                    </div>

                    <div class="form-option">
                        <input type="submit" value="Connexion" name="submit">
                        <a href="">Mot de passe oublié ?</a>
                    </div>
                </form>
            </div>
            <?php require_once("../assets/components/footer.php"); ?>
        </div>
    </div>
</body>

</html>
