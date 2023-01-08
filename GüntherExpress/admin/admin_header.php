<!DOCTYPE html>
<html lang="en">

<?php
global $conn;
session_start();
?>

<head>
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="CSS/admin_header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
    <script type="text/javascript" src="../JS/header.js"></script>
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
    <title>The Confectioner</title>
</head>

<body>
<header class="header">
    <div class="header_wrapper">
        <div>
            <a class="header_name" href="admin.php">The Confectioner</a>
        </div>
        <div class="navbar">
            <ul id="navbar">
                <li><a href="admin.php">Home</a></li>
                <li><a href="admin_products.php">Produkte</a></li>
                <li><a href="admin_users.php">Nutzer</a></li>
                <li><a href="admin_orders.php">Bestellungen</a></li>
                <li><a href="admin_categories.php">Kategorien</a></li>
                <li><a href="admin_shipping.php">Versand</a></li>
                <li class="header_admin_exit"><a href="../index.php">Verlassen</a></li>
            </ul>
        </div>
    </div>
</header>
</body>
</html>