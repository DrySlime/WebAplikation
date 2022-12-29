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
require_once 'includes/functions_include.php';
require_once 'includes/account_include.php';
include_once 'includes/cart_include.php';
//require_once 'includes/check_out_include_new.php';
$resultAccount = getAccountData($conn);
$resultDefAddress = getDefUserAddressData($conn);
$resultAddressWODef = getUserAddressDataWODef($conn);
$resultShippingMeth = getShippingMethodData($conn);
$shoppingCart = getShoppingCartItems($conn, $_SESSION["userid"]);
$address = null;
$shippingMethod = null;
$paymentMethod = null;
$endCosts = $_SESSION['fullPrice'];
?>

<head>
    <link rel="stylesheet" href="CSS/cart.css">
    <link rel="stylesheet" href="CSS/checkout_new.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title></title>
</head>

<body>
<div class="cart_header_wrapper">
    <div class="cart_header_container">
        <h1>Deine Bestellung </h1>
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
                    <li id="2" onclick="goToTab(this.id)">Zahlungsart</li>
                    <li id="3" onclick="goToTab(this.id)">Übersicht</li>
                </ul>
                <div class="checkout_data_container">
                    <section class="checkout_section checkout_address active">
                        <div class="checkout_section_header">
                            <h3>Lieferadresse</h3>
                            <h4>Wähle hier deine Lieferadresse aus, oder füge noch schnell eine hinzu.</h4>
                        </div>
                        <div class="checkout_data_grid_wrapper">
                            <?php
                            if ($resultAddressWODef->num_rows < 6) {
                                ?>
                                <div class="checkout_grid_container addAddressContainer">
                                    <div class="grid_container add_address">
                                        <h2>Neue Adresse</h2>
                                        <form id="addAddress" action="#" method="post">
                                            <div class="add_address_oneline">
                                                <input type="text" name="addStreet" id="addStreet" placeholder="Straße">
                                                <input type="text" name="addHausnummer" id="addHausnummer" placeholder="No.">
                                            </div>
                                            <input type="text" name="addStadt" id="addStadt" placeholder="Stadt">
                                            <input type="text" name="postal-code" id="postal-code" placeholder="PLZ">
                                        </form>
                                        <div class="addressitem_addbutton">
                                            <button id="add_Address" form="addAddress" type="submit" name="add_address_button">
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
                                <div class="checkout_grid_container address_container">
                                    <input class="radioButton" type="radio" id="<?php echo $resultDefAddress['id'] ?>" name="address_buttons" value="<?php echo $resultDefAddress['id'] ?>" checked="checked">
                                    <div id="address_<?php echo $resultDefAddress['id']?>" class="grid_container">
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
                                    <div class="checkout_grid_container address_container">
                                        <input class="radioButton" type="radio" id="<?php echo $rows['id'] ?>" name="address_buttons" value="<?php echo $rows['id'] ?>">
                                        <div id="address_<?php echo $rows['id']?>" class="grid_container">
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
                        <div class="checkout_section_header">
                            <h3>Versandmethode</h3>
                            <h4>Wähle hier einen Versand aus.</h4>
                        </div>
                        <div class="checkout_data_grid_wrapper">
                            <?php
                            while ($schippingRos = $resultShippingMeth->fetch_assoc()) {
                                ?>
                                <div class="checkout_grid_container delivery_container">
                                    <input class="radioButton" type="radio" id="<?php echo $schippingRos['id'] ?>" name="delivery_buttons" value="<?php echo $schippingRos['shipping_price'] ?>">
                                    <div id="ship_<?php echo $schippingRos['id']?>" class="grid_container">
                                        <h2><?php echo $schippingRos['shipping_name'] ?></h2>
                                        <h4>Lieferdauer: 3-5 Tage</h4>
                                        <h4>Lieferkosten: <?php echo $schippingRos['shipping_price'] ?>.00 €</h4>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </section>
                    <section class="checkout_section checkout_payment">
                        <div class="checkout_section_header">
                            <h3>Zahlungsart</h3>
                            <h4>Wähle hier deine bevorzugte Zahlungsart aus.</h4>
                        </div>
                        <div class="checkout_data_grid_wrapper">
                            <!-- GROUP STARTS HERE -->
                            <div class="checkout_grid_container payment_container">
                                <input class="radioButton" type="radio" id="ID GOES HERE" name="payment_buttons" value="ID GOES HERE">
                                <div id="payment_ID GOES HERE" class="grid_container">
                                    <h2>Max Mustermann</h2>
                                    <h4>Comdirect</h4>
                                    <h4>XXXX XXXX XXXX 1213</h4>
                                    <h4>Gültig bis: 02/25</h4>
                                </div>
                            </div>
                            <!-- GROUP ENDS HERE -->
                        </div>
                    </section>
                    <section class="checkout_section checkout_overview">
                        <div class="checkout_section_header">
                            <h3>Übersicht</h3>
                            <h4>Deine letzte Kontrolle bevor wie die Süßwaren an dich schicken!</h4>
                        </div>
                        <div class="checkout_overview_grid_wrapper">
                            <div id="address_overview" class="checkout_grid_container exclude">
                                <div id="final_address" class="grid_container">
                                    <h2><?php echo ucfirst($resultAccount['firstname']); ?> <?php echo ucfirst($resultAccount['lastname']); ?></h2>
                                    <h4><?php echo ucfirst($resultDefAddress['address_line1']); ?> <?php echo $resultDefAddress['street_number']; ?></h4>
                                    <h4><?php echo ucfirst($resultDefAddress['city']); ?>, <?php echo $resultDefAddress['postal_code']; ?></h4>
                                </div>
                            </div>
                            <div id="shipping_overview" class="checkout_grid_container exclude">
                                <div id="final_ship" class="grid_container">
                                    <h2>Bitte auswählen</h2>
                                    <h4>Lieferdauer: - - -</h4>
                                    <h4>Lieferkosten: - - -</h4>
                                </div>
                            </div>
                            <div id="payment_overview" class="checkout_grid_container exclude">
                                <div id="final_payment" class="grid_container">
                                    <h2>Bitte auswählen</h2>
                                    <h4></h4>
                                    <h4></h4>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                        <div id="cart_overview" class="final_cart">
                            <div class="final_cart_products_grid_wrapper">
                                <?php
                                while ($row = $shoppingCart->fetch_assoc()) {
                                    $product = getProductData($conn, $row['product_id']);
                                    $price = $row['qty'] * $product['price'];
                                    ?>
                                    <div class="final_cart_products_grid_container">
                                        <div class="final_cart_product_wrapper">
                                            <div class="final_cart_product_data_image">
                                                <img src="<?php echo $product['product_image'] ?>" alt="">
                                            </div>
                                            <div id="mainItemDescription" class="final_cart_product_data_description flexCol">
                                                <h3><?php echo $product['product_name'] ?></h3>
                                                <h4><?php echo convertIdToCategoryName($conn, $product['product_category_id']) ?></h4>
                                            </div>
                                            <div class="final_cart_product_data_description">
                                                <h3 id="amount"><?php echo $row['qty'] ?>x</h3>
                                            </div>
                                            <div class="final_cart_product_data_description smallerDiv">
                                                <h3><?php echo $price ?>€</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
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
                    <h3><?php echo $_SESSION['wholeQty'] ?></h3>
                </div>
                <div class="cart_checkout_info">
                    <h3>Kosten Artikel</h3>
                    <h3 id=""><?php echo $_SESSION['fullPrice'] ?> €</h3>
                </div>
                <div class="cart_checkout_info">
                    <h3>Lieferkosten</h3>
                    <h3 id="lieferkosten">- - -</h3>
                </div>
                <div class="cart_checkout_info">
                    <h3>Gesamt Kosten</h3>
                    <h3 id="finalprice"><?php echo $endCosts ?> €</h3>
                </div>
                <div class="cart_checkout_buttons">
                    <button id="checkoutButton" type="submit" disabled name="checkout_button">Kostenpflichtig Bestellen</button>
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
