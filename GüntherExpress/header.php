<!DOCTYPE html>
<html lang="en">

<?php
include 'includes/dbh_include.php';
include 'includes/functions_include.php';
global $conn;
session_start();
?>

<head>
    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
    <script type="text/javascript" src="JS/header.js"></script>
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
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
                        <button onclick="showCategories()" class="dropbtn">Kategorien<i class="material-symbols-outlined" style="pointer-events: none;">expand_more</i>
                        </button>
                        <div id="navbarDropdown" class="dropdown_content">
                            <?php foreach (getCategoryList($conn) as $key => $value) { ?>
                                <a href=<?php echo "products.php?name=" . $value ?>><?php echo $value ?></a><?php } ?>
                        </div>
                    </div>
                </li>
                <?php if (isset($_SESSION["useruid"])) { ?>
                    <li><a href="account.php">Account</a></li>
                <?php } else { ?>
                    <li><a href="login.php">Login</a></li>
                <?php } ?>
                <?php if (isset($_SESSION["useruid"])) {
                    if ($_SESSION["userid"] == 1) {
                        ?>
                        <li><a href="/admin/admin.php">Admin</a></li>
                    <?php }
                } ?>
                <li>
                    <button class="dropbtn" onclick="window.location.href = 'cart.php';">
                        <i class="material-symbols-outlined" style="pointer-events: none;">shopping_cart</i></button>
                </li>
            </ul>
        </div>
    </div>
</header>
</body>
</html>
