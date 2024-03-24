<?php 
    require("../components/slide-bar.php")
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

                <form action="" method="POST">
                    <div class="form-email">
                        <label for="mail">Email : <br></label>
                        <input id="mail" type="email" name="email" placeholder="Saisissez votre adresse email"> 
                    </div>

                    <div class="form-password">
                        <label for="password">Mot de passe : <br></label>
                        <input type="password" id="password" name="password" placeholder="Saisissez votre mot de passe">
                    </div>

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