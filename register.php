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
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    
    // Vérifier si la clé 'password' existe dans le tableau $_POST
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    // Hasher le mot de passe avec Argon2i
    $hashedPassword = password_hash($password, PASSWORD_ARGON2I);

    // Préparer et exécuter la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nom, $email, $hashedPassword);
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
    <label for="nom">Nom:</label>
    <input type="text" name="nom" id="nom" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br>

    <label for="password">Mot de passe:</label>
    <input type="password" name="password" id="password" required><br>

    <input type="submit" value="S'inscrire">
</form>
<a href="index.php">Retour</a>
