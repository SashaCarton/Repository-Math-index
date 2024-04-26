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
<?php
require_once('slide-bar.php');
require_once('connexion_db.php');
?>
<link rel="stylesheet" href="assets/css/administration.css">
<body>
<div class="container">
    <?php require_once('connect-bar.php'); ?>
    <div class="grey-bloc">
        <h1>Administration</h1>

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
                        <form>
                            <input type="text" id="search" name="search">
                            <input type="submit" id="buttonSearch" value="Rechercher">
                            <input type="button" id="buttonAdd" value="Ajouter +" onclick="showAddContributorForm()">
                        </form>
                    </div>
                    <table>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Actions</th>
                        </tr>
                        <?php
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $limit = 5;
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
                                echo "<td>" . $row["last_name"] . "</td>";
                                echo "<td>" . $row["first_name"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["role"] . "</td>";
                                echo "<td><a href='edit_contributor.php?id=" . $row["id"] . "'>Modifier</a> | <a href='supprimerContributeur.php?id=" . $row["id"] . "'>Supprimer</a></td>";
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
                            echo "<script>alert('Contributeur ajouté avec succès');</script>";
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
                            echo "</div>";
                            if (isset($_GET['success']) && $_GET['success'] == 1) {
                                echo "<script>alert('Contributeur ajouté avec succès');</script>";
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
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" placeholder="Saisissez le nom du contributeur" required>

                    <label for="role">Rôle :</label>
                    <select id="role" name="role" required>
                        <option value="Enseignant">Enseignant</option>
                        <option value="Elève">Elève</option>
                    </select>

                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" placeholder="Saisissez le prénom" required>

                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" placeholder="Saisissez l'email" required>

                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" placeholder="Saisissez le mot de passe" required>

                <input type="submit" value="Enregistrer">
                <input type="button" value="Retour à la liste" onclick="window.location.href='administration.php'">
            </form>
        `;
    }
</script>
<?php require_once('footer.php');?>
</body>
</html>