<!DOCTYPE html>
<html lang="de">

<?php
include_once 'header.php';
global $conn;

if (!isset($_SESSION["useruid"])) {
    header('Location: login.php');
    die();
}
?>

<head>
    <link rel="stylesheet" href="CSS/cart.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title></title>
</head>

<body>
<div class="cart_header_wrapper">
    <div class="cart_header_container">
        <h1>Dein Einkaufswagen</h1>
        <h4>Du hast 2 Artikel im Wagen!</h4>
    </div>
    <div class="cart_header_image">
        <img src="img/cookies.png" alt="">
    </div>
</div>
<div class="cart_wrapper">
    <div class="cart_grid_wrapper">
        <div class="cart_grid_container">
            <div class="cart_grid_container_header">
                <h4>Deine Artikel</h4>
            </div>
            <div class="cart_products_grid_wrapper">
                <!-- NEW PRODUCT STARTING HERE -->
                <div class="cart_products_grid_container">
                    <div class="cart_product_wrapper">
                        <div class="cart_product_data_image">
                            <img src="img/macaronProduct.png" alt="">
                        </div>
                        <div id="mainItemDescription" class="cart_product_data_description flexCol">
                            <h3>Macaron Product</h3>
                            <h4>Kategorie</h4>
                        </div>
                        <div class="cart_product_data_settings">
                            <button class="buttonAmount" id="decreaseAmount" onclick="removeFromAmount()">
                                <span class="material-icons md40">remove_circle</span>
                            </button>
                            <h4 id="amount">1</h4>
                            <button class="buttonAmount" id="increaseAmount" onclick="addToAmount()">
                                <span class="material-icons md40">add_circle</span>
                            </button>
                        </div>
                        <div class="cart_product_data_description smallerDiv">
                            <h3>420,69 €</h3>
                        </div>
                        <div class="cart_product_data_settings soloPadding">
                            <a><span class="material-symbols-outlined">remove_shopping_cart</span></a>
                        </div>
                    </div>
                </div>
                <!-- PRODUCT ENDS HERE -->
                <!-- NEW PRODUCT STARTING HERE -->
                <div class="cart_products_grid_container">
                    <div class="cart_product_wrapper">
                        <div class="cart_product_data_image">
                            <img src="img/macaronProduct.png" alt="">
                        </div>
                        <div id="mainItemDescription" class="cart_product_data_description flexCol">
                            <h3>Macaron Product</h3>
                            <h4>Kategorie</h4>
                        </div>
                        <div class="cart_product_data_settings">
                            <button class="buttonAmount" id="decreaseAmount" onclick="removeFromAmount()">
                                <span class="material-icons md40">remove_circle</span>
                            </button>
                            <h4 id="amount">1</h4>
                            <button class="buttonAmount" id="increaseAmount" onclick="addToAmount()">
                                <span class="material-icons md40">add_circle</span>
                            </button>
                        </div>
                        <div class="cart_product_data_description smallerDiv">
                            <h3>420,69 €</h3>
                        </div>
                        <div class="cart_product_data_settings soloPadding">
                            <a><span class="material-symbols-outlined">remove_shopping_cart</span></a>
                        </div>
                    </div>
                </div>
                <!-- PRODUCT ENDS HERE -->
                <!-- NEW PRODUCT STARTING HERE -->
                <div class="cart_products_grid_container">
                    <div class="cart_product_wrapper">
                        <div class="cart_product_data_image">
                            <img src="img/macaronProduct.png" alt="">
                        </div>
                        <div id="mainItemDescription" class="cart_product_data_description flexCol">
                            <h3>Macaron Product</h3>
                            <h4>Kategorie</h4>
                        </div>
                        <div class="cart_product_data_settings">
                            <button class="buttonAmount" id="decreaseAmount" onclick="removeFromAmount()">
                                <span class="material-icons md40">remove_circle</span>
                            </button>
                            <h4 id="amount">1</h4>
                            <button class="buttonAmount" id="increaseAmount" onclick="addToAmount()">
                                <span class="material-icons md40">add_circle</span>
                            </button>
                        </div>
                        <div class="cart_product_data_description smallerDiv">
                            <h3>420,69 €</h3>
                        </div>
                        <div class="cart_product_data_settings soloPadding">
                            <a><span class="material-symbols-outlined">remove_shopping_cart</span></a>
                        </div>
                    </div>
                </div>
                <!-- PRODUCT ENDS HERE -->
                <!-- NEW PRODUCT STARTING HERE -->
                <div class="cart_products_grid_container">
                    <div class="cart_product_wrapper">
                        <div class="cart_product_data_image">
                            <img src="img/macaronProduct.png" alt="">
                        </div>
                        <div id="mainItemDescription" class="cart_product_data_description flexCol">
                            <h3>Macaron Product</h3>
                            <h4>Kategorie</h4>
                        </div>
                        <div class="cart_product_data_settings">
                            <button class="buttonAmount" id="decreaseAmount" onclick="removeFromAmount()">
                                <span class="material-icons md40">remove_circle</span>
                            </button>
                            <h4 id="amount">1</h4>
                            <button class="buttonAmount" id="increaseAmount" onclick="addToAmount()">
                                <span class="material-icons md40">add_circle</span>
                            </button>
                        </div>
                        <div class="cart_product_data_description smallerDiv">
                            <h3>420,69 €</h3>
                        </div>
                        <div class="cart_product_data_settings soloPadding">
                            <a><span class="material-symbols-outlined">remove_shopping_cart</span></a>
                        </div>
                    </div>
                </div>
                <!-- PRODUCT ENDS HERE -->
            </div>
        </div>
        <div class="cart_grid_container limited_height">
            <div class="cart_grid_container_header">
                <h4>Zahlungsübersicht</h4>
            </div>
            <div class="cart_products_checkout_wrapper">
                <div class="cart_checkout_info dashBorder">
                    <h3>Anzahl Artikel</h3>
                    <h3>2</h3>
                </div>
                <div class="cart_checkout_info">
                    <h3>Kosten Artikel</h3>
                    <h3>420.69 €</h3>
                </div>
                <div class="cart_checkout_info">
                    <h3>Lieferkosten</h3>
                    <h3 id="lieferkosten">Wird im nächsten Schritt Berechnet</h3>
                </div>
                <div class="cart_checkout_info">
                    <h3>Gesamt Kosten</h3>
                    <h3>420.69 €</h3>
                </div>
                <div class="cart_checkout_buttons">
                    <button type="submit" name="checkout_button">Zur Kasse</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>

<?php
include_once 'footer.php';
?>
