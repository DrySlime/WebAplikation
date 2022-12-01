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
    <link rel="stylesheet" href="CSS/accountSection.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body id="body">

<div class="account_header_wrapper">
    <div class="account_page_header">
        <h1>Account</h1>
        <img src="img/">
    </div>
    <div class="searchbar_wrapper">
        <form action="#">
            <div class="searchbar_container">
                <input type="text" name="search" id="search" placeholder="Suchen" required>
                <button type="submit">Suchen</button>
            </div>
        </form>
    </div>
</div>
<div class="account_wrapper" id="tmp123">
    <?php if (isset($_SESSION["useruid"])) { ?>
        <div class="account_dataWrapper">
            <div class="account_sidebar">
                <a id="dash" class="switchBtn" show-what="dashsection"><h1 class="navbarbutton" id="dashside"><span
                                class="material-symbols-outlined">dashboard</span>Dashboard</h1></a>
                <a id="account" class="switchBtn" show-what="accountsection"><h1 class="navbarbutton" id="accountside">
                        <span class="material-symbols-outlined">person</span>Account</h1></a>
                <a id="purchases" class="switchBtn" show-what="purchasessection"><h1 class="navbarbutton"
                                                                                     id="purchasesside"><span
                                class="material-symbols-outlined">local_mall</span>Bestellungen</h1></a>
                <a id="addresses" class="switchBtn" show-what="addressessection"><h1 class="navbarbutton"
                                                                                     id="addressesside"><span
                                class="material-symbols-outlined">location_on</span>Adressen</h1></a>
                <a id="payments" class="switchBtn" show-what="paymentssection"><h1 class="navbarbutton"
                                                                                   id="paymentsside"><span
                                class="material-symbols-outlined">payments</span>Bezahlmethoden</h1></a>
                <a href="includes/logout_include.php"><h1 id="logout"><span
                                class="material-symbols-outlined">logout</span>Abmelden</h1></a>
            </div>
            <div class="account_data">
                <section class="allSections" id="dashsection">
                    <div class="dash_grid_wrapper">
                        <div class="grid_single grid">
                            <h1>Hallo Mtuart!</h1>
                            <div class="griditem_container">
                                <h3>Dein Account:</h3>
                                <h4>Stuart Eichler</h4>
                                <h4>Mtuart</h4>
                                <h4>stuart.eichler@stud.hshl.de</h4>
                                <a id="account" class="switchBtn" show-what="accountsection">Bearbeiten</a>
                            </div>
                        </div>
                        <div class="grid_double grid">
                            <div class="double_header">
                                <h1>Standard Adresse</h1>
                                <a id="addresses" class="switchBtn" show-what="addressessection">Alle Adressen</a>
                            </div>
                            <div class="standard_address_wrapper">
                                <h3>Stuart Eichler</h3>
                                <h4>Paracelsuspark 1</h4>
                                <h4>Hamm, 59063</h4>
                                <h4>Deutschland</h4>
                            </div>
                        </div>
                        <div class="grid_double grid">
                            <div class="double_header">
                                <h1>Letzte Bestellung</h1>
                                <a id="payments" class="switchBtn" show-what="purchasessection">Alle Bestellungen</a>
                            </div>
                            <div class="purchases_wrapper">
                                <div class="purchase_image">
                                    <a href="#"><img src="img/macaronProduct.png"></a>
                                </div>
                                <div class="purchase_info">
                                    <h3>Macaron Box</h3>
                                    <h4>Menge: Ka muss schauen</h4>
                                    <h4>Preis: wie ich hier Place-</h4>
                                    <h4>Datum: holder einbaue</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="allSections" id="accountsection">
                    <div class="selection_wrapper">
                        <h1>Account Bearbeiten</h1>
                        <div class="selections_container">
                            <form action="#" method="post">
                                <div class="form_container">
                                    <div class="form_data_wrapper">
                                        <div class="account_grid_wrapper">
                                            <div class="account_data_container">
                                                <div class="section_header">
                                                    <h3>Benutzername</h3>
                                                </div>
                                                <div class="section_inputs">
                                                    <input type="text" name="username" id="username" value="%Username%"
                                                           placeholder="Benutzername">
                                                </div>
                                            </div>
                                            <div class="account_data_container">
                                                <div class="section_header">
                                                    <h3>Name</h3>
                                                </div>
                                                <div class="section_inputs">
                                                    <input type="text" name="name" id="name" value="%Vorname%"
                                                           placeholder="Vorname">
                                                    <input type="text" name="surname" id="surname" value="%Nachname%"
                                                           placeholder="Nachname">
                                                </div>
                                            </div>
                                            <div class="account_data_container">
                                                <div class="section_header">
                                                    <h3>Email</h3>
                                                </div>
                                                <div class="section_inputs">
                                                    <input type="text" name="oldemail" id="oldemail"
                                                           placeholder="Alte Email">
                                                    <input type="text" name="email" id="email" placeholder="Neue Email">
                                                </div>
                                            </div>
                                            <div class="account_data_container">
                                                <div class="section_header">
                                                    <h3>Passwort</h3>
                                                </div>
                                                <div class="section_inputs">
                                                    <input type="password" name="oldpassword" id="oldpassword"
                                                           placeholder="Altes Passwort" required>
                                                    <input type="password" name="password" id="password"
                                                           placeholder="Neues Passwort">
                                                    <input type="password" name="passwordrepeat" id="passwordrepeat"
                                                           placeholder="Passwort Wiederholen">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="register_button">Speichern</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                <section class="allSections" id="purchasessection">
                    <div class="selection_wrapper">
                        <h1>Deine Bestellungen</h1>
                        <div class="selections_container">

                        </div>
                    </div>
                </section>
                <section class="allSections" id="addressessection">
                    <div class="selection_wrapper">
                        <h1>Deine Adressen</h1>
                        <div class="selections_container">
                            <div class="address_grid_wrapper">
                                <div class="grid_triple grid">
                                    <div class="addressitem_container">
                                        <h2>Stuart Eichler</h2>
                                        <h4>Paracelsuspark 1</h4>
                                        <h4>Hamm, 59063</h4>
                                        <h4>Deutschland</h4>
                                        <a class="defaultText">Standard Adresse</a>
                                        <div class="address_setting_container">
                                            <span class="material-symbols-outlined"
                                                  title="Adresse Löschen">delete</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid_triple grid">
                                    <div class="addressitem_container">
                                        <h2>Stuart Eichler</h2>
                                        <h4>Paracelsuspark 1</h4>
                                        <h4>Hamm, 59063</h4>
                                        <h4>Deutschland</h4>
                                        <div class="address_setting_container">
                                            <span class="material-symbols-outlined" title="Als Standard Setzen">edit_location</span>
                                            <span class="material-symbols-outlined"
                                                  title="Adresse Löschen">delete</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid_triple grid">
                                    <div class="addressitem_container">
                                        <h2>Stuart Eichler</h2>
                                        <h4>Paracelsuspark 1</h4>
                                        <h4>Hamm, 59063</h4>
                                        <h4>Deutschland</h4>
                                        <div class="address_setting_container">
                                            <span class="material-symbols-outlined" title="Als Standard Setzen">edit_location</span>
                                            <span class="material-symbols-outlined"
                                                  title="Adresse Löschen">delete</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid_triple grid">
                                    <div class="addressitem_container">
                                        <h2>Stuart Eichler</h2>
                                        <h4>Paracelsuspark 1</h4>
                                        <h4>Hamm, 59063</h4>
                                        <h4>Deutschland</h4>
                                        <div class="address_setting_container">
                                            <span class="material-symbols-outlined" title="Als Standard Setzen">edit_location</span>
                                            <span class="material-symbols-outlined"
                                                  title="Adresse Löschen">delete</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid_triple grid">
                                    <div class="addressitem_container">
                                        <h2>Stuart Eichler</h2>
                                        <h4>Paracelsuspark 1</h4>
                                        <h4>Hamm, 59063</h4>
                                        <h4>Deutschland</h4>
                                        <div class="address_setting_container">
                                            <span class="material-symbols-outlined" title="Als Standard Setzen">edit_location</span>
                                            <span class="material-symbols-outlined"
                                                  title="Adresse Löschen">delete</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid_triple grid">
                                    <div class="addressitem_container">
                                        <h2>Hinzufügen</h2>
                                        <h4>SoonTM</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="allSections" id="paymentssection">
                    <div class="selection_wrapper">
                        <h1>Bezahlmethoden</h1>
                        <div class="selections_container">

                        </div>
                    </div>
                </section>
            </div>
        </div>
    <?php } ?>
</div>
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
