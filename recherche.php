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
    <!-- CSS styles for table -->
    <style>
        /* CSS for table */
        .table {
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
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
        <div class="slide math">
            <img src="assets/images/logo-fonction.png" alt="Logo fonction Mathématique">
            <a>Mathematics</a>
        </div>
    </div>
    <!-- Main content area -->
    <div class="table">
        <!-- Latest exercises -->
        <h2>Derniers exercices</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom des exercices</th>
                    <th>Thème</th>
                    <th>Difficulté</th>
                    <th>Durée</th>
                    <th>Mots clés</th>
                    <th>Sujets</th>
                </tr>
            </thead>
            <tbody>
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

                // Query to retrieve latest exercises
                $latest_sql = "SELECT e.Nom AS NomExercice, e.Thematique, e.Difficulte, e.Duree, e.MotsCles, e.Fichier, m.Nom AS NomMatiere 
                               FROM Exercices e 
                               INNER JOIN Matieres m ON e.MatiereID = m.ID
                               ORDER BY e.Date_Creation DESC
                               LIMIT 5";

                $latest_result = $conn->query($latest_sql);

                if ($latest_result->num_rows > 0) {
                    // Display latest exercises
                    while ($row = $latest_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["NomExercice"] . "</td>";
                        echo "<td>" . $row["Thematique"] . "</td>";
                        echo "<td>" . $row["Difficulte"] . "</td>";
                        echo "<td>" . $row["Duree"] . "</td>";
                        echo "<td>" . $row["MotsCles"] . "</td>";
                        echo "<td>" . $row["NomMatiere"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No latest exercises</td></tr>";
                }
                ?>
            </tbody>
        </table>

           <!-- All exercises -->
           <h2>Tous les exercices</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom des exercices</th>
                    <th>Thème</th>
                    <th>Difficulté</th>
                    <th>Durée</th>
                    <th>Mots clés</th>
                    <th>Sujets</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Pagination variables
                $totalPerPage = 5; // Nombre d'exercices par page
                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Page actuelle
                $offset = ($page - 1) * $totalPerPage; // Décalage pour la requête SQL

                // Requête pour récupérer tous les exercices avec pagination
                $sql = "SELECT e.Nom AS NomExercice, e.Thematique, e.Difficulte, e.Duree, e.MotsCles, e.Fichier, m.Nom AS NomMatiere 
                        FROM Exercices e 
                        INNER JOIN Matieres m ON e.MatiereID = m.ID
                        LIMIT $offset, $totalPerPage";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Afficher tous les exercices
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["NomExercice"] . "</td>";
                        echo "<td>" . $row["Thematique"] . "</td>";
                        echo "<td>" . $row["Difficulte"] . "</td>";
                        echo "<td>" . $row["Duree"] . "</td>";
                        echo "<td>" . $row["MotsCles"] . "</td>";
                        echo "<td>" . $row["NomMatiere"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>0 résultats</td></tr>";
                }

                // Fermer la connexion
                $conn->close();
                ?>
            </tbody>
        </table>

<!-- Pagination -->
<div class="pagination">
    <?php
    // Create a new connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if connection is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Calculer le nombre total de pages
    $sql_count = "SELECT COUNT(*) AS total FROM Exercices";
    $count_result = $conn->query($sql_count);
    $total_exercises = $count_result->fetch_assoc()['total'];
    $total_pages = ceil($total_exercises / $totalPerPage);

    // Page précédente
    if ($page > 1) {
        echo "<a href='?page=" . ($page - 1) . "'>&laquo; Précédent</a>";
    }

    // Afficher les numéros de page
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='?page=$i'";
        if ($page == $i) {
            echo " class='current-page'";
        }
        echo ">$i</a>";
    }

    // Page suivante
    if ($page < $total_pages) {
        echo "<a href='?page=" . ($page + 1) . "'>Suivant &raquo;</a>";
    }

    // Close connection
    $conn->close();
    ?>
</div>
    </div>

</body>

</html>
