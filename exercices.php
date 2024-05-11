<?php
   
require_once 'connexion_db.php';
require 'config.php';

$connection = mysqli_connect($server, $user, $pass, $dbName);
$id = $_COOKIE['id'];
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Récupère l'id de l'exercice depuis l'URL
$sqlExercise = "SELECT e.name, t.name as thematic, e.difficulty, e.duration, e.keywords, f1.name as exercise_file, f2.name as correction_file 
        FROM exercise e 
        JOIN thematic t ON e.thematic_id = t.id 
        JOIN file f1 ON e.exercise_file_id = f1.id 
        JOIN file f2 ON e.correction_file_id = f2.id
        WHERE e.id = $id"; 
     
$resultExercise = mysqli_query($connection, $sqlExercise);
$rowExercise = mysqli_fetch_assoc($resultExercise);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        include 'header.php';
    ?>
    <style>
        /* Styles CSS */
    </style>
</head>

<body>
    <?php
        require_once 'slide-bar.php';
    ?>
    <div class="container">
        <?php
            require_once 'slide-bar.php';
            require_once 'connect-bar.php';
        ?>
        <div class="containerExercise">
            <h1 class="color_text">Mathématique</h1>
            <div class="section_inside_exercise">
                <h2 class="color_text-2">Exercice</h2>
                <?php
                var_dump($varExercise);

   ?>
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
                    <tr>
                        <td class="color_police_table"><?php echo $rowExercise["name"]; ?></td>
                        <td class="color_police_table">Primaire</td>
                        <td class="color_police_table"><?php echo $rowExercise["thematic"]; ?></td>
                        <td class="color_police_table"><?php echo $rowExercise["difficulty"]; ?></td>
                        <td class="color_police_table"><?php echo $rowExercise["duration"]; ?></td>
                        <td class="color_police_table">
                            <?php
                            $keywords = explode(',', $rowExercise["keywords"]);
                            $limitedKeywords = array_slice($keywords, 0, 3);
                            foreach ($limitedKeywords as $keyword) {
                                echo "<span class='keyword'>" . trim($keyword) . "</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($rowExercise["exercise_file"]) {
                                echo "<a href='download.php?id=" . $rowExercise["exercise_file"] . "' download class='style_filter_file-1 color_police_table'><img class='icon_download' src='assets/images/Group.png'/>Exercice</a> ";
                            }                        
                            if ($rowExercise["correction_file"]) {
                                echo "<a href='download.php?id=" . $rowExercise["correction_file"] . "' download class='style_filter_file-2 color_police_table'><img class='icon_correction' src='assets/images/Group.png'/>Corriger</a>";
                            }                        
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            <?php
            require_once 'footer.php';
            require_once 'slide-bar.php';
            require_once 'connexion_db.php';
            if (!isset($_COOKIE['role']) || $_COOKIE['role'] != 'admin') {
                header('location: connexion.php');
                exit;
            }
            ?>
        </div>
    </div>
</body>
</html>
