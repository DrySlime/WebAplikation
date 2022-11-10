<!DOCTYPE html>
<html lang="de">

<?php
include_once 'header.php';
session_start();
?>

<head>
    <link rel="stylesheet" href="CSS/account.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
</head>

<body>
<div class="account_wrapper">
    <?php if (isset($_SESSION["useruid"])) { ?>
        <div class="account_dataWrapper">
            <div class="account_sidebar">
                <h1><span class="material-symbols-outlined">dashboard</span>Dashboard</h1>
                <h1><span class="material-symbols-outlined">person</span>Account</h1>
                <h1><span class="material-symbols-outlined">local_mall</span>Bestellungen</h1>
                <h1><span class="material-symbols-outlined">location_on</span>Adresse</h1>
                <h1><span class="material-symbols-outlined">payments</span>Bezahlmethoden</h1>
                <h1><span class="material-symbols-outlined">help</span>Help Desk</h1>
            </div>
            <div class="account_data">
                <h1>aaaaa</h1>
            </div>
        </div>
    <?php } else { ?>
        <div class="account_loginWrapper">

        </div>
    <?php } ?>
</div>
</body>

</html>

<?php
include_once 'footer.php';
?>