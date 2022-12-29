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
    <link rel="stylesheet" href="CSS/checkout_complete.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title></title>
</head>

<body>
<div id="finalPurchase" class="cart_header_wrapper">
    <div class="cart_header_container">
        <h1>Vielen Dank!</h1>
        <h4>Deine Bestellung wird vorbereitet und ist im Handumdrehen bei dir! Frohes nashen!</h4>
        <a href="index.php">Zurück zum Confectioner</a>
    </div>
    <div class="cart_header_image">
        <img src="img/cookies.png" alt="">
    </div>
</div>
</body>
</html>

<?php
include_once 'footer.php';
?>