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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);
    $email = htmlspecialchars($_POST["email"]);
    $role = htmlspecialchars($_POST["role"]);
    $password = htmlspecialchars($_POST["password"]);
    $hashedPassword = password_hash($password, PASSWORD_ARGON2I);

    // Préparer et exécuter la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO user (last_name, first_name, email, role, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nom, $prenom, $email, $role, $hashedPassword);
    $stmt->execute();

    // Vérifier si l'insertion a réussi
    if ($stmt->affected_rows > 0) {
        echo "Contributeur ajouté avec succès!";
    } else {
        echo "Une erreur s'est produite lors de l'ajout du contributeur.";
    }

    // Fermer la requête
    $stmt->close();
}

// Fermer la connexion à la base de données
$conn->close();
header("Location: administration.php?success=1");
exit;
?>