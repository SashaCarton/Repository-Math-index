<?php 
    require("../components/slide-bar.php");
	// Permet d'appeler la fonction de connexion à la BD
    require('../database/connexion_db.php');
    require('../database/config.php');
		
	// Démarrage d'une session
    session_start();
    // Connexion à la BD
    $co = connexionBdd();

    if (isset($_POST['submit'])){
        $username = $_POST['email'];

    // Préparation de la requête
    $query = $co->prepare('SELECT * FROM utilisateurs WHERE email=:login');

    // Association des paramètres aux variables/valeurs
    $query->bindParam(':login', $username);

    // Execution de la requête
    $query->execute();    

    // Récupération dans la variable $result de toutes les lignes que retourne la requête
    $result = $query->fetchAll();

                if (empty($result)) {
                    // Si la requête ne retourne rien, alors l'utilisateur n'existe pas dans la BD, on lui
                    // affiche un message d'erreur
                    $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
                }
                else {
                    $password_hash = $result["password"];
                    $valid = password_verify($_POST["password"], $password_hash);
                    if ($valid) {
                        // On définit la variable de session username avec la valeur saisie par l'utilisateur
                        $_SESSION['email'] = $username;
                        // On lance la page index.php à la place de la page actuelle
                        header("Location: index.php");
                    }
                    else {
                        $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
                    }
                }
            }

            function addMessageIfValueIsEmpty(array $errors, string $field): array
            {
                if (empty($_POST[$field])) {
                    $errors[$field][] = sprintf('Le champ "%s" doit être renseigné.', $field);
                }
        
                return $errors;
            }
        
            function displayErrors(array $errors, string $field): void
            {
        
                if (isset($errors[$field])) {
                    foreach ($errors[$field] as $error) {
                        echo '<p class="error">' . $error . '</p>';
                    }
                }
            }
        
            // Si formulaire soumis et données transmises :
            // Méthode = POST
            // Données de POST non vide. empty($_POST) : si vide = true : sinon false)
            $errors = [];
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) === false) {
        
                // Ok des données sont transmises.
                $errors = addMessageIfValueIsEmpty($errors, 'email');
                $errors = addMessageIfValueIsEmpty($errors, 'password');
        
                // Vérification de l'email
                // Il faut pour cela que l'email soit saisi.
                if (!empty($_POST['email'])) {
                    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                        $errors['email'][] = 'Le champ "email" n\'est pas valide.';
                    }
                    
                }
        
            }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
    <link href="../assets/css/style-connexion.css" rel="stylesheet">
    <title>Connexion</title>
</head>
<body>
    <?php var_dump($result); ?>
    <div class="container">
        <div class="connect">
            <img src="../assets/images/Logo login.png" alt="logo connexion"> <!--Rectangle on the top with the "Connexion title"-->
            
            <h2><a href="connexion.php">Connexion</a></h2>
        </div>

        <div class="grey-bloc">
            <h1>
                Connexion
            </h1>

            <div class="description-form">
                <p>
                    Cet espace est réservé aux enseignats du lycée Saint-Vincent - Senlis.
                    Si vous n'avez pas encore de compte, veuillez effectuer votre demande
                    directement en envoyant un email à <a href="">contact@lyceestvincent.net</a>
                </p>

                <form action="" method="POST" name="login">
                    <div class="form-email">
                        <label for="email">Email : <br></label>
                        <input id="email" type="text" name="email" placeholder="Saisissez votre adresse email"> 
                        <?php displayErrors($errors, 'email'); ?>
                        <?php if (!empty($message)) { ?>
                            <p class="errorMessage"><?php echo $message; ?></p>
                        <?php } ?>
                    </div>

                    <div class="form-password">
                        <label for="password">Mot de passe : <br></label>
                        <input type="password" id="password" name="password" placeholder="Saisissez votre mot de passe">
                    </div>
                    <?php displayErrors($errors, 'password'); ?>
                    <?php if (!empty($message)) { ?>
                    <p class="errorMessage"><?php echo $message; ?></p>
                    <?php } ?>

                    <div class="form-option">
                        <input type="submit" value="Connexion" value="envoyer">


                        <a href="">
                            Mot de passe oublié ?
                        </a>
                        
                    </div>
                </form>
            </div>
            <?php 
                require("../components/footer.php")
            ?>
        </div>
    </div>
    
</body>
</html>