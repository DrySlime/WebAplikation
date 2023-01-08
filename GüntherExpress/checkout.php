<!DOCTYPE html>
<html lang="de">

<?php
include_once 'header.php';

global $conn;

if (!isset($_SESSION["useruid"])) {
    header('Location: login.php');
    die();
}

include_once 'includes/dbh_include.php';
include_once 'includes/functions_include.php';
include_once 'includes/checkout_include.php';
include_once 'includes/cart_include.php';
include_once 'includes/checkout_complete_inc.php';
$resultAccount = getAccountData($conn);
$resultDefAddress = getDefUserAddressData($conn);
$resultDefPayment = getDefUserPaymentData($conn);
$resultAddressWODef = getUserAddressDataWODef($conn);
$resultPaymentWODef = getUserPaymentDataWODef($conn);
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

<script>
    $(document).ready(function () {
        let radiobuttons = document.querySelectorAll("input[type=radio]");
        for (let i = 0; i < radiobuttons.length; i++) {
            if (radiobuttons[i].getAttribute("checked") === "checked") {
                let radioButton = radiobuttons[i];
                let id = radioButton.getAttribute('id');
                if (radioButton.getAttribute("name") === "delivery_buttons") {
                    createCookie("shippingId", id, "0.1");
                } else if (radioButton.getAttribute("name") === "address_buttons") {
                    createCookie("addressId", id, "0.1");
                } else if (radioButton.getAttribute("name") === "payment_buttons") {
                    createCookie("paymentId", id, "0.1");
                }
            }
        }
    });
</script>

<script>
    function setData(typ, id) {
        createCookie(typ, id, "0.1");
    }
</script>

