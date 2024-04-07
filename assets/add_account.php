<?php
# Fonction à appeler pour se connecter à la base de données
function connexionBdd() {
    // Informations d'identification

   // Nom du serveur
$server = "localhost";

// Variable contenant le login de l'utilisateur qui a les droits sur la base de données
$user = "root";

// Variable contenant le mot de passe correspondant au login de l'utilisateur qui a les droits sur la base de données
$pass = "";

// Nom de la base de données
$dbName = "math_index";

// Tentative de connexion à la base de données MySQL 
$co = new mysqli($server, $user, $pass, $dbName);
    // Vérifier si la connexion a échoué
    if ($co->connect_error) {
        die("Erreur de connexion à la base de données: " . $co->connect_error);
    }
    return $co;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Valider les données (vous pouvez ajouter vos propres validations ici)

    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES["profile_pic"]) && $_FILES["profile_pic"]["error"] == 0) {
        // Récupérer le nom du fichier
        $file_name = $_FILES["profile_pic"]["name"];
        // Récupérer le chemin temporaire du fichier
        $file_tmp = $_FILES["profile_pic"]["tmp_name"];
        // Générer un nom de fichier unique
        $new_file_name = uniqid() . "_" . $file_name;

        // Vérifier si le dossier de destination existe et a les permissions nécessaires
        $destination_folder = "../assets/image_user";
        if (!is_dir($destination_folder) || !is_writable($destination_folder)) {
            die("Le dossier de destination n'existe pas ou n'a pas les permissions nécessaires.");
        }

        // Vérifier si le fichier téléchargé est une image valide
        $image_info = getimagesize($file_tmp);
        if (!$image_info) {
            die("Le fichier téléchargé n'est pas une image valide.");
        }

        // Déplacer le fichier vers le dossier de destination
        move_uploaded_file($file_tmp, $destination_folder . $new_file_name);

        // Connexion à la base de données
        $connexion = connexionBdd();

        // Préparer la requête d'insertion
        $requete = $connexion->prepare("INSERT INTO utilisateur (nom, email, password, new_file_name) VALUES (?, ?, ?, ?)");

        // Exécuter la requête avec les valeurs des paramètres
        $requete->bind_param("ssss", $nom, $email, $password, $new_file_name);
        $requete->execute();
    } 

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
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required><br>

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required><br>

        <label for="profile_pic">Photo de profil :</label>
        <input type="file" id="profile_pic" name="profile_pic">

        <input type="submit" value="Ajouter">
    </form>
</body>
</html>
