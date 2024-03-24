<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Preconnect to Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Importing Google Font - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Character encoding -->
    <meta charset="UTF-8">
    <!-- Responsive viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to custom CSS file -->
    <link href="assets/css/styleRecherche.css" rel="stylesheet">
    <!-- Title of the page -->
    <title>Math Index</title>
</head>
<body>
    <!-- Sidebar -->
    <div class="slideBar">
        <!-- Logo and title -->
        <div class="slidetitle">
            <img src="assets/images/Logo-Saint-Vincent.png" alt="logo Saint-Vincent">
            <div>
                <h1>Math Index</h1>
                <h3>Lycée Saint-Vincent-Senlis</h3>
            </div>
        </div>
        <!-- Navigation links -->
        <div class="slide home">
            <img src="assets/images/Logo-Home.png" alt="Logo home">
            <a href="/">Home</a>
        </div>
        <div class="slide search">
            <img src="assets/images/Logo-loupe.png" alt="Logo loupe">
            <a href="recherche.html">Search</a>
        </div>
        <div class=" slide math">
            <img src="assets/images/logo-fonction.png" alt="Logo fonction Mathématique">
            <a>Mathematics</a>
        </div>
    </div>
    <!-- Main content area -->
    <div class="table">
    <?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "math_index";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve all exercises
$sql = "SELECT e.Nom AS NomExercice, e.Thematique, e.Difficulte, e.Duree, e.MotsCles, e.Fichier, m.Nom AS NomMatiere 
        FROM Exercices e 
        INNER JOIN Matieres m ON e.MatiereID = m.ID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display data
    while($row = $result->fetch_assoc()) {
        echo "Exercise Name: " . $row["NomExercice"]. "<br>";
        echo "Theme: " . $row["Thematique"]. "<br>";
        echo "Difficulty: " . $row["Difficulte"]. "<br>";
        echo "Duration: " . $row["Duree"]. "<br>";
        echo "Keywords: " . $row["MotsCles"]. "<br>";
        echo "Subject Name: " . $row["NomMatiere"]. "<br>";
        echo "<br>";
    }
} else {
    echo "0 results";
}

// Query to perform a search
$search_term = "Suite"; // Search term (you can change this)
$search_sql = "SELECT e.Nom AS NomExercice, e.Thematique, e.Difficulte, e.Duree, e.MotsCles, e.Fichier, m.Nom AS NomMatiere 
                FROM Exercices e 
                INNER JOIN Matieres m ON e.MatiereID = m.ID
                WHERE e.Nom LIKE '%$search_term%' OR e.Thematique LIKE '%$search_term%' OR e.MotsCles LIKE '%$search_term%'";

$search_result = $conn->query($search_sql);

if ($search_result->num_rows > 0) {
    // Display search results
    echo "Search results for '$search_term': <br>";
    while($row = $search_result->fetch_assoc()) {
        echo "Exercise Name: " . $row["NomExercice"]. "<br>";
        echo "Theme: " . $row["Thematique"]. "<br>";
        echo "Difficulty: " . $row["Difficulte"]. "<br>";
        echo "Duration: " . $row["Duree"]. "<br>";
        echo "Keywords: " . $row["MotsCles"]. "<br>";
        echo "Subject Name: " . $row["NomMatiere"]. "<br>";
        echo "<br>";
    }
} else {
    echo "No results found for '$search_term'";
}

// Close connection
$conn->close();
?>
</div>

</body>

</html>
