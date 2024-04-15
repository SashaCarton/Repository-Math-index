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
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="assets/css/styleMathematique.css" rel="stylesheet">
        <link href="assets/css/styleIndex.css" rel="stylesheet">
        <title>Math Index</title>
    </head>

    <body>
        <div class="containerHome">
            <h1>Rechercher un exercice</h1>
            <div>
                <form method="GET">
                    <!-- Champs de sélection pour le niveau -->
                    <label for="niveau">Niveau :</label>
                    <select name="niveau" id="niveau">
                        <option value="">Sélectionnez un niveau</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>

                    <!-- Champs de sélection pour la thématique -->
                    <label for="thematique">Thématique :</label>
                    <select name="thematique" id="thematique">
                        <option value="">Sélectionnez une thématique</option>
                        <option value="Suites">Suites</option>
                        <option value="Continuité">Continuité</option>
                        <option value="Matriciel">Matriciel</option>
                    </select>

                    <!-- Champ de saisie pour les mots-clés -->
                    <label for="mots_cles">Mots-clés :</label>
                    <input type="text" name="mots_cles" id="mots_cles" placeholder="Entrez des mots-clés">

                    <!-- Bouton de soumission -->
                    <input type="submit" value="Rechercher">
                </form>

                <!-- Traitement du formulaire -->
                <?php 
                        $sql = "SELECT * FROM exercices WHERE 1=1"; // Requête de base

                        // Si des valeurs sont sélectionnées dans le formulaire, ajoutez les clauses WHERE correspondantes à la requête
                        if(isset($_GET['niveau']) && $_GET['niveau'] != '') {
                            $niveau = $_GET['niveau'];
                            $sql .= " AND Difficulte = '$niveau'";
                        }

                        if(isset($_GET['thematique']) && $_GET['thematique'] != '') {
                            $thematique = $_GET['thematique'];
                            $sql .= " AND Thematique = '$thematique'";
                        }

                        if(isset($_GET['mots_cles']) && !empty($_GET['mots_cles'])) {
                            $mots_cles = htmlspecialchars($_GET['mots_cles']);
                            $exercice = $connection->query('SELECT Nom, difficulte, MotsCles, Duree, Fichier FROM exercices WHERE Nom LIKE "%'.$mots_cles.'%" ORDER BY id DESC');
                            if(mysqli_num_rows($exercice) == 0) {
                                $exercice = $connection->query('SELECT Nom FROM exercices WHERE CONCAT(Nom, contenu) LIKE "%'.$exercice.'%" ORDER BY id DESC');
                            }
                        }

                        // Exécutez la requête SQL
                        $resultExercises = mysqli_query($connection, $sql);

                        // Afficher les résultats de la recherche
                        if(mysqli_num_rows($resultExercises) > 0) { 
                    
                            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                                // Le formulaire de recherche a été soumis
                                echo "<h2>Exercices trouvés : " . mysqli_num_rows($resultExercises) . "</h2>";
                                // Mettez votre logique de traitement du formulaire ici
                            
                            }
                ?>
                    
                    <table>
                        <th>Nom</th>
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
                            while($row = mysqli_fetch_assoc($resultExercises)) {
                                        
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
                                echo "</ul>";
                        ?>
                    </table>
                    <?php
                        } else {
                            echo "<h2>Aucun exercice trouvé</h2>";
                        }
                    ?>
                </div>
                <?php
            $sqlTotalExercises = "SELECT COUNT(*) AS total FROM exercices";
            $resultTotalExercises = mysqli_query($connection, $sqlTotalExercises);
            $rowTotalExercises = mysqli_fetch_assoc($resultTotalExercises);
            $totalPages = ceil($rowTotalExercises['total'] / $resultsPerPage);

            echo "<div class='pagination'>";
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<a class=pagination href='research.php?page=$i'>$i</a>";
            }
            echo "</div>";
        ?>
        </div>
        
    </body>

</html>