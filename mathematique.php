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
    <style>

        td {
            padding: 12px 15px 12px 15px;
        }

        th {
            padding: 5px 15px 5px 15px;
        }

        .containerExercise {
            padding: 0vw 2vw 100% 2vw;
        }

        .color_text-2 {
            font-size: 1.2vw;
            padding: 0;
        }

        .container h2 {
            text-align: start;
            padding: 0px; 
            margin-top: 10px;
            margin-bottom: 0px;
        }

        .section_inside_exercise {
            background-color: #ffffff;
            border-radius: 7.36px;
            padding: 0.2vw 2vw 6.5vw 2vw;
            height: 62vh;
        }

        .icon_correction {
            right: 80px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: -20px;
        }

        .pagination a {
            color: #000;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color 0.3s;
            border: 1px solid #ddd;
            margin: 0 4px;
            border-radius: 4px;
        }

        .pagination a.active {
            background-color: gainsboro;
            color: black;
            border: black;
        }

        .pagination a:hover:not(.active) {
            background-color: black;
            color: white;
            border: black;
        }

    </style>
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
            <h1 class="color_text">Mathématique</h1>
            <div class="section_inside_exercise">
                <h2 class="color_text-2">Nouveautés</h2>
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
                        echo "<td class='color_police_table'>" . $row["duration"] . "h</td>";
                        echo "<td class='color_police_table'>";
                        $keywords = explode(',', $row["keywords"]);
                        $limitedKeywords = array_slice($keywords, 0, 3);
                        foreach ($limitedKeywords as $keyword) {
                            echo "<span class='keyword'>" . trim($keyword) . "</span>";
                        }
                        echo "<td>";
                        if ($row["exercise_file"]) {
                            echo "<a href='download.php?id=" . $row["exercise_file"] . "' download class='style_filter_file-1 color_police_table'><img class='icon_download' src='assets/images/Group.png'/>Exercice</a> ";
                        }                        
                        if ($row["correction_file"]) {
                            echo "<a href='download.php?id=" . $row["correction_file"] . "' download class='style_filter_file-2 color_police_table'><img class='icon_correction' src='assets/images/Group.png'/>Corriger</a>";
                        }                        
                        echo "</td>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>

                <h2 class="color_text-2">Tous les exercices</h2>
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
                    $resultsPerPage = 5;
                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($currentPage - 1) * $resultsPerPage;
                    $sqlAllExercises .= " LIMIT " . $offset . ", " . $resultsPerPage;
                    $resultAllExercises = mysqli_query($connection, $sqlAllExercises);
                    while ($row = mysqli_fetch_assoc($resultAllExercises)) {
                        echo "<tr>";
                        echo "<td class='color_police_table'>" . $row["name"] . "</td>";
                        echo "<td class='color_police_table'>Primaire</td>";
                        echo "<td class='color_police_table'>" . $row["thematic"] . "</td>";
                        echo "<td class='color_police_table'>" . $row["difficulty"] . "</td>";
                        echo "<td class='color_police_table'>" . $row["duration"] . "h</td>";
                        echo "<td class='color_police_table'>";
                        $keywords = explode(',', $row["keywords"]);
                        $limitedKeywords = array_slice($keywords, 0, 3);
                        foreach ($limitedKeywords as $keyword) {
                            echo "<span class='keyword'>" . trim($keyword) . "</span>";
                        }
                        echo "<td>";
                        if ($row["exercise_file"]) {
                            echo "<a href='download.php?id=" . $row["exercise_file"] . "' download class='style_filter_file-1 color_police_table'><img class='icon_download' src='assets/images/Group.png'/>Exercice</a> ";
                        }                        
                        if ($row["correction_file"]) {
                            echo "<a href='download.php?id=" . $row["correction_file"] . "' download class='style_filter_file-2 color_police_table'><img class='icon_correction' src='assets/images/Group.png'/>Corriger</a>";
                        } 
                        echo "</tr>";
                    }                    
                    ?>                    
                </table>
                
            </div>
            <?php
                    $sqlTotalExercises = "SELECT COUNT(*) AS total FROM exercise";
                    $resultTotalExercises = mysqli_query($connection, $sqlTotalExercises);
                    $rowTotalExercises = mysqli_fetch_assoc($resultTotalExercises);
                    $totalPages = ceil($rowTotalExercises['total'] / $resultsPerPage);

                    echo "<div class='pagination'>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<a class=pagination href='mathematique.php?page=$i'>$i</a>";
                    }
                    echo "</div>";
                    require_once('./footer.php');
                ?>
        </div>
    </div>
</body>
</html>
