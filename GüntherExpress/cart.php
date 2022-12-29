<!DOCTYPE html>
<html lang="de">

<?php
include_once 'header.php';
include_once 'includes/product_include.php';
include_once 'includes/cart_include.php';
global $conn;

if (!isset($_SESSION["useruid"])) {
    header('Location: login.php');
    die();
}
$shoppingCart = getShoppingCartItems($conn, $_SESSION["userid"]);
getWholeQty($shoppingCart);
$shoppingCart = getShoppingCartItems($conn, $_SESSION["userid"]);
$_SESSION['fullPrice'] = 0;

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
        <h4>Du hast <?php echo $_SESSION['wholeQty'] ?> Artikel im Wagen!</h4>
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
            <?php
            if ($shoppingCart->num_rows == 0) {
                ?>
                <div class="products_no_item_wrapper">
                    <img src="img/backdrop.png" alt="Andre Caputo">
                    <h4>Du hast noch keine Artikel im Warenkorb!</h4>
                    <p>Such dir leckere Produkte aus unserem Sortiment aus und füge sie hinzu!</p>
                    <a href='index.php'>Zum Laden</a>
                </div>
                <?php
            } else { ?>
                <div class="cart_products_grid_wrapper">
                    <?php
                    while ($row = $shoppingCart->fetch_assoc()) {
                        $product = getProductData($conn, $row['product_id']);
                        $price = $row['qty'] * $product['price'];
                        $_SESSION['fullPrice'] = $_SESSION['fullPrice'] + $price;
                        ?>
                        <div class="cart_products_grid_container">
                            <div class="cart_product_wrapper">
                                <div class="cart_product_data_image">
                                    <img src="<?php echo $product['product_image'] ?>" alt="">
                                </div>
                                <div id="mainItemDescription" class="cart_product_data_description flexCol">
                                    <h3><?php echo $product['product_name'] ?></h3>
                                    <h4><?php echo convertIdToCategoryName($conn, $product['product_category_id']) ?></h4>
                                </div>
                                <div class="cart_product_data_settings">
                                    <div class="buttonAmount">
                                        <a href="cart.php?decrease=<?php echo $row['product_id'] ?>" ><span class="material-icons md40">remove_circle</span></a>
                                    </div>
                                    <h4 id="amount"><?php echo $row['qty'] ?></h4>
                                    <div class="buttonAmount">
                                        <a href="cart.php?increase=<?php echo $row['product_id'] ?> "><span class="material-icons md40">add_circle</span></a>
                                    </div>
                                </div>
                                <div class="cart_product_data_description smallerDiv">
                                    <h3><?php echo $price ?>€</h3>
                                </div>
                                <div class="cart_product_data_settings soloPadding buttonAmount">
                                    <a href="cart.php?delete=<?php echo $row['product_id'] ?> "><span class="material-symbols-outlined">remove_shopping_cart</span></a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            ?>
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
                    <h3><?php echo $_SESSION['fullPrice'] ?> €</h3>
                </div>
                <div class="cart_checkout_info">
                    <h3>Lieferkosten</h3>
                    <h3 id="lieferkosten">Wird im nächsten Schritt Berechnet</h3>
                </div>
                <div class="cart_checkout_info">
                    <h3>Gesamt Kosten</h3>
                    <h3><?php echo $_SESSION['fullPrice'] ?> €</h3>
                </div>
                <div class="cart_checkout_buttons">
                    <?php if ($shoppingCart->num_rows == 0) { ?>
                        <button class="disabled" name="checkout_button">Zur Kasse</button>
                    <?php } else { ?>
                        <button class="enabled" onclick="goToCheckout()" name="checkout_button">Zur Kasse</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="JS/cart.js"></script>
</html>

<?php
include_once 'footer.php';
?>
