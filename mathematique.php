<?php
require_once 'connexion_db.php';
require('config.php');

$connection = mysqli_connect($server, $user, $pass, $dbName);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$sqlLatestExercises = "SELECT e.name, t.name as thematic, e.difficulty, e.duration, e.keywords, f1.name as exercise_file, f2.name as correction_file 
        FROM exercise e 
        JOIN thematic t ON e.thematic_id = t.id 
        JOIN file f1 ON e.exercise_file_id = f1.id 
        JOIN file f2 ON e.correction_file_id = f2.id
        ORDER BY e.id DESC
        LIMIT 3";
$resultLatestExercises = mysqli_query($connection, $sqlLatestExercises);

$sqlAllExercises = "SELECT e.name, t.name as thematic, e.difficulty, e.duration, e.keywords, f1.name as exercise_file, f2.name as correction_file 
        FROM exercise e 
        JOIN thematic t ON e.thematic_id = t.id 
        JOIN file f1 ON e.exercise_file_id = f1.id 
        JOIN file f2 ON e.correction_file_id = f2.id";
$resultAllExercises = mysqli_query($connection, $sqlAllExercises);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    include('header.php');
    ?>
</head>

<body>
    <?php
    require_once 'slide-bar.php';
    ?>
    <div class="container">
        <?php
        require_once 'slide-bar.php';
        require_once('connect-bar.php');
        ?>
        <div class="containerExercise">
            <h1 class="color_text">Les 3 derniers exercices</h1>
            <table class="section_column">
                <tr>
                    <th class="section_title_column_left font_weight_title">Nom</th>
                    <th class="font_weight_title">Niveau</th>
                    <th class="font_weight_title">Thématique</th>
                    <th class="font_weight_title">Difficulté</th>
                    <th class="font_weight_title table_padding">Durée</th>
                    <th class="font_weight_title">Mots clés</th>
                    <th class="section_title_column_right font_weight_title">Fichier</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($resultLatestExercises)) {
                    echo "<tr>";
                    echo "<td class='color_police_table'>" . $row["name"] . "</td>";
                    echo "<td class='color_police_table'>Primaire</td>";
                    echo "<td class='color_police_table'>" . $row["thematic"] . "</td>";
                    echo "<td class='color_police_table'>" . $row["difficulty"] . "</td>";
                    echo "<td class='color_police_table'>" . $row["duration"] . "</td>";
                    echo "<td class='color_police_table'>" . $row["keywords"] . "</td>";
                    echo "<td class='color_police_table'>";
                    echo "<a href='" . $row["exercise_file"] . "' download><img src='assets/images/Group.png' alt='Exercice Image'>Exercice</a><br>";
                    echo "<a href='" . $row["correction_file"] . "' download><img src='assets/images/Group.png' alt='Exercice Image'>Corriger</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>

            <h1 class="color_text">Tous les exercices</h1>
            <table class="section_column">
                <tr>
                    <th class="section_title_column_left font_weight_title">Nom</th>
                    <th class="font_weight_title">Niveau</th>
                    <th class="font_weight_title">Thématique</th>
                    <th class="font_weight_title">Difficulté</th>
                    <th class="font_weight_title table_padding">Durée</th>
                    <th class="font_weight_title">Mots clés</th>
                    <th class="section_title_column_right font_weight_title">Fichier</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($resultAllExercises)) {
                    echo "<tr>";
                    echo "<td class='color_police_table'>" . $row["name"] . "</td>";
                    echo "<td class='color_police_table'>Primaire</td>";
                    echo "<td class='color_police_table'>" . $row["thematic"] . "</td>";
                    echo "<td class='color_police_table'>" . $row["difficulty"] . "</td>";
                    echo "<td class='color_police_table'>" . $row["duration"] . "</td>";
                    echo "<td class='color_police_table'>" . $row["keywords"] . "</td>";
                    echo "<td class='color_police_table'>";
                    echo "<a href='" . $row["exercise_file"] . "' download><img src='assets/images/Group.png' alt='Exercice Image'>Exercice</a><br>";
                    echo "<a href='" . $row["correction_file"] . "' download><img src='assets/images/Group.png' alt='Exercice Image'>Corriger</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
