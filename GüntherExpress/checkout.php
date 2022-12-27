<!DOCTYPE html>
<html lang="de">

<?php
include_once 'header.php';
global $conn;

if (!isset($_SESSION["useruid"])) {
    header('Location: login.php');
    die();
}


require_once 'includes/dbh_include.php';
require_once 'includes/account_include.php';
require_once 'includes/functions_include.php';
$resultAccount = getAccountData($conn);
$resultDefAddress = getDefUserAddressData($conn);
$resultAddressWODef = getUserAddressDataWODef($conn);
$shippingCost = 3;
?>

<head>
    <link rel="stylesheet" href="CSS/cart.css">
    <link rel="stylesheet" href="CSS/checkout_new.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title></title>
</head>

<body>
<div class="cart_header_wrapper">
    <div class="cart_header_container">
        <h1>Deine Bestellung</h1>
        <h4>Wohin dürfen wir sie versenden?</h4>
    </div>
    <div class="cart_header_image">
        <img src="img/cookies.png" alt="">
    </div>
</div>
<div class="cart_wrapper">
    <div class="cart_grid_wrapper">
        <div class="cart_grid_container">
            <div class="checkout_wrapper">
                <ul class="checkout_data_header">
                    <li id="0" onclick="goToTab(this.id)" class="active">Lieferadresse</li>
                    <li id="1" onclick="goToTab(this.id)">Versand</li>
                    <li id="2" onclick="goToTab(this.id)">Bezahlmöglichkeit</li>
                    <li id="3" onclick="goToTab(this.id)">Übersicht</li>
                </ul>
                <div class="checkout_data_container">
                    <section class="checkout_section checkout_address active">
                        <div class="checkout_data_grid_wrapper">
                            <?php
                            if ($resultAddressWODef->num_rows < 5) {
                                ?>
                                <div class="checkout_grid_container addAddressContainer">
                                    <div class="grid_container add_address">
                                        <h2>Neue Adresse</h2>
                                        <form id="addAddress" action="#" method="post">
                                            <div class="add_address_oneline">
                                                <input type="text" name="addStreet" id="addStreet" placeholder="Straße">
                                                <input type="text" name="addHausnummer" id="addHausnummer"
                                                       placeholder="No.">
                                            </div>
                                            <input type="text" name="addStadt" id="addStadt" placeholder="Stadt">
                                            <input type="text" name="postal-code" id="postal-code" placeholder="PLZ">
                                        </form>
                                        <div class="addressitem_addbutton">
                                            <button id="add_Address" form="addAddress" type="submit"
                                                    name="add_address_button">
                                                Hinzufügen
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } ?>
                            <?php
                            if ($resultDefAddress !== null) {
                                ?>
                                <div class="checkout_grid_container">
                                    <input type="radio" id="---ID GOES HERE---" name="address_buttons"
                                           value="---ID GOES HERE---" checked="checked">
                                    <div class="grid_container">
                                        <h2><?php echo ucfirst($resultAccount['firstname']); ?> <?php echo ucfirst($resultAccount['lastname']); ?></h2>
                                        <h4><?php echo ucfirst($resultDefAddress['address_line1']); ?> <?php echo $resultDefAddress['street_number']; ?></h4>
                                        <h4><?php echo ucfirst($resultDefAddress['city']); ?>, <?php echo $resultDefAddress['postal_code']; ?></h4>
                                        <a class="defaultText">Standard Adresse</a>
                                    </div>
                                </div>
                                <?php
                            }

                            if ($resultAddressWODef !== null) {
                                while ($rows = $resultAddressWODef->fetch_assoc()) {
                                    ?>
                                    <div class="checkout_grid_container">
                                        <input type="radio" id="---ID GOES HERE---" name="address_buttons"
                                               value="---ID GOES HERE---">
                                        <div class="grid_container">
                                            <h2><?php echo ucfirst($resultAccount['firstname']); ?> <?php echo ucfirst($resultAccount['lastname']); ?></h2>
                                            <h4><?php echo ucfirst($rows['address_line1']); ?> <?php echo $rows['street_number']; ?></h4>
                                            <h4><?php echo ucfirst($rows['city']); ?>, <?php echo $rows['postal_code']; ?></h4>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } ?>
                        </div>
                    </section>
                    <section class="checkout_section checkout_delivery">
                        <div class="checkout_data_grid_wrapper">
                            <div class="checkout_grid_container">
                                <input type="radio" id="---ID GOES HERE---" name="delivery_buttons"
                                       value="---ID GOES HERE---">
                                <div class="addressitem_container">
                                    <h2>DHL Lieferung</h2>
                                    <h4>Lieferdauer: 3-5 Tage</h4>
                                    <h4>Lieferkosten: 2.50 €</h4>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="checkout_section checkout_payment">
                        <div class="checkout_data_grid_wrapper">

                        </div>
                    </section>
                    <section class="checkout_section checkout_overview">
                        <div class="checkout_data_grid_wrapper">

                        </div>
                    </section>
                </div>
                <div class="checkout_data_buttons">
                    <button class="previous disable" id="prevPage" onclick="goBack()">Zurück</button>
                    <button class="next" id="nextPage" onclick="goNext()">Weiter</button>
                </div>
            </div>
        </div>
        <div class="cart_grid_container limited_height">
            <div class="cart_grid_container_header">
                <h4>Zahlungsübersicht</h4>
            </div>
            <div class="cart_products_checkout_wrapper">
                <div class="cart_checkout_info dashBorder">
                    <h3>Anzahl Artikel</h3>
                    <h3><?php echo $_SESSION['wholeQty']?></h3>
                </div>
                <div class="cart_checkout_info">
                    <h3>Kosten Artikel</h3>
                    <h3><?php echo $_SESSION['fullPrice']?> €</h3>
                </div>
                <div class="cart_checkout_info">
                    <h3>Lieferkosten</h3>
                    <?php if ($shippingCost > 0) { ?>
                        <h3><?php echo $shippingCost ?>€</h3>
                    <?php
                    }else { 
                    ?>
                    <h3 id="lieferkosten">Wird im nächsten Schritt Berechnet</h3>
                    <?php 
                    }
                    ?>
                    
                </div>
                <div class="cart_checkout_info">
                    <h3>Gesamt Kosten</h3>
                    <h3><?php echo ($_SESSION['fullPrice']+$shippingCost)?> €</h3>
                </div>
                <div class="cart_checkout_buttons">
                    <button type="submit" disabled name="checkout_button">Kostenpflichtig Bestellen</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="JS/checkout.js"></script>
</body>

</html>

<?php
include_once 'footer.php';
?>
