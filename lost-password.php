<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    require_once 'config.php';
    require_once 'header.php';
?>
    <div class="container">
        <div class="grey-bloc">   
            <h1>Mot de passe oublié</h1>
            <div class="from-bloc">
                <p>Entrez votre adresse e-mail pour réinitialiser votre mot de passe.</p>
                <form action="lost-password.php" method="post">
                    <div>
                        <label for="email">Adresse e-mail</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div>
                        <button type="submit">Envoyer</button>
                    </div>
                </form>
            </div>
            <?php
                require_once 'footer.php';
            ?>
        </div>
    </div>


</body>
</html>