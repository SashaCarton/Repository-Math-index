<?php
require_once 'connexion_db.php';
require 'config.php';

$connection = mysqli_connect($server, $user, $pass, $dbName);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$sqlLatestExercises = "SELECT * FROM exercise ORDER BY id DESC LIMIT 5";
$resultLatestExercises = mysqli_query($connection, $sqlLatestExercises);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    include('header.php');
    ?>
    <style>
        .container h2 {
            padding: 0.5vw 0 0 0vw;
            margin-top: 10px;
            margin-bottom: 25px;
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
            <h1 class="color_text">Rechercher un exercice</h1>
            <div class="section_inside_exercise">
                <form method="GET" class="container_filter">
                    <div class="section_filter">
                        <label for="niveau" class="style_title">Niveau :</label>
                        <select name="niveau" id="niveau" class="style_filter">
                            <option value="">Sélectionnez un niveau</option>
                            <?php 
                                $mapping = [
                                    'Élémentaire' => [2, 3, 4, 5, 6],
                                    'Collège' => [7, 8, 9, 10],
                                    'Lycée' => [11, 12, 13],
                                    'Supérieur' => [14, 15, 16, 17, 18, 19, 20]
                                ];

                                foreach ($mapping as $categorie => $niveaux) {
                                    $niveauxString = implode(',', $niveaux);
                                    echo "<option value=\"$niveauxString\">$categorie</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="section_filter">
                        <label for="thematique" class="style_title">Thématique :</label>
                        <select name="thematique" id="thematique" class="style_filter">
                            <option value="">Sélectionnez une thématique</option>
                            <?php 
                            $sqlThematics = "SELECT * FROM thematic";
                            $resultThematics = mysqli_query($connection, $sqlThematics);
                            while ($row = mysqli_fetch_assoc($resultThematics)) {
                                echo "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="section_filter">
                        <label for="mots_cles" class="style_title">Mots-clés :</label>
                        <input type="text" name="mots_cles" id="mots_cles" placeholder="Entrez des mots-clés" class="style_filter">
                    </div>
                    <input type="submit" value="Rechercher" class="style_submit reseach_button">
                </form>
                <?php
                $sql = "SELECT * FROM exercise WHERE 1=1";
                $params = array();
                $types = '';

                if(isset($_GET['niveau']) && $_GET['niveau'] != '') {
                    $niveaux = explode(',', $_GET['niveau']);
                    $niveauxPlaceholders = implode(',', array_fill(0, count($niveaux), '?'));

                    $sql .= " AND difficulty IN ($niveauxPlaceholders)";
                    $types = str_repeat('i', count($niveaux));
                    $params = $niveaux;
                }

                if(isset($_GET['thematique']) && $_GET['thematique'] != '') {
                    $thematique = $_GET['thematique'];
                    $sql .= " AND thematic_id = ?";
                    $types .= 'i';
                    $params[] = $thematique;
                }

                if(isset($_GET['mots_cles']) && !empty($_GET['mots_cles'])) {
                    $mots_cles = htmlspecialchars($_GET['mots_cles']);
                    $sql .= " AND (name LIKE ? OR keywords LIKE ?)";
                    $types .= 'ss';
                    $params[] = '%' . $mots_cles . '%';
                    $params[] = '%' . $mots_cles . '%';
                }
                $resultsPerPage = 5;
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $resultsPerPage;

                $sql .= " LIMIT ? OFFSET ?";
                $types .= 'ii';
                $params[] = $resultsPerPage;
                $params[] = $offset;
                $stmt = mysqli_prepare($connection, $sql);

                if (!empty($params)) {
                    mysqli_stmt_bind_param($stmt, $types, ...$params);
                }

                mysqli_stmt_execute($stmt);
                $resultExercises = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($resultExercises) > 0) { 
                    echo "<h1 class='color_text'>" . mysqli_num_rows($resultExercises) . " exercices trouvés : </h1>";
                ?>
                    
                <table class="section_column">
                    <tr>
                        <th class="section_title_column_left font_weight_title">Nom</th>
                        <th class="font_weight_title">Difficulté</th>
                        <th class="font_weight_title">Mots clés</th>
                        <th class="font_weight_title table_padding">Durée</th>
                        <th class="section_title_column_right font_weight_title">Fichiers</th>
                    </tr>
                    <?php 
                    while($row = mysqli_fetch_assoc($resultExercises)) {
                        echo "<tr>";
                        echo "<td class='color_police_table'>" . $row["name"] . "</td>";
                        echo "<td class='color_police_table'>Niveau " . $row["difficulty"] . "</td>";
                        echo "<td>";
                        $keywords = explode(',', $row["keywords"]);
                        foreach ($keywords as $keyword) {
                            echo "<span class='keyword'>" . trim($keyword) . "</span>";
                        }
                        echo "</td>";
                        echo "<td>" . $row["duration"] . "h</td>";
                        echo "<td class=''>";
                        if ($row["exercise_file_id"]) {
                            echo "<a href='download.php?id=" . $row["exercise_file_id"] . "' download class='style_filter_file-1 color_police_table'><img class='icon_download' src='assets/images/Group.png'/>Exercice</a> ";
                        }
                        if ($row["correction_file_id"]) {
                            echo "<a href='download.php?id=" . $row["correction_file_id"] . "' download class='style_filter_file-2 color_police_table'><img class='icon_correction' src='assets/images/Group.png'/>Corriger</a>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
                <?php
                    } else {
                        echo "<h2>Aucun exercice trouvé</h2>";
                    }
                    
                    
                ?>
            </div>
            <?php
            $sqlTotalExercises = "SELECT COUNT(*) AS total FROM exercise";
                    $resultTotalExercises = mysqli_query($connection, $sqlTotalExercises);
                    $rowTotalExercises = mysqli_fetch_assoc($resultTotalExercises);
                    $totalPages = ceil($rowTotalExercises['total'] / $resultsPerPage);

                    
                    require_once('./footer.php');
                    echo "<div class='pagination'>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<a class=pagination href='research.php?page=$i'>$i</a>";
                    }
                    echo "</div>";
            ?>
        </div>  
    </div>
</body>
</html>

<?php
// Fermeture de la requête et de la connexion
mysqli_stmt_close($stmt);
mysqli_close($connection);
?>