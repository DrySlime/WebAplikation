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
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body id="body">

<section class="imgheader">
    <h1>Account</h1>
    <img src="img/macaronbanner.png" alt="Andre Caputo">
</section>
<div class="account_wrapper" id="tmp123">
    <?php if (isset($_SESSION["useruid"])) { ?>
        <div class="account_dataWrapper">
            <div class="account_sidebar">
                <a id="dash" class="switchBtn" show-what="dashsection"><h1 class="navbarbutton" id="dashside"><span
                                class="material-symbols-outlined">dashboard</span>Dashboard
                    </h1></a>
                <a id="account" class="switchBtn" show-what="accountsection"><h1 class="navbarbutton"
                                                                                 id="accountside"><span
                                class="material-symbols-outlined">person</span>Account</h1></a>
                <a id="purchases" class="switchBtn" show-what="purchasessection"><h1 class="navbarbutton"
                                                                                     id="purchasesside"><span
                                class="material-symbols-outlined">local_mall</span>Bestellungen</h1></a>
                <a id="addresses" class="switchBtn" show-what="addressessection"><h1 class="navbarbutton"
                                                                                     id="addressesside"><span
                                class="material-symbols-outlined">location_on</span>Adressen</h1></a>
                <a id="payments" class="switchBtn" show-what="paymentssection"><h1 class="navbarbutton"
                                                                                   id="paymentsside"><span
                                class="material-symbols-outlined">payments</span>Bezahlmethoden</h1></a>
                <a id="help" class="switchBtn" show-what="helpsection"><h1 class="navbarbutton" id="helpside"><span
                                class="material-symbols-outlined">help</span>Help Desk</h1></a>
                <a href="includes/logout_include.php"><h1 id="logout"><span class="material-symbols-outlined">logout</span>Abmelden</h1></a>
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
                                <a href="#account">Bearbeiten</a>
                            </div>
                        </div>
                        <div class="grid_double grid">
                            <div class="double_header">
                                <h1>Adressen</h1>
                                <a id="addresses" class="switchBtn" show-what="purchasessection">Bearbeiten</a>
                            </div>
                            <div class="address_wrapper">

                            </div>
                        </div>
                        <div class="grid_double grid">
                            <div class="double_header">
                                <h1>Bestellungen</h1>
                                <a id="payments" class="switchBtn" show-what="paymentssection">Alle Bestellungen</a>
                            </div>
                            <div class="purchases_wrapper">
                                <div class="purchase_grid_item">
                                    <h4>13.11.2022</h4>
                                    <h4>24er Macaron Box</h4>
                                    <h4>1</h4>
                                    <h4>20.50€</h4>
                                </div>
                                <div class="purchase_grid_item">
                                    <h4>13.11.2022</h4>
                                    <h4>24er Macaron Box</h4>
                                    <h4>1</h4>
                                    <h4>20.50€</h4>
                                </div>
                                <div class="purchase_grid_item">
                                    <h4>13.11.2022</h4>
                                    <h4>24er Macaron Box</h4>
                                    <h4>1</h4>
                                    <h4>20.50€</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="allSections" id="accountsection">
                    <div class="selection_wrapper">
                    <h1>Account</h1>
                    <div class="selections_container">

                    </div>
            </div>
                </section>
                <section class="allSections" id="purchasessection">
                    <div class="selection_wrapper">
                        <h1>Bestellungen</h1>
                        <div class="selections_container">

                        </div>
                    </div>
                </section>
                <section class="allSections" id="addressessection">
                    <div class="selection_wrapper">
                        <h1>Adressen</h1>
                        <div class="selections_container">

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
                <section class="allSections" id="helpsection">
                    <div class="selection_wrapper">
                        <h1>Help Desk</h1>
                        <div class="selections_container">

                        </div>
                    </div>
                </section>
            </div>
        </div>
    <?php } ?>
</div>
<script src="JS/account.js"></script>
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
