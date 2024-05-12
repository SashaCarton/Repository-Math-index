<?php 
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "math_index";
require_once 'connexion_db.php';
require 'config.php';
$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "SELECT * FROM user WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $contributor = mysqli_fetch_assoc($result);

    if (isset($_COOKIE['role']) && $_COOKIE['role'] === 'admin') {
        $id = $_GET['id'];

        $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: administration.php");
            $_POST["success"] = 1;
            exit;
        } else {
            echo "Une erreur s'est produite lors de la suppression du contributeur.";
        }
    } else {
        echo "Vous n'êtes pas autorisé à supprimer un contributeur.";
    }
} else {
    echo "L'identifiant du contributeur n'est pas spécifié.";
}

$conn->close();
?>
