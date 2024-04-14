<?php

function connexionBdd() {
    $server = "localhost";
    $user = "root";
    $pass = "";
    $dbName = "math_index";

    $co = new mysqli($server, $user, $pass, $dbName);
    if ($co->connect_error) {
        die("Erreur de connexion à la base de données: " . $co->connect_error);
    }
    return $co;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (isset($_FILES["profile_pic"]) && $_FILES["profile_pic"]["error"] == 0) {
        $file_name = $_FILES["profile_pic"]["name"];
        $file_tmp = $_FILES["profile_pic"]["tmp_name"];
        $new_file_name = uniqid() . "_" . $file_name;

        $destination_folder = "../assets/image_user/";
        if (!is_dir($destination_folder) || !is_writable($destination_folder)) {
            die("Le dossier de destination n'existe pas ou n'a pas les permissions nécessaires.");
        }

        $image_info = getimagesize($file_tmp);
        if (!$image_info) {
            die("Le fichier téléchargé n'est pas une image valide.");
        }

        move_uploaded_file($file_tmp, $destination_folder . $new_file_name);

        $connexion = connexionBdd();

        $requete = $connexion->prepare("INSERT INTO user (last_name, email, password, profile_pic) VALUES (?, ?, ?, ?)");

        $requete->bind_param("ssss", $nom, $email, $password, $new_file_name);
        $requete->execute();
    } 

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
