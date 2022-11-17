<!DOCTYPE html>
<html lang="de">

<?php
include_once 'header.php';
?>

<head>
    <link rel="stylesheet" href="CSS/login.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
</head>

<body>
    <section class="imgheader"></section>
    <div class="page_wrapper">
        <div class="left_container">
            <h1>Find your sweet side!</h1>
            <h4>Melde Dich an, oder registriere Dich auf The Confectioner, um deine Daten beim Kauf immer parat zu
                haben!</h4>
            <img src="img/gummibears.jpg" alt="">
        </div>
        <div class="right_container">
            <div class="loginregister_wrapper">
                <h1>Registrieren</h1>
                <form action="includes/signup_include.php" method="post">
                    <div class="form_container">
                        <input type="text" name="username" id="username" placeholder="Benutzername" required>
                        <input type="text" name="name" id="name" placeholder="Vorname" required>
                        <input type="text" name="surname" id="surname" placeholder="Nachname" required>
                        <input type="text" name="email" id="email" placeholder="Email" required>
                        <input type="password" name="password" id="password" placeholder="Passwort" required>
                        <input type="password" name="passwordrepeat" id="passwordrepeat" placeholder="Passwort Wiederholen"required>
                        <button type="submit" name="register_button" >Registieren</button>
                        <div class="button_container">
                            <h4>Du hast schon ein Account?</h4>
                            <a href="login.php"><h4>Anmelden</h4></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php

    if(isset($_GET["error"])){
        if($_GET["error"]=="emptyinput"){
            $errorMSG = "Manche Felder sind leer!";
            echo "<p>$errorMSG</p>";
        }else  if($_GET["error"]=="invaliduid"){
            $errorMSG = "Username beinhaltete nicht unterstützte Zeichen!";
            echo "<p>$errorMSG</p>";
        }else  if($_GET["error"]=="invalidemail"){
            $errorMSG = "Email wird bereits verwendet";
            echo "<p>$errorMSG</p>";
        }else  if($_GET["error"]=="passwordsdontmatch"){
            $errorMSG = "Passwörter stimmen nicht überein!";
            echo "<p>$errorMSG</p>";
        }else  if($_GET["error"]=="uidexists"){
            $errorMSG = "Username wird bereits verwendet!";
            echo "<p>$errorMSG</p>";
        }
    }
    ?>
</body>

</html>

<?php
include_once 'footer.php';
?>