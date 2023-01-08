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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
    <title>The Confectioner</title>
    <script src="JS/signup.js"></script>
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

    <?php
    if (isset($_GET["post"])) {
        echo '<div class="right_container">
                    <div class="loginregister_wrapper">
                        <h1>Registrieren</h1>
                        <form action="includes/signup_include.php" method="post">
                            <div class="form_container">
                                <label for="username"></label><input type="text" name="username" id="username"
                                                                     placeholder="Benutzername" value="' . $_GET["uid"] . '" required>
                                <label for="name"></label><input type="text" name="name" id="name" placeholder="Vorname" value="' . $_GET["pre"] . '" required>
                                <label for="surname"></label><input type="text" name="surname" id="surname" placeholder="Nachname" value="' . $_GET["sur"] . '"
                                                                    required>
                                <label for="email"></label><input type="text" name="email" id="email" placeholder="Email" value="' . $_GET["mail"] . '" required>
                                <label for="password"></label><input type="password" name="password" id="password"
                                                                     placeholder="Passwort" required>
                                <label for="passwordrepeat"></label><input type="password" name="passwordrepeat" id="passwordrepeat"
                                                                           placeholder="Passwort Wiederholen" required>
                                <div id="errorText" class="register_error_text" style="visibility: hidden">
                                    <h3 id="errorTextContent">Passwörter stimmen nicht überein!</h3>
                                </div>
                                <button type="submit" name="register_button">Registieren</button>
                                <div class="button_container">
                                    <h4>Du hast schon ein Account?</h4>
                                    <a href="login.php"><h4>Anmelden</h4></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>';
    } else {
        echo '<div class="right_container">
                        <div class="loginregister_wrapper">
                            <h1>Registrieren</h1>
                            <form action="includes/signup_include.php" method="post">
                                <div class="form_container">
                                    <label for="username"></label><input type="text" name="username" id="username"
                                                                         placeholder="Benutzername" required>
                                    <label for="name"></label><input type="text" name="name" id="name" placeholder="Vorname" required>
                                    <label for="surname"></label><input type="text" name="surname" id="surname" placeholder="Nachname"
                                                                        required>
                                    <label for="email"></label><input type="text" name="email" id="email" placeholder="Email" required>
                                    <label for="password"></label><input type="password" name="password" id="password"
                                                                         placeholder="Passwort" required>
                                    <label for="passwordrepeat"></label><input type="password" name="passwordrepeat" id="passwordrepeat"
                                                                               placeholder="Passwort Wiederholen" required>
                                    <div id="errorText" class="register_error_text" style="visibility: hidden">
                                        <h3 id="errorTextContent">Passwörter stimmen nicht überein!</h3>
                                    </div>
                                    <button type="submit" name="register_button">Registieren</button>
                                    <div class="button_container">
                                        <h4>Du hast schon ein Account?</h4>
                                        <a href="login.php"><h4>Anmelden</h4></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>';
    }
    ?>

</div>
<?php
if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
        echo '<script type="text/javascript">',
        'showErrorMsgEmpty();',
        '</script>';
    } else if ($_GET["error"] == "invaliduid") {
        echo '<script type="text/javascript">',
        'showErrorMsgInvalid();',
        '</script>';
    } else if ($_GET["error"] == "invalidemail") {
        echo '<script type="text/javascript">',
        'showErrorMsgEmail();',
        '</script>';
    } else if ($_GET["error"] == "passwordsdontmatch") {
        echo '<script type="text/javascript">',
        'showErrorMsgPasswords();',
        '</script>';
    } else if ($_GET["error"] == "uidexists") {
        echo '<script type="text/javascript">',
        'showErrorMsgUsername();',
        '</script>';
    }
}
?>
</body>
</html>

<?php
include_once 'footer.php';
?>