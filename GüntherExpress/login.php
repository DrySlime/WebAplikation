<!DOCTYPE html>
<html lang="de">

<?php
include_once 'header.php';
?>

<head>
    <link rel="stylesheet" href="CSS/login.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
    <title></title>
</head>

<body>
<section class="imgheader"></section>
<div class="page_wrapper">
    <div class="left_container">
        <h1>Find your sweet side!</h1>
        <h4>Melde Dich an, oder registriere Dich auf The Confectioner, um Deine Daten beim Kauf immer parat zu
            haben!</h4>
        <img src="img/gummibears.jpg" alt="">
    </div>
    <div class="right_container">
        <div class="loginregister_wrapper">
            <?php
            if(isset($_GET["error"])){
                if($_GET["error"]=="wronginput"){
                    $errorMSG = "Anmeldedaten stimmen nicht überein!";
                }
                else if($_GET["error"]=="none"){
                    $errorMSG = "Sie haben sich erfolgreich registriert!";
                }
                echo "<h3 style='color: #ff0736; left: -60px; position: relative'>".$errorMSG."</h3> <br>";

            }
            ?>
            <h1>Anmelden</h1>
            <form action="includes/login_include.php" method="post">
                <div class="form_container">
                    <label for="username"></label><input class="no-autofill-bkg" type="text" name="username" id="username" placeholder="E-Mail/Benutzername" required>
                    <label for="password"></label><input class="no-autofill-bkg" type="password" name="password" id="password" placeholder="Passwort" required>

                    <button type="submit" name="login_button" onclick="return check_form()">Anmelden</button>
                    <div class="button_container">
                        <h4>Noch kein Account?</h4>
                        <a href="signup.php"><h4>Registrieren</h4></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>

</html>

<?php
include_once 'footer.php';
?>