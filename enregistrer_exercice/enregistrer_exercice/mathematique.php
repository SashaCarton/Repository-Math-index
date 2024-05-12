<?php
require_once 'slide-bar.php';
require_once 'connexion_db.php';
require 'config.php';

$connection = mysqli_connect($server, $user, $pass, $dbName);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
// Effectuer une requête SQL pour récupérer les exercices
$sqlLatestExercises = "SELECT e.name, t.name as thematic, e.difficulty, e.duration, e.keywords, f1.name as exercise_file, f2.name as correction_file 
        FROM exercise e 
        JOIN thematic t ON e.thematic_id = t.id 
        JOIN file f1 ON e.exercise_file_id = f1.id 
        JOIN file f2 ON e.correction_file_id = f2.id
        LIMIT 5";
$resultLatestExercises = mysqli_query($connection, $sqlLatestExercises);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
   <?php include ('./header.php')?>
    <title>Math Index</title>
</head>

<body>
<div class="container">
    <?php
    require_once 'connect-bar.php';
    ?>
    <div class="exercises">
        <h2>Les 5 derniers exercices ajoutés</h2>
        <table>
            <tr>
                <th>Nom de l'exercice</th>
                <th>Thématique</th>
                <th>Difficulté</th>
                <th>Durée</th>
                <th>Mots clés</th>
                <th>Fichiers</th>
            </tr>
            <?php
            if ($resultLatestExercises) {
                while ($row = mysqli_fetch_assoc($resultLatestExercises)) {
                    echo "<tr>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["thematic"] . "</td>";
                    echo "<td>" . $row["difficulty"] . "</td>";
                    echo "<td>" . $row["duration"] . "</td>";
                    echo "<td>" . $row["keywords"] . "</td>";
                    echo "<td>";
                    echo "<a href='" . $row["exercise_file"] . "' download><img src='../assets/images/Groupe.png' alt='Exercice Image'>Exercice</a><br>";
                    echo "<a href='" . $row["correction_file"] . "' download><img src='../assets/images/Groupe.png' alt='Exercice Image'>Corriger</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "Error: " . mysqli_error($connection);
            }
            ?>
        </table>
    </div>

    <div class="exercises">
        <h2>Tous les exercices</h2>
        <table>
            <tr>
                <th>Nom de l'exercice</th>
                <th>Thématique</th>
                <th>Difficulté</th>
                <th>Durée</th>
                <th>Mots clés</th>
                <th>Fichiers</th>
            </tr>
            <?php
            $resultsPerPage = 5;
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($currentPage - 1) * $resultsPerPage;

            $sqlAllExercises = "SELECT e.name, t.name as thematic, e.difficulty, e.duration, e.keywords, f1.name as exercise_file, f2.name as correction_file 
            FROM exercise e 
            JOIN thematic t ON e.thematic_id = t.id 
            JOIN file f1 ON e.exercise_file_id = f1.id 
            JOIN file f2 ON e.correction_file_id = f2.id
            LIMIT $offset, $resultsPerPage";
            $resultAllExercises = mysqli_query($connection, $sqlAllExercises);

            while ($row = mysqli_fetch_assoc($resultAllExercises)) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["thematic"] . "</td>";
                echo "<td>" . $row["difficulty"] . "</td>";
                echo "<td>" . $row["duration"] . "</td>";
                echo "<td>" . $row["keywords"] . "</td>";
                echo "<td>";
                echo "<a href='" . $row["exercise_file"] . "' download><img src='../assets/images/Group.png' alt='Exercice Image'>Exercice</a><br>";
                echo "<a href='" . $row["correction_file"] . "' download><img src='../assets/images/Group.png' alt='Exercice Image'>Corriger</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <?php
        $sqlTotalExercises = "SELECT COUNT(*) AS total FROM exercise";
        $resultTotalExercises = mysqli_query($connection, $sqlTotalExercises);
        $rowTotalExercises = mysqli_fetch_assoc($resultTotalExercises);
        $totalPages = ceil($rowTotalExercises['total'] / $resultsPerPage);

        echo "<div class='pagination'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a class='pagination' href='mathematique.php?page=$i'>$i</a>";
        }
        echo "</div>";
        ?>
    </div>
</div>

</body>

</html>