<body>
<div class="cart_header_wrapper">
    <div class="cart_header_container">
        <h1>Deine Bestellung </h1>
        <h4>Wohin dürfen wir es versenden?</h4>
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
                                    <div class="grid_container add_data">
                                        <h2>Neue Adresse</h2>
                                        <form id="addAddress" method="post">
                                            <div class="add_data_oneline">
                                                <label for="addStreet"></label><input type="text" name="addStreet" id="addStreet" placeholder="Straße">
                                                <label for="addHausnummer"></label><input type="text" name="addHausnummer" id="addHausnummer" placeholder="No.">
                                            </div>
                                            <label for="addStadt"></label><input type="text" name="addStadt" id="addStadt" placeholder="Stadt">
                                            <label for="postal-code"></label><input type="text" name="postal-code" id="postal-code" placeholder="PLZ">
                                        </form>
                                        <div class="dataitem_addbutton">
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
                                <div class="checkout_grid_container address_container" onclick='setData("addressId", <?php echo $resultDefAddress['id'] ?>)'>
                                    <input class="radioButton" type="radio" id="<?php echo $resultDefAddress['id'] ?>" name="address_buttons" value="<?php echo $resultDefAddress['id'] ?>" checked="checked"><label for="<?php echo $resultDefAddress['id'] ?>"></label>
                                    <div id="address_<?php echo $resultDefAddress['id'] ?>" class="grid_container">
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
                                    <div class="checkout_grid_container address_container" onclick='setData("addressId", <?php echo $rows['id'] ?>)'>
                                        <input class="radioButton" type="radio" id="<?php echo $rows['id'] ?>" name="address_buttons" value="<?php echo $rows['id'] ?>"><label for="<?php echo $rows['id'] ?>"></label>
                                        <div id="address_<?php echo $rows['id'] ?>" class="grid_container">
                                            <h2><?php echo ucfirst($resultAccount['firstname']); ?>  <?php echo ucfirst($resultAccount['lastname']); ?></h2>
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
                                <div class="checkout_grid_container delivery_container" onclick='setData("shippingId", <?php echo $schippingRos['id'] ?>)'>
                                    <input class="radioButton" type="radio" id="<?php echo $schippingRos['id'] ?>" name="delivery_buttons" value="<?php echo $schippingRos['shipping_price'] ?>"><label for="<?php echo $schippingRos['id'] ?>"></label>
                                    <div id="ship_<?php echo $schippingRos['id'] ?>" class="grid_container">
                                        <h2><?php echo $schippingRos['shipping_name'] ?></h2>
                                        <h4>Lieferdauer: 3-5 Tage</h4>
                                        <h4>Lieferkosten: <?php echo $schippingRos['shipping_price'] ?> €</h4>
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
                            <?php
                            if ($resultPaymentWODef->num_rows < 6) {
                                ?>
                                <div class="checkout_grid_container addAddressContainer">
                                    <div class="grid_container add_data">
                                        <h2>Neue Zahlungsart</h2>
                                        <form id="addPayment" method="post">
                                            <label for="paymentMethod"></label><select name="paymentMethod" id="paymentMethod" required>
                                                <option disabled selected hidden value="">Zahlungstyp</option>
                                                <?php
                                                $meth = getPaymentMethods($conn);
                                                while ($paymentRows = $meth->fetch_assoc()) {
                                                    ?>
                                                    <option value="<?php echo $paymentRows['id'] ?>"><?php echo $paymentRows['value'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                                <label for="addNumber"></label><input type="text" name="addNumber" id="addNumber" required placeholder="Kartennummer">
                                                <div class="add_data_oneline payments">
                                                    <label for="addProvider"></label><input type="text" name="addProvider" id="addProvider" required placeholder="Provider">
                                                    <label for="expiry_date"></label><input type="month" pattern="[0-1]{1}[0-9]{1}/[0-9]{2}" name="expiry_date" id="expiry_date" required placeholder="Ablaufdatum">
                                                </div>
                                        </form>
                                        <div class="dataitem_addbutton">
                                            <button id="add_Payment" form="addPayment" type="submit" name="add_payment_button">
                                                Hinzufügen
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } ?>
                            <?php
                            if ($resultDefPayment !== null) {
                                ?>
                                <div class="checkout_grid_container payment_container" onclick='setData("paymentId", <?php echo $resultDefPayment['id'] ?>)'>
                                    <input class="radioButton" type="radio" id="<?php echo $resultDefPayment['id'] ?>" name="payment_buttons" value="<?php echo $resultDefPayment['id'] ?>" checked="checked"><label for="<?php echo $resultDefPayment['id'] ?>"></label>
                                    <div id="payment_<?php echo $resultDefPayment['id'] ?>" class="grid_container">
                                        <h2><?php echo ucfirst($resultAccount['firstname']); ?> <?php echo ucfirst($resultAccount['lastname']); ?></h2>
                                        <h4><?php echo $resultDefPayment['provider'] ?></h4>
                                        <h4><?php echo $resultDefPayment['account_number'] ?></h4>
                                        <h4>Gültig bis: <?php echo $resultDefPayment['expiry_date'] ?></h4>
                                    </div>
                                </div>
                                <?php
                            }
                            if ($resultPaymentWODef !== null) {
                                while ($rows = $resultPaymentWODef->fetch_assoc()) {
                                    ?>
                                    <div class="checkout_grid_container payment_container" onclick='setData("paymentId", <?php echo $rows['id'] ?>)'>
                                        <input class="radioButton" type="radio" id="<?php echo $rows['id'] ?>" name="payment_buttons" value="<?php echo $rows['id'] ?>">
                                        <div id="payment_<?php echo $rows['id'] ?>" class="grid_container">
                                            <h2><?php echo ucfirst($resultAccount['firstname']); ?> <?php echo ucfirst($resultAccount['lastname']); ?></h2>
                                            <h4><?php echo $rows['provider'] ?></h4>
                                            <h4><?php echo $rows['account_number'] ?></h4>
                                            <h4>Gültig bis: <?php echo $rows['expiry_date'] ?></h4>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } ?>
                        </div>
                    </section>
                    <section class="checkout_section checkout_overview">
                        <div class="checkout_section_header">
                            <h3>Übersicht</h3>
                            <h4>Deine letzte Kontrolle bevor wir die Süßwaren an dich schicken!</h4>
                        </div>
                        <div class="checkout_overview_grid_wrapper">
                            <div id="address_overview" class="checkout_grid_container exclude">
                                <div id="final_address" class="grid_container">
                                    <h2>Adresse auswählen</h2>
                                    <h4></h4>
                                    <h4></h4>
                                </div>
                            </div>
                            <div id="shipping_overview" class="checkout_grid_container exclude">
                                <div id="final_ship" class="grid_container">
                                    <h2>Versand auswählen</h2>
                                    <h4></h4>
                                    <h4></h4>
                                </div>
                            </div>
                            <div id="payment_overview" class="checkout_grid_container exclude">
                                <div id="final_payment" class="grid_container">
                                    <h2>Zahlungsart auswählen</h2>
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
