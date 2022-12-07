<!DOCTYPE html>
<html lang="de">

<?php

include_once 'header.php';

if (!isset($_SESSION["useruid"])) {
    header('Location: login.php');
    die();
}
?>

<head>
    <link rel="stylesheet" href="CSS/account.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
    <title></title>
</head>

<body id="body">

<div class="account_header_wrapper">
    <div class="account_header_container">
        <h1>Hallo Mtuart,</h1>
        <h4>Willkommen zurück beim Confectioner!</h4>
    </div>
    <div class="account_header_image">
        <img src="img/cookies.png" alt="">
    </div>
    <div class="account_header_logout">
        <a id="logout" class="logout_button" href="includes/logout_include.php">Abmelden</a>
    </div>
</div>
<div class="account_wrapper">
    <div class="account_wrapper_info">
        <?php if (isset($_SESSION["useruid"])) { ?>
        <div class="account_grid_wrapper">
            <div class="grid_container split_divs">
                <div class="grid_header seperate_header">
                    <h1>Dein Confectioner Account</h1>
                    <h4>Bearbeite hier deinen Account, siehe deine letzten Bestellungen ein, oder <a id="delete"
                                                                                                     class="delete_account_button">Lösche</a>
                        deinen Account</h4>
                </div>
                <div class="account_dash_wrapper">
                    <form id="changeAccount" action="#" method="post">
                        <label for="username"></label><input type="text" name="username" id="username" value="Mtuart"
                                                             placeholder="Benutzername">
                        <div class="account_double_container">
                            <label for="name"></label><input type="text" name="" id="name" value="Stuart" placeholder="Vorname">
                            <label for="surname"></label><input type="text" name="surname" id="surname" value="Eichler" placeholder="Nachname">
                        </div>
                        <label for="email"></label><input type="text" name="email" id="email" value="stuart.eichler@stud.hshl.de"
                                                          placeholder="Email">
                        <div class="account_double_container">
                            <label for="newpassword"></label><input type="password" name="newpassword" id="newpassword" placeholder="Neues Passwort">
                            <label for="oldpassword"></label><input required type="password" name="oldpassword" id="oldpassword"
                                                                    placeholder="Altes Passwort">
                        </div>
                        <div class="account_error_container">
                            <h4>Print submit response here!</h4>
                        </div>
                    </form>
                </div>
                <div class="account_subsection_button">
                    <button form="changeAccount" type="submit" name="register_button">Speichern</button>
                </div>
            </div>
            <div class="grid_container flex_display">
                <div class="grid_header underline_grid">
                    <h1>Standard Adresse</h1>
                </div>
                <div class="standard_address_wrapper">
                    <div class="address_data">
                        <h2>Stuart Eichler</h2>
                        <h4>Paracelsuspark 1</h4>
                        <h4>Hamm, 59063</h4>
                        <h4>Deutschland</h4>
                    </div>
                </div>
                <div class="account_subsection_button">
                    <a id="address" class="switchBtn" show-page="addresssection">Deine Adressen</a>
                </div>
            </div>
            <div class="grid_container">
                <div class="grid_header underline_grid orders_header">
                    <h1>Letzte Bestellung</h1>
                    <div class="account_section_button">
                        <a id="orders" class="switchBtn" show-page="orderssection">Deine Bestellungen</a>
                    </div>
                </div>
                <div class="purchases_wrapper">
                    <div class="grid_item">
                        <a href="#"><img src="img/macaronProduct.png" alt=""></a>
                    </div>
                    <div class="grid_item grid_description">
                        <h3>Macaron Box</h3>
                        <div class="grid_inline">
                            <h4 id="title">Menge:</h4>
                            <h4>2</h4>
                        </div>
                        <div class="grid_inline">
                            <h4 id="title">Summe:</h4>
                            <h4>420.69€</h4>
                        </div>
                        <div class="grid_inline">
                            <h4 id="title">Datum:</h4>
                            <h4>5. Dezember, 2022</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid_container flex_display">
                <div class="grid_header underline_grid">
                    <h1>Bezahlmethode</h1>
                </div>
                <div class="standard_payment_wrapper">
                    <div class="payment_card">
                        <div class="card_top card_info">
                            <i class="material-symbols-outlined"
                               style="pointer-events: none; font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48;">credit_card</i>
                            <h4>Comdirect</h4>
                        </div>
                        <div class="card_middle card_info">
                            <h4>5525 5614 6731 2095</h4>
                        </div>
                        <div class="card_bottom card_info">
                            <h4>Stuart Eichler</h4>
                            <div class="card_date">
                                <h5>Gültig bis:</h5>
                                <h4>02/25</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="account_subsection_button">
                    <a id="payments" class="switchBtn" show-page="paymentmethodssection">Verwalten</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="account_modal" id="delete-modal">
    <div class="modal_container">
        <div class="modal_text">
            <div class="modal_header">
                <span class="material-symbols-outlined">warning</span>
                <h3>Account Löschen</h3>
            </div>
            <p>Falls du deinen Account für immer löschen möchtest, gib unten deine Daten ein letztes Mal ein und
                bestätige das löschen. Denk dran, dass das hier nicht rückgängig gemacht werden kann!</p>
            <p id="sad_life">Wir werden dich beim Confectioner vermissen!</p>
        </div>
        <div class="modal_input">
            <form id="deleteAccount" action="#" method="post">
                <label for="delemail"></label><input required type="text" name="delemail" id="delemail" placeholder="Email">
                <label for="delpassword"></label><input required type="password" name="delpassword" id="delpassword" placeholder="Passwort">
            </form>
        </div>
        <div class="modal_buttons">
            <button id="close_modal">Ich will bleiben!</button>
            <button type="submit" form="deleteAccount" id="delete_Account">Account Löschen</button>
        </div>
    </div>
</div>
<script src="JS/account.js"></script>
<?php } ?>
</body>

</html>

<?php
include_once 'footer.php';
?>

<script>
    $(".switchBtn").click(function () {
        var showWhat = $(this).attr('show-what');
        $(".allSections").fadeOut(0);
        $("#" + showWhat).fadeIn(0);
        var sideElements = document.getElementsByClassName("navbarbutton");
        for (x in sideElements) {
            if (sideElements[x].id.startsWith(this.id)) {
                sideElements[x].style.color = "#fc466b";
            } else {
                sideElements[x].style.color = "#101010";
            }
        }
    });

    $(document).ready(function () {
        $(".allSections").fadeOut(0);
        $("#dashsection").fadeIn(0);
        var sideElement = document.getElementById("dashside");
        sideElement.style.color = "#fc466b";
    });
</script>
