<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    include ('./header.php');
    require_once 'connexion_db.php';
    require 'config.php';
    $connection = mysqli_connect($server, $user, $pass, $dbName);
    ?>
</head>
<body>
<?php
require_once('slide-bar.php');
require_once('connexion_db.php');
if (!isset($_COOKIE['role']) || $_COOKIE['role'] != 'admin'){
    header('location: connexion.php');
    exit;
}
?>
<link rel="stylesheet" href="assets/css/administration.css">
<div class="container">
    <?php require_once('connect-bar.php'); ?>
    <div class="grey-bloc">
        <h1>
            Administration
        </h1>

        <div class="tabs">
            <div class="tabs-btn-container">
                <button class="tab">Contributeurs</button>
                <button class="tab">Exercices</button>
                <button class="tab">Matières</button>
                <button class="tab">Classes</button>
                <button class="tab">Thématiques</button>
                <button class="tab">Compétences</button>
                <button class="tab">Origines</button>
            </div>
            <div id="confirmDialog" style="display: none;">
                <div class="back">
                    <span id="croix">
                        <img src="assets/images/croix.png" href="administration.php" alt="Supprimer">
                    </span>
                    
                    <div class="dialog">
                        <img src="assets/images/check.png" alt="check">
                        <div>
                            <h2>Confirmez la suppression</h2>
                            <p>Êtes-vous sûr de vouloir supprimer ce contributeur ?</p>
                        </div>
                    </div>
                    <button id="confirmNo">Annuler</button>
                    <button id="confirmYes">Confirmer</button>
                </div>
            </div>
            <div class="tab-content active-tab-content">
                <div class="contributeurs">
                    <h2>Gestion des contributeurs</h2>
                    <label for="search">
                        <?php
                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        if(isset($_GET['search']) && !empty($_GET['search'])) {
                            echo 'Résultat pour : ' . $search;
                        } else {
                            echo 'Rechercher un contributeur par nom, prénom ou email :';
                        }
                        ?>
                    </label>
                    <div class="search">
                        <form class="container_title_form">
                            <div class="section_title_form">
                                <input type="text" id="search" name="search">
                                <input type="submit" id="buttonSearch" value="Rechercher">
                            </div>
                            <input type="button" id="buttonAdd" value="Ajouter +" onclick="showAddContributorForm()">
                        </form>
                    </div>
                    <!-- Mettre ici php -->
                    <table class="section_column">
                        <tr>
                            <th class="section_title_column_left font_weight_title">Nom</th>
                            <th class="font_weight_title">Prénom</th>
                            <th class="font_weight_title">Email</th>
                            <th class="font_weight_title">Rôle</th>
                            <th class="section_title_column_right font_weight_title">Actions</th>
                        </tr>
                        <?php
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $limit = 4;
                        $start = ($page - 1) * $limit;
                        if(isset($_GET['search'])) {
                            $search = $_GET['search'];
                            $sql = "SELECT * FROM user WHERE last_name LIKE '%$search%' OR first_name LIKE '%$search%' OR email LIKE '%$search%' LIMIT $start, $limit";
                        } else {
                            $sql = "SELECT * FROM user LIMIT $start, $limit";
                        }
                        $result = $connection->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='color_police_table'>" . $row["last_name"] . "</td>";
                                echo "<td class='color_police_table'>" . $row["first_name"] . "</td>";
                                echo "<td class='color_police_table'>" . $row["email"] . "</td>";
                                echo "<td class='color_police_table'>" . $row["role"] . "</td>";
                                echo "<td class='color_police_table'><a href='edit_contributor.php?id=" . $row["id"] . "'><img src='assets/images/Icon-modify.png'>Modifier</a> <a id='delete-dialog' href='DelContributeur.php?id=" . $row["id"] . "'><img src='assets/images/Icon-trash.png'>Supprimer</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "0 results";
                        }
                        $sql = "SELECT COUNT(*) AS total FROM user";
                        $result = $connection->query($sql);
                        $row = $result->fetch_assoc();
                        $total_pages = ceil($row["total"] / $limit);

                        if (isset($_POST['success'])){
                            echo "<script>
                                setTimeout(function() {
                                    document.getElementById('successMessage').style.display = 'none';
                                }, 3000);
                                $(document).ready(function(){
                                    $('.add-contributor').animate({
                                        left: '250px',
                                        opacity: '0.5',
                                        height: '150px',
                                        width: '150px'
                                    });
                                });
                            </script>";
                            echo "<div id='successMessage' class='fade-in'>Opération effectuée avec succès</div>";
                            exit;
                        }
                        ?>
                    </table>
                    <?php
                    $sql = "SELECT COUNT(*) AS total FROM user";
                    $result = $connection->query($sql);
                    $row = $result->fetch_assoc();
                    $total_pages = ceil($row["total"] / $limit);

                    echo "<div class='pagination'>";
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "<a href='administration.php?page=" . $i . "'";
                        if ($i == $page) {
                            echo " class='active'";
                        }
                        echo ">" . $i . "</a>";
                    }
                    ?>
                </div>
            </div>
            <div class="tab-content">
                <div class="exercices"> 
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
                                        'Lycée' => [11, 12, 13]
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
                                    while ($row = mysqli_fetch_assoc($resultThematics)) : ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php endwhile; ?>
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
                        if(isset($_GET['niveau']) && $_GET['niveau'] != '') {
                            $niveaux = explode(',', $_GET['niveau']);
                            $niveauxPlaceholders = implode(',', array_fill(0, count($niveaux), '?'));
                            $sql .= " AND difficulty IN ($niveauxPlaceholders)";
                            $stmt = mysqli_prepare($connection, $sql);
                            mysqli_stmt_bind_param($stmt, str_repeat('i', count($niveaux)), ...$niveaux);
                            mysqli_stmt_execute($stmt);
                            $resultExercises = mysqli_stmt_get_result($stmt);
                        } else {
                            $resultExercises = mysqli_query($connection, $sql);
                        }

                        if(mysqli_num_rows($resultExercises) > 0) { 
                            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                                echo "<h2 class='color_text'>" . mysqli_num_rows($resultExercises) . " exercices trouvés : </h2>";
                            }
                            ?>
                            <table class="section_column">
                                <tr>
                                    <th class="section_title_column_left font_weight_title">Nom</th>
                                    <th class="font_weight_title">Difficulté</th>
                                    <th class="font_weight_title">Mots clés</th>
                                    <th class="font_weight_title table_padding">Durée</th>
                                    <th class="section_title_column_right font_weight_title">Fichiers</th>
                                    <th class="section_title_column_right font_weight_title">Modifier</th>
                                </tr>
                                <?php 
                                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                                $resultsPerPage = 5;
                                $offset = ($currentPage - 1) * $resultsPerPage;
                                $sql .= " LIMIT $offset, $resultsPerPage";
                                $resultExercises = mysqli_query($connection, $sql);

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
                                    echo "<td>" . $row["duration"] . "</td>";
                                    echo "<td class=''>";
                                    if ($row["exercise_file_id"]) {
                                        echo "<a href='download.php?id=" . $row["exercise_file_id"] . "' download class='style_filter_file-1 color_police_table'><img class='icon_download' src='assets/images/Group.png'/>Exercice</a> ";
                                    }
                                    if ($row["correction_file_id"]) {
                                        echo "<a href='download.php?id=" . $row["correction_file_id"] . "' download class='style_filter_file-2 color_police_table'><img class='icon_correction' src='assets/images/Group.png'/>Corriger</a>";
                                    }
                                    echo "</td>";
                                    echo "<td class=''>";
                                    echo "<a href='submit-exercice.php?id=" . $row["id"] . "' class='style_filter_file-2 color_police_table'>Modifier</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </table>
                            <?php
                        } else {
                            echo "<p>Aucun exercice trouvé.</p>";
                        }
                        ?>
                    </table>
                    
                   
                        </tbody>
                    </table>
                    <?php
                    $sqlTotalExercises = "SELECT COUNT(*) AS total FROM exercise";
                    $resultTotalExercises = mysqli_query($connection, $sqlTotalExercises);
                    $rowTotalExercises = mysqli_fetch_assoc($resultTotalExercises);
                    $totalPages = ceil($rowTotalExercises['total'] / $resultsPerPage);

                    echo "<div class='pagination'>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<a class='pagination-link' href='submit-exercice.php?page=$i'>$i</a>";
                    }
                    echo "</div>";
                    ?>
            </div>
            <div class="tab-content">
                <div class="matiere">
                    <h3>Liste des matières</h3>
                    <table class="section_column">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Modifier</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sqlThematics = "SELECT * FROM thematic";
                            $resultThematics = mysqli_query($connection, $sqlThematics);
                            while ($row = mysqli_fetch_assoc($resultThematics)) {
                                echo "<tr>";
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td><a href='submit-exercice.php?id=" . $row["id"] . "'>Modifier</a></td>";
                                echo "</tr>";

                            }
                            ?>
                        </tbody>
                    </table>
                    <form action="add-thematic.php" method="POST">
                        <input type="text" class="addmatiere" name="name" placeholder="Nom de la matière">
                        <input type="submit" value="Ajouter">
                    </form>
                </div>

            <div class="tab-content">
                <div class="classes">
                    <h3>Liste des exercices</h3>
                    <div class="search-bar">
                        <input type="text" id="search" placeholder="Rechercher par nom" onkeyup="searchExercises()">
                    </div>

                    <?php
                    $sql = "SELECT * FROM exercise WHERE 1=1";
                    if(isset($_GET['niveau']) && $_GET['niveau'] != '') {
                        $niveaux = explode(',', $_GET['niveau']);
                        $niveauxPlaceholders = implode(',', array_fill(0, count($niveaux), '?'));
                        $sql .= " AND difficulty IN ($niveauxPlaceholders)";
                        $stmt = mysqli_prepare($connection, $sql);
                        mysqli_stmt_bind_param($stmt, str_repeat('i', count($niveaux)), ...$niveaux);
                        mysqli_stmt_execute($stmt);
                        $resultExercises = mysqli_stmt_get_result($stmt);
                    } else {
                        $resultExercises = mysqli_query($connection, $sql);
                    }

                    if(mysqli_num_rows($resultExercises) > 0) { 
                        if ($_SERVER["REQUEST_METHOD"] == "GET") {
                            echo "<h2 class='color_text'>" . mysqli_num_rows($resultExercises) . " exercices trouvés : </h2>";
                        }
                    ?>
                        
                    <table class="section_column">
                        <tr>
                            <th class="section_title_column_left font_weight_title">Nom</th>
                            <th class="font_weight_title">Difficulté</th>
                            <th class="font_weight_title">Mots clés</th>
                            <th class="font_weight_title table_padding">Durée</th>
                            <th class="section_title_column_right font_weight_title">Fichiers</th>
                            <th class="section_title_column_right font_weight_title">Modifier</th>
                        </tr>
                        <?php 
                        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                        $resultsPerPage = 3;
                        $offset = ($currentPage - 1) * $resultsPerPage;
                        $sql .= " LIMIT $offset, $resultsPerPage";
                        $resultExercises = mysqli_query($connection, $sql);

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
                            echo "<td>" . $row["duration"] . "</td>";
                            echo "<td class=''>";
                            if ($row["exercise_file_id"]) {
                                echo "<a href='download.php?id=" . $row["exercise_file_id"] . "' download class='style_filter_file-1 color_police_table'><img class='icon_download' src='assets/images/Group.png'/>Exercice</a> ";
                            }
                            if ($row["correction_file_id"]) {
                                echo "<a href='download.php?id=" . $row["correction_file_id"] . "' download class='style_filter_file-2 color_police_table'><img class='icon_correction' src='assets/images/Group.png'/>Corriger</a>";
                            }
                            echo "</td>";
                            echo "<td class=''>";
                            echo "<a href='modification.php?id=" . $row["id"] . "' class='style_filter_file-2 color_police_table'>Modifier</a>";
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
                    <?php
                    $sqlTotalExercises = "SELECT COUNT(*) AS total FROM exercise";
                    $resultTotalExercises = mysqli_query($connection, $sqlTotalExercises);
                    $rowTotalExercises = mysqli_fetch_assoc($resultTotalExercises);
                    $totalPages = ceil($rowTotalExercises['total'] / $resultsPerPage);

                    
                        echo "</div>";
                        echo "<div class='pagination'>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<a href='administration.php?page=$i'>$i</a>";
                    }
                    echo "</div>";

                    ?>
                </div>
            </div>
            <div class="tab-content">
                <div class="liste">
                    <h3>Liste des thématiques</h3>
                    <div class="search-bar">
                        <input type="text" id="search" placeholder="Rechercher par nom ou matière" onkeyup="searchThemes()">
                    </div>
                    <table class="section_column">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Matière</th>
                                <th>Nombre d'exercices</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sqlThemes = "SELECT thematic.*, COUNT(exercise.id) AS exercise_count FROM thematic LEFT JOIN exercise ON thematic.id = exercise.thematic_id GROUP BY thematic.id";
                            $resultThemes = mysqli_query($connection, $sqlThemes);
                            while ($row = mysqli_fetch_assoc($resultThemes)) {
                                echo "<tr>";
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td>" . $row["subject"] . "</td>";
                                echo "<td>" . $row["exercise_count"] . "</td>";
                                echo "<td>";
                                echo "<a href='modification.php?id=" . $row["id"] . "'>Modifier</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-content">
                <div class="origines">
                    <h3>Liste des compétences</h3>
                    <div class="search-bar">
                        <input type="text" id="search" placeholder="Rechercher par nom ou matière" onkeyup="searchThemes()">
                    </div>
                    <table class="section_column">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Matière</th>
                                <th>Nombre d'exercices</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sqlThemes = "SELECT thematic.*, COUNT(exercise.id) AS exercise_count FROM thematic LEFT JOIN exercise ON thematic.id = exercise.thematic_id GROUP BY thematic.id";
                            $resultThemes = mysqli_query($connection, $sqlThemes);
                            while ($row = mysqli_fetch_assoc($resultThemes)) {
                                echo "<tr>";
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td>" . $row["subject"] . "</td>";
                                echo "<td>" . $row["exercise_count"] . "</td>";
                                echo "<td>";
                                echo "<a href='modification.php?id=" . $row["id"] . "'>Modifier</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-content">
                <div class="origines">
                    <h3>Liste des origines</h3>
                    <div class="search-bar">
                        <input type="text" id="search" placeholder="Rechercher par nom" onkeyup="searchOrigins()">
                        </div>
                        <tbody>
                            <tbody>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Matière</th>
                                            <th>Nombre d'exercices</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sqlThemes = "SELECT thematic.*, COUNT(exercise.id) AS exercise_count FROM thematic LEFT JOIN exercise ON thematic.id = exercise.thematic_id GROUP BY thematic.id";
                                        $resultThemes = mysqli_query($connection, $sqlThemes);
                                        while ($row = mysqli_fetch_assoc($resultThemes)) {
                                            echo "<tr>";
                                            echo "<td>" . $row["name"] . "</td>";
                                            echo "<td>" . $row["subject"] . "</td>";
                                            echo "<td>" . $row["exercise_count"] . "</td>";
                                            echo "<td>";
                                            echo "<a href='modification.php?id=" . $row["id"] . "'>Modifier</a>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                        </tbody>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function showAddContributorForm() {
        // Sélectionnez la div contributeurs
        const contributorsDiv = document.querySelector('.contributeurs');

        // Changez le contenu de la div
        contributorsDiv.innerHTML =`
            <h3>Ajouter un contributeur</h3>
            <form method="POST" action="register.php" class="add-contributor">
                <div class="container_form">
                    <div class="section_form_1">
                        <label for="nom">Nom :</label>
                        <input class="text_form" type="text" id="nom" name="nom" placeholder="Saisissez le nom du contributeur" required>
                        <label for="prenom">Prénom :</label>
                        <input class="text_form" type="text" id="prenom" name="prenom" placeholder="Saisissez le prénom" required>
                        <label for="email">Email :</label>
                        <input class="text_form" type="email" id="email" name="email" placeholder="Saisissez l'email" required>
                        <label for="password">Mot de passe :</label>
                        <input class="text_form" type="password" id="password" name="password" placeholder="Saisissez le mot de passe" required>
                        <div class="container_input">
                            <input class="btn_add_exercise_1" type="button" value="< Retour à la liste" onclick="window.location.href='administration.php'"> 
                            <input class="btn_add_exercise_2" type="submit" value="Enregistrer">
                        </div>
                    </div>
                    <div class="section_form_2">
                        <label for="role">Rôle :</label>
                        <div class="custom_select">
                            <select class="text_form_1" id="role" name="role" required>
                                <option value="Enseignant">Enseignant</option>
                                <option value="Elève">Elève</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        `;
    }
</script>
            <script src="./assets/scripts/tabs.js"></script>
        </div>
    </div>
</div>
<script>
    function showAddContributorForm() {
        // Sélectionnez la div contributeurs
        const contributorsDiv = document.querySelector('.contributeurs');

        // Changez le contenu de la div
        contributorsDiv.innerHTML =`
            <h3>Ajouter un contributeur</h3>
            <form method="POST" action="register.php" class="add-contributor">
                <div class="container_form">
                    <div class="section_form_1">
                        <label for="nom">Nom :</label>
                        <input class="text_form" type="text" id="nom" name="nom" placeholder="Saisissez le nom du contributeur" required>
                        <label for="prenom">Prénom :</label>
                        <input class="text_form" type="text" id="prenom" name="prenom" placeholder="Saisissez le prénom" required>
                        <label for="email">Email :</label>
                        <input class="text_form" type="email" id="email" name="email" placeholder="Saisissez l'email" required>
                        <label for="password">Mot de passe :</label>
                        <input class="text_form" type="password" id="password" name="password" placeholder="Saisissez le mot de passe" required>
                        <div class="container_input">
                            <input class="btn_add_exercise_1" type="button" value="< Retour à la liste" onclick="window.location.href='administration.php'"> 
                            <input class="btn_add_exercise_2" type="submit" value="Enregistrer">
                        </div>
                    </div>
                    <div class="section_form_2">
                        <label for="role">Rôle :</label>
                        <div class="custom_select">
                            <select class="text_form_1" id="role" name="role" required>
                                <option value="Enseignant">Enseignant</option>
                                <option value="Elève">Elève</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        `;
    }
</script>
<script>
    var deleteLinks = document.querySelectorAll('a#delete-dialog');

    for (var i = 0; i < deleteLinks.length; i++) {
        deleteLinks[i].addEventListener('click', function(e) {
            e.preventDefault();
            var confirmDialog = document.getElementById('confirmDialog');
            confirmDialog.style.display = 'block';

            var confirmYes = document.getElementById('confirmYes');
            confirmYes.addEventListener('click', function() {
                window.location.href = e.target.href;
            });

            var confirmNo = document.getElementById('confirmNo');
            confirmNo.addEventListener('click', function() {
                confirmDialog.style.display = 'none';
            });
            var croix = document.getElementById('croix');
            croix.addEventListener('click', function() {
                confirmDialog.style.display = 'none';
            });
        });
    }

    for (var i = 0; i < deleteLinks.length; i++) {
        deleteLinks[i].addEventListener('click', function(e) {
            var croix = document.getElementById('croix');
            croix.addEventListener('click', function() {
                confirmDialog.style.display = 'none';
            });
        });
    }
</script>

<?php require_once('footer.php');?>
</body>
</html>
