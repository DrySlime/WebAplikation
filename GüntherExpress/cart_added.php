<!DOCTYPE html>
<html lang="de">

<?php
include_once 'header.php';
include 'includes/dbh_include.php';
include_once 'includes/functions_include.php';
include_once "includes/item_function.php";
include "includes/cart_insert_inc.php";

runCartProcess();

global $conn;

if (!isset($_SESSION["useruid"])) {
    header('Location: login.php');
    die();
}

$product = getAllFromProductID($conn, $_GET['pID']);
$userUID = $_SESSION["useruid"];
?>

<head>
    <link rel="stylesheet" href="CSS/cart.css">
    <link rel="stylesheet" href="CSS/cart_added.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title></title>
</head>

<body>
<div id="wrapper" class="cart_header_wrapper">
    <div class="cart_header_container">
        <h1>Zum Einkaufswagen hinzugefügt!</h1>
        <h4>Du hast folgenden Artikel hinzugefügt:</h4>
    </div>
    <div class="cart_header_image">
        <img src="img/cookies.png" alt="">
    </div>
</div>
<div class="cart_wrapper">
    <div class="cart_added_container">
        <div class="cart_added_group_wrapper">
            <div class="cart_added_left">
                <div class="cart_added_image_container">
                    <img src="<?php echo $product[0]["product_image"]; ?>" alt="">
                </div>
            </div>
            <div class="cart_added_right">
                <div class="cart_added_data_container">
                    <div class="cart_added_data">
                        <h5><?php echo convertIdToCategoryName($conn, $product[0]["product_category_id"]) ?></h5>
                        <h3><?php echo $product[0]["product_name"] ?></h3>
                        <h4>Menge: <?php echo $_GET["quantity"]; ?>x</h4>
                    </div>
                    <div class="cart_added_buttons">
                        <a href="products.php?name=<?php echo convertIdToCategoryName($conn, $product[0]["product_category_id"]) ?>">Weiter einkaufen</a>
                        <a href="cart.php">Zum Einkaufswagen</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="JS/cart.js"></script>
</body>
</html>

<?php
include_once 'footer.php';
?>