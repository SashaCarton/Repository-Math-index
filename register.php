<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "math_index";
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);
    $email = htmlspecialchars($_POST["email"]);
    $role = htmlspecialchars($_POST["role"]);
    $password = htmlspecialchars($_POST["password"]);
    $hashedPassword = password_hash($password, PASSWORD_ARGON2I);

  
    $stmt = $conn->prepare("INSERT INTO user (last_name, first_name, email, role, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nom, $prenom, $email, $role, $hashedPassword);
    $stmt->execute();

  
    if ($stmt->affected_rows > 0) {
        echo "Contributeur ajouté avec succès!";
    } else {
        echo "Une erreur s'est produite lors de l'ajout du contributeur.";
    }

   
    $stmt->close();
}


$conn->close();
header("Location: administration.php");
$_POST["success"] = 1;
exit;
?>