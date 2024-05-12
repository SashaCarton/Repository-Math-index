<?php
require_once 'connexion_db.php';
require 'config.php';

$connection = mysqli_connect($server, $user, $pass, $dbName);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$userId = $_COOKIE['id']; // Assuming the user ID is stored in a cookie
$sqlAllExercises = "SELECT e.name, t.name as thematic, e.difficulty, e.duration, e.keywords, f1.name as exercise_file, f2.name as correction_file 
FROM exercise e 
JOIN thematic t ON e.thematic_id = t.id 
JOIN file f1 ON e.exercise_file_id = f1.id 
JOIN file f2 ON e.correction_file_id = f2.id";
$sqlAllExercises .= " WHERE e.created_by_id = $userId";

$resultAllExercises = mysqli_query($connection, $sqlAllExercises);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    include 'header.php';
    ?>
    <style>
        /* CSS styles here */
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
            <h1 class="color_text">Mes exercices</h1>
            <div class="section_inside_exercise">
                <h2 class="color_text-2">Tous les exercices :</h2>
                <table class="section_column">
                    <!-- All exercises table here -->
                    <?php while ($rowAllExercise = mysqli_fetch_assoc($resultAllExercises)) { ?>
                        <tr>
                            <td><?php echo $rowAllExercise["name"]; ?></td>
                            <td><?php echo $rowAllExercise["thematic"]; ?></td>
                            <td><?php echo $rowAllExercise["difficulty"]; ?></td>
                            <?php echo "<td>" . $rowAllExercise["duration"] . "h</td>";?>
                            <td>
                                <?php
                                $keywords = explode(',', $rowAllExercise["keywords"]);
                                $limitedKeywords = array_slice($keywords, 0, 3);
                                foreach ($limitedKeywords as $keyword) {
                                    echo "<span class='keyword'>" . trim($keyword) . "</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($rowAllExercise["exercise_file"]) {
                                    echo "<a href='download.php?id=" . $rowAllExercise["exercise_file"] . "' download class='style_filter_file-1 color_police_table'><img class='icon_download' src='assets/images/Group.png'/>Exercice</a> ";
                                }
                                if ($rowAllExercise["correction_file"]) {
                                    echo "<a href='download.php?id=" . $rowAllExercise["correction_file"] . "' download class='style_filter_file-2 color_police_table'><img class='icon_correction' src='assets/images/Group.png'/>Corriger</a>";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <?php
            // Pagination code here
            require_once 'footer.php';
            ?>
        </div>
    </div>
</body>
</html>
