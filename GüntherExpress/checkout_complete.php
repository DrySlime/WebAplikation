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
        <h1>Vielen Dank für deine Bestellung </h1>
        <h4>Guten Appetit und bis zum nächsten Mal</h4>
        <div class="homecoming">
            <img src="img/blueThing.png" alt="">
            <a href="index.php" class="home_button">Zum Confectioner</a>
        </div>
        
    </div>
    
    
    
    <div class="cart_header_image">
        <img src="img/cookies.jpg" alt="">
    </div>
    

    
</div>
</body>
</html>

<?php
include_once 'footer.php';
?>