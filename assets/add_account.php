<?php
# Fonction à appeler pour se connecter à la base de données
function connexionBdd() {
    // Informations d'identification
    // Variable contenant l'adresse du serveur web
    $server = "localhost";

    // Variable contenant le login de l'utilisateur qui a les droits sur la base de données
    $user = "root";

    // Variable contenant le mot de passe correspondant au login de l'utilisateur qui a les droits sur la base de données
    $pass = "";

    // Nom de la base de données
    $dbName = "math_index";

    // Permet d'utiliser les variables d'identification pour la connexion
    global $server, $user, $pass, $dbName;

    // Tentative de connexion à la base de données MySQL 
    try {
        // Chaîne de connexion avec l'API PDO
        $co = new PDO("mysql:host=" . $server . ";dbname=" . $dbName, $user, $pass);
        // On définit le mode d'erreur de PDO sur Exception
        $co->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $co;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Valider les données (vous pouvez ajouter vos propres validations ici)

    // Connexion à la base de données
    $connexion = connexionBdd();

    // Préparer la requête d'insertion
    $requete = $connexion->prepare("INSERT INTO compte (nom, email, mot_de_passe) VALUES (:email, :password)");

    // Exécuter la requête avec les valeurs des paramètres
    $requete->execute([
        "email" => $email,
        "password" => $password
    ]);

    // Rediriger vers une page de succès ou afficher un message de succès
    header("Location: success.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajout de compte</title>
</head>
<body>
    <h1>Ajout de compte</h1>
    <form method="POST" action="">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required><br>

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" value="Ajouter">
    </form>
</body>
</html>
