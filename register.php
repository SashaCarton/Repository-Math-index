<?php

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "math_index";
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $last_name = htmlspecialchars($_POST["last_name"]);
    $email = htmlspecialchars($_POST["email"]);
    $first_name = htmlspecialchars($_POST["first_name"]);
    $password = htmlspecialchars($_POST["password"]);
    $confirm_password = htmlspecialchars($_POST["confirm_password"]);

    // Vérifier si les mots de passe correspondent
    if ($password != $confirm_password) {
        echo "Les mots de passe ne correspondent pas.";
        exit;
    }

    // Ajoutez ici des validations supplémentaires pour les champs de formulaire

    // Hasher le mot de passe avec Argon2i
    $hashedPassword = password_hash($password, PASSWORD_ARGON2I);

    // Préparer et exécuter la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashedPassword);
    $stmt->execute();

    // Vérifier si l'insertion a réussi
    if ($stmt->affected_rows > 0) {
        echo "Utilisateur inscrit avec succès!";
    } else {
        echo "Une erreur s'est produite lors de l'inscription de l'utilisateur.";
    }

    // Fermer la requête et la connexion
    $stmt->close();
    $conn->close();
}
?>

<h1>Inscription</h1>
<form method="POST" action="">
    <label for="last_name">Nom:</label>
    <input type="text" name="last_name" id="last_name" required><br>

    <label for='first_name'>Prénom:</label>
    <input type='text' name='first_name' id='first_name' required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br>

    <label for="password">Mot de passe:</label>
    <input type="password" name="password" id="password" required><br>

    <label for="confirm_password">Confirmer le mot de passe:</label>
    <input type="password" name="confirm_password" id="confirm_password" required><br>

    <input type="submit" value="S'inscrire">
</form>
<a href="index.php">Retour</a>

