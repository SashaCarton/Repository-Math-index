<?php
    require_once 'slide-bar.php';
    require_once 'connexion_db.php';
    require('config.php');

    $connection = mysqli_connect($server, $user, $pass, $dbName);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sqlLatestExercises = "SELECT * FROM exercices ORDER BY Date_Creation DESC LIMIT 5";
    $resultLatestExercises = mysqli_query($connection, $sqlLatestExercises);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include ('./header.php') ?>
    <title>Math Index</title>
</head>

<body>
    <div class="container">
        <?php
            require_once('connect-bar.php');
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
                    echo "<td>" . $row["Nom"] . "</td>";
                    echo "<td>" . $row["Thematique"] . "</td>";
                    echo "<td>" . $row["Difficulte"] . "</td>";
                    echo "<td>" . $row["Duree"] . "</td>";
                    echo "<td>" . $row["MotsCles"] . "</td>";
                    echo "<td>";
                    echo "<a href='" . $row["fichier_exercice"] . "' download><img src='assets/images/Group.png" . $row["fichier_exercice"] . "' alt='Exercice Image'>Exercice</a><br>";
                    echo "<a href='" . $row["fichier_exercice"] . "' download><img src='assets/images/Group.png" . $row["fichier_exercice"] . "' alt='Exercice Image'>Corriger</a>";
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

            $sqlAllExercises = "SELECT * FROM exercices LIMIT $offset, $resultsPerPage";
            $resultAllExercises = mysqli_query($connection, $sqlAllExercises);

            while ($row = mysqli_fetch_assoc($resultAllExercises)) {
                echo "<tr>";
                echo "<td>" . $row["Nom"] . "</td>";
                echo "<td>" . $row["Thematique"] . "</td>";
                echo "<td>" . $row["Difficulte"] . "</td>";
                echo "<td>" . $row["Duree"] . "</td>";
                echo "<td>" . $row["MotsCles"] . "</td>";
                echo "<td>";
                echo "<a href='" . $row["fichier_exercice"] . "' download><img src='assets/images/Group.png" . $row["fichier_exercice"] . "' alt='Exercice Image'>Exercice</a><br>";
                echo "<a href='" . $row["fichier_exercice"] . "' download><img src='assets/images/Group.png" . $row["fichier_exercice"] . "' alt='Exercice Image'>Corriger</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <?php
        $sqlTotalExercises = "SELECT COUNT(*) AS total FROM exercices";
        $resultTotalExercises = mysqli_query($connection, $sqlTotalExercises);
        $rowTotalExercises = mysqli_fetch_assoc($resultTotalExercises);
        $totalPages = ceil($rowTotalExercises['total'] / $resultsPerPage);

        echo "<div class='pagination'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a class=pagination href='mathematique.php?page=$i'>$i</a>";
        }
        echo "</div>";
        ?>
    </div>
    </div>

</body>

</html>
