<!DOCTYPE html>
<html lang="en">

<?php
include 'includes/dbh_include.php';
include 'includes/functions_include.php';
?>

<head>
    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet"href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
    <script type="text/javascript" src="../../../Desktop/Website/js/header.js"></script>
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <title>The Confectioner</title>
</head>

<body>
    <header class="header">
        <div class="header_wrapper">
            <div>
                <a class="header_name" href="index.php">The Confectioner</a>
            </div>
            <div class="navbar">
                <ul id="navbar">
                    <li><a href="index.php">Home</a></li>
                    <li>
                        <div class="navbar_dropdown">
                            <button onclick="showCategories()" class="dropbtn">Kategorien<i class="material-symbols-outlined" style="pointer-events: none;">expand_more</i></button>
                            <div id="navbarDropdown" class="dropdown_content">
                                <?php foreach (getCategoryList($conn) as $key => $value) { ?>
                                <a href="#"><?php echo $value ?></a><?php } ?>
                            </div>
                        </div>
                    </li>
                    <li><a href="sale.php">Sale</a></li>
                    <li><a href="account.php">Account</a></li>
                    <li><button class="dropbtn" onclick="showWarenkorb()"> <i class="material-symbols-outlined" style="pointer-events: none;">shopping_cart</i></button></li>
                </ul>
            </div>
        </div>
    </header>
</body>
</html>
