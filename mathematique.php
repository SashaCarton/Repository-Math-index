<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/styleMathematique.css" rel="stylesheet">
    <title>Math Index</title>
</head>
<body>
    <div class="slideBar"> <!--For the bar on the left -->
        <div class="slidetitle">
            <img src="assets/images/Logo-Saint-Vincent.png" alt="logo Saint-Vincent">
            <div>
                <h1>Math Index</h1>
                <h3>Lycée Saint-Vincent-Senlis</h3>
            </div>
        </div>
        <div class="slide home">
            <img src="assets/images/Logo-Home.png" alt="Logo home">
            <a href="/">Accueil</a>
        </div>
        <div class="slide search">
            <img src="assets/images/Logo-loupe.png" alt="Logo loupe">
            <a href="recherche.html">Recherche</a>
        </div>
        <div class=" slide math">
            <img src="assets/images/logo-fonction.png" alt="Logo fonction Mathématique">
            <a>Mathématique</a>
        </div>
    </div>
    ()) {
        echo "Nom de l'exercice: " . $row["NomExercice"]. "<br>";
        echo "Thématique: " . $row["Thematique"]. "<br>";
        echo "Difficulté: " . $row["Difficulte"]. "<br>";
        echo "Durée: " . $row["Duree"]. "<br>";
        echo "Mots clés: " . $row["MotsCles"]. "<br>";
        echo "Nom de la matière: " . $row["NomMatiere"]. "<br>";
        echo "<br>";
    }
} else {
    echo "Aucun résultat trouvé pour '$search_term'";
}

// Fermeture de la connexion
$conn->close();
?>
</body>

</html>