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
</head>

<body>
    <div class="account_wrapper">
        <?php if (isset($_SESSION["useruid"])) { ?>
            <div class="account_header">
                <div class="header_text">
                    <h1>
                        Account
                    </h1>
                    <hr class="header_sep">
                </div>
            </div>
            <div class="account_dataWrapper">
                <div class="account_sidebar">
                    <h1>
                        aaaaa
                    </h1>
                </div>
                <div class="account_data">
                <h1>
                        aaaaa
                    </h1>
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