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
                <img id="croix" src="assets/images/croix.png" href="administration.php" alt="Supprimer">
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

                        if (isset($_GET['success']) && $_GET['success'] == 1) {
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
                <h2>Sources</h2>
            </div>

            <div class="tab-content">
                <h2>Fichiers</h2>
            </div>

            <!-- Script pour l'affichage des onglets selon celui qui est sélectionné -->
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
        });
    }
</script>

<?php require_once('footer.php');?>
</body>
</html>
