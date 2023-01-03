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
    <link rel="stylesheet" href="CSS/account.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
    <title></title>
    <?php
    require_once 'includes/dbh_include.php';
    require_once 'includes/account_include.php';
    require_once 'includes/functions_include.php';
    $resultAccount = getAccountData($conn);
    $resultDefAddress = getDefUserAddressData($conn);
    $resultAddressWODef = getUserAddressDataWODef($conn);
    $resultOrderIDs = getPersonalOrderIDsDescending($conn);
    $reOrderIDs = getPersonalOrderIDsDescending($conn);
    $resultDefPayment = getDefUserPaymentData($conn);
    $resultPaymentWODef = getUserPaymentDataWODef($conn);
    ?>
</head>

<body id="body">
<div class="account_header_wrapper">
    <div class="account_header_container">
        <h1>Hallo <?php echo $_SESSION["useruid"] ?></h1>
        <h4>Willkommen zurück beim Confectioner!</h4>
    </div>
    <div class="account_header_image">
        <img src="img/cookies.png" alt="">
    </div>
    <div class="account_header_logout">
        <a id="logout" class="logout_button" href="includes/logout_include.php">Abmelden</a>
    </div>
</div>
<?php if (isset($_SESSION["useruid"])) { ?>
    <div class="account_wrapper">
        <div class="account_wrapper_info">
            <div class="account_grid_wrapper">
                <div class="grid_container split_divs">
                    <div class="grid_header seperate_header">
                        <h1>Dein Confectioner Account</h1>
                        <h4>Bearbeite hier deinen Account und sieh deine letzten Bestellungen ein
                            <?php if ($_SESSION["userid"] != 1) { ?>
                                , oder <a id="delete" class="delete_account_button">Lösche</a> deinen Account.
                            <?php } else { ?>
                                .
                            <?php } ?>
                        </h4>
                    </div>
                    <div class="account_dash_wrapper">
                        <form id="changeAccount" action="includes/account_include.php" method="post">
                            <div class="dash_label_headers">
                                <h4>Benutzername:</h4>
                            </div>
                            <label for="username"></label><input required type="text" name="username" id="username" value="<?php echo $resultAccount['user_uid']; ?>" placeholder="Benutzername">
                            <div class="dash_label_headers account_double_container">
                                <h4>Vorname:</h4>
                                <h4>Nachname:</h4>
                            </div>
                            <div class="account_double_container">
                                <label for="name"></label><input required type="text" name="name" id="name" value="<?php echo $resultAccount['firstname']; ?>" placeholder="Vorname">
                                <label for="surname"></label><input required type="text" name="surname" id="surname" value="<?php echo $resultAccount['lastname']; ?>" placeholder="Nachname">
                            </div>
                            <div class="dash_label_headers">
                                <h4>Email:</h4>
                            </div>
                            <label for="email"></label><input required type="text" name="email" id="email" value="<?php echo $resultAccount['email']; ?>" placeholder="Email">
                            <div class="dash_label_headers account_double_container">
                                <h4>Neues Passwort:</h4>
                                <h4>Altes Passwort:</h4>
                            </div>
                            <div class="account_double_container">
                                <label for="newpassword"></label><input type="password" name="newpassword" id="newpassword" placeholder="Neues Passwort">
                                <label for="oldpassword"></label><input required type="password" name="oldpassword" id="oldpassword" placeholder="Altes Passwort">
                            </div>
                            <div class="account_error_container">
                                <h4>Print submit response here!</h4>
                            </div>
                        </form>
                    </div>
                    <div class="account_subsection_button">
                        <button form="changeAccount" type="submit" name="register_button">Speichern</button>
                    </div>
                </div>
                <div class="grid_container flex_display">
                    <div class="grid_header underline_grid">
                        <h1>Standard Adresse</h1>
                    </div>
                    <div class="standard_address_wrapper">
                        <div class="address_data">
                            <?php
                            if ($resultDefAddress !== null) {
                                ?>
                                <h2><?php echo ucfirst($resultAccount['firstname']); ?> <?php echo ucfirst($resultAccount['lastname']); ?></h2>
                                <h4><?php echo ucfirst($resultDefAddress['address_line1']); ?> <?php echo $resultDefAddress['street_number']; ?></h4>
                                <h4><?php echo ucfirst($resultDefAddress['city']); ?>, <?php echo $resultDefAddress['postal_code']; ?></h4>
                                <?php
                            } else {
                                ?>
                                <h4 id="noEmail">Du hast noch keine Standard Adresse beim Confectioner hinterlegt!</h4>
                                <?php
                            } ?>

                        </div>
                    </div>
                    <div class="account_subsection_button">
                        <a id="address">Deine Adressen</a>
                    </div>
                </div>
                <div class="grid_container">
                    <div class="grid_header underline_grid orders_header">
                        <h1>Letzte Bestellung</h1>
                        <div class="account_section_button">
                            <a id="orders">Deine Bestellungen</a>
                        </div>
                    </div>
                    <?php
                    $IDRows = $resultOrderIDs->fetch_assoc();
                    if ($IDRows != null) {
                        $ObjectRows = getObjectOrderDataByID($conn, $IDRows['id'])->fetch_assoc();
                        $DataRows = mysqli_fetch_assoc(getPersonalOrderDataByID($conn, $IDRows['id']));
                        ?>
                        <div class="purchases_wrapper">
                            <div class="grid_item">
                                <img src="<?php echo $ObjectRows['product_image'] ?>" alt="">
                            </div>
                            <div class="grid_item grid_description">
                                <div class="orders_info_title">
                                    <h2>Bestellung #<?php echo $IDRows['id'] ?></h2>
                                    <h2>Datum: <?php echo $DataRows['order_date'] ?></h2>
                                </div>
                                <h4>Anzahl Artikel: 2</h4>
                                <h4>
                                    Lieferadresse: <?php echo ucfirst($DataRows['address_line1']) ?> <?php echo $DataRows['street_number'] ?>, <?php echo $DataRows['postal_code'] ?>, <?php echo ucfirst($DataRows['city']) ?></h4>
                                <h4>Bezahlmethode: <?php echo $DataRows['value'] ?></h4>
                                <h4>Summe: <?php echo $DataRows['order_total'] ?>€</h4>
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="noPurchases">
                            <h3>Keine Bestellung verfügbar</h3>
                            <h4>Du hast noch keine Bestellung beim Confectioner gemacht!</h4>
                            <a href="index.php" class="purchases_button_back">Zum Confectioner</a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="grid_container flex_display">
                    <div class="grid_header underline_grid">
                        <h1>Zahlungsarten</h1>
                    </div>
                    <div class="standard_payment_wrapper">
                        <div class="payment_card">
                            <div class="card_top card_info">
                                <i class="material-symbols-outlined" style="pointer-events: none; font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48;">credit_card</i>
                                <h4>Comdirect</h4>
                            </div>
                            <div class="card_middle card_info">
                                <h4>XXXX XXXX XXXX 2095</h4>
                            </div>
                            <div class="card_bottom card_info">
                                <h4>Stuart Eichler</h4>
                                <div class="card_date">
                                    <h5>Gültig bis:</h5>
                                    <h4>02/25</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="account_subsection_button">
                        <a id="payments">Verwalten</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div tabindex="0" class="account_modal" id="delete-modal">
        <div class="modal_container modal_container_delete">
            <div class="modal_text">
                <div class="modal_header">
                    <span class="material-symbols-outlined">warning</span>
                    <h3>Account Löschen</h3>
                </div>
                <p>Falls du deinen Account für immer löschen möchtest, gib unten deine Daten ein letztes Mal ein und
                    bestätige das löschen. Denk dran, dass das hier nicht rückgängig gemacht werden kann!</p>
                <p id="sad_life">Wir werden dich beim Confectioner vermissen!</p>
            </div>
            <div class="modal_input">
                <form id="deleteAccount" action="includes/account_include.php" method="post">
                    <label for="delemail"></label><input required type="text" name="delemail" id="delemail" placeholder="Email">
                    <label for="delpassword"></label><input required type="password" name="delpassword" id="delpassword" placeholder="Passwort">
                </form>
            </div>
            <div class="modal_buttons">
                <button id="close_delete_modal">Ich will bleiben!</button>
                <button type="submit" form="deleteAccount" id="delete_Account">Account Löschen</button>
            </div>
        </div>
    </div>
    <div class="account_modal" id="address-modal">
        <div class="modal_container modal_container_address">
            <div class="modal_text" id="address_text_shadow">
                <div class="modal_header">
                    <span class="material-symbols-outlined">home</span>
                    <h3>Deine Adressen</h3>
                </div>
                <p>Hier kannst du deine gespeicherten Adressen einsehen, bearbeiten, oder weitere hinzufügen.</p>
            </div>
            <div class="modal_address_grid_wrapper">
                <?php
                if ($resultAddressWODef->num_rows < 5) {
                    ?>
                    <div class="modal_address_grid_container">
                        <div class="addressitem_container add_address">
                            <h2>Hinzufügen</h2>
                            <form id="addAddress" action="#" method="post">
                                <div class="add_address_oneline">
                                    <input type="text" name="addStreet" id="addStreet" placeholder="Straße">
                                    <input type="text" name="addHausnummer" id="addHausnummer" placeholder="No.">
                                </div>
                                <input type="text" name="addStadt" id="addStadt" placeholder="Stadt">
                                <input type="text" name="postal-code" id="postal-code" placeholder="PLZ">
                            </form>
                            <div class="addressitem_addbutton">
                                <button id="add_Address" form="addAddress" type="submit" name="add_address_button">
                                    Hinzufügen
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                } ?>
                <?php
                if ($resultDefAddress !== null) {
                    ?>
                    <div class="modal_address_grid_container">
                        <div class="addressitem_container">
                            <h2><?php echo ucfirst($resultAccount['firstname']); ?> <?php echo ucfirst($resultAccount['lastname']); ?></h2>
                            <h4><?php echo ucfirst($resultDefAddress['address_line1']); ?> <?php echo $resultDefAddress['street_number']; ?></h4>
                            <h4><?php echo ucfirst($resultDefAddress['city']); ?>, <?php echo $resultDefAddress['postal_code']; ?></h4>
                            <a class="defaultText">Standard Adresse</a>
                            <div class="address_setting_container">
                                <a href="account.php?delete=<?php echo $resultDefAddress['id'] ?>">
                                    <span id="addressicon" class="material-symbols-outlined" title="Adresse Löschen">delete</span></a>
                            </div>
                        </div>
                    </div>
                    <?php
                }

                if ($resultAddressWODef !== null) {
                    while ($rows = $resultAddressWODef->fetch_assoc()) {
                        ?>
                        <div class="modal_address_grid_container">
                            <div class="addressitem_container">
                                <h2><?php echo ucfirst($resultAccount['firstname']); ?> <?php echo ucfirst($resultAccount['lastname']); ?></h2>
                                <h4><?php echo ucfirst($rows['address_line1']); ?> <?php echo $rows['street_number']; ?></h4>
                                <h4><?php echo ucfirst($rows['city']); ?>, <?php echo $rows['postal_code']; ?></h4>
                                <div class="address_setting_container">
                                    <a href="account.php?edit=<?php echo $rows['id'] ?>">
                                        <span id="addressicon" class="material-symbols-outlined" title="Als Standard Setzen">edit_location</span></a>
                                    <a href="account.php?delete=<?php echo $rows['id'] ?>">
                                        <span id="addressicon" class="material-symbols-outlined" title="Adresse Löschen">delete</span></a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } ?>
            </div>
            <div class="modal_buttons">
                <button id="close_address_modal">Schließen</button>
            </div>
        </div>
    </div>
    <div class="account_modal" id="orders-modal">
        <div class="modal_container modal_container_order">
            <div id="order_text_shadow" class="modal_text">
                <div class="modal_header">
                    <span class="material-symbols-outlined">shopping_bag</span>
                    <h3>Deine Bestellungen</h3>
                </div>
                <p>Hier kannst du deinen Bestellverlauf einsehen - Du findest hier das Bestelldatum, deine Bestellten
                    Artikel, den Preis, sowie die Lieferadresse deiner Bestellung!</p>
            </div>
            <div class="modal_orders_grid_wrapper">
                <?php

                while ($rows = $reOrderIDs->fetch_assoc()) {
                    $DataRows = mysqli_fetch_assoc(getPersonalOrderDataByID($conn, $rows['id']));
                    $OrderArray = getObjectOrderDataByID($conn, $rows['id']);
                    ?>
                    <div class="modal_orders_grid_container">
                        <div class="order_container">
                            <div class="orders_info_image">
                                <img src="<?php echo mysqli_fetch_assoc($OrderArray)['product_image'] ?>" alt="">
                            </div>
                            <div class="orders_info_description">
                                <div class="orders_info_title">
                                    <h2>Bestellung #<?php echo $rows['id'] ?></h2>
                                    <h2>Datum: <?php echo $DataRows['order_date'] ?></h2>
                                </div>
                                <h4>Anzahl Artikel: 2</h4>
                                <h4>
                                    Lieferadresse: <?php echo ucfirst($DataRows['address_line1']) ?> <?php echo $DataRows['street_number'] ?>
                                    , <?php echo $DataRows['postal_code'] ?>
                                    , <?php echo ucfirst($DataRows['city']) ?></h4>
                                <h4>Bezahlmethode: <?php echo $DataRows['value'] ?></h4>
                                <h4>Summe: <?php echo $DataRows['order_total'] ?>€</h4>
                            </div>
                            <div class="orders_products_button">
                                <button class="order_button" id="order_show_<?php echo $rows['id'] ?>">Bestellung Anzeigen</button>
                            </div>
                        </div>
                        <div id="order_products_<?php echo $rows['id'] ?>" class="single_order_grid_wrapper">
                            <?php
                            $OrderArray = getObjectOrderDataByID($conn, $rows['id']);
                            while ($OrderRow = $OrderArray->fetch_assoc()) {
                                ?>
                                <div class="single_order_grid_container">
                                    <div class="single_order_item_container">
                                        <div class="single_order_product_image">
                                            <img src="<?php echo $OrderRow['product_image'] ?>" alt="">
                                        </div>
                                        <div class="single_order_product_description">
                                            <h2><?php echo $OrderRow['product_name'] ?></h2>
                                            <h4>Menge: <?php echo $OrderRow['qty'] ?></h4>
                                            <h4>Preis: <?php echo($OrderRow['qty'] * $OrderRow['price']) ?>€</h4>
                                            <div class="order_product_review">
                                                <span class="material-symbols-outlined" id="star1">star</span>
                                                <span class="material-symbols-outlined" id="star2">star</span>
                                                <span class="material-symbols-outlined" id="star3">star</span>
                                                <span class="material-symbols-outlined" id="star4">star</span>
                                                <span class="material-symbols-outlined" id="star5">star</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="modal_buttons">
                <button id="close_orders_modal">Schließen</button>
            </div>
        </div>
    </div>
    <div class="account_modal" id="payment-modal">
        <div class="modal_container modal_container_address">
            <div class="modal_text" id="address_text_shadow">
                <div class="modal_header">
                    <span class="material-symbols-outlined">credit_card</span>
                    <h3>Deine Zahlungsarten</h3>
                </div>
                <p>Hier kannst du deine gespeicherten Zahlungsarten einsehen, bearbeiten, oder weitere hinzufügen.</p>
            </div>
            <div class="modal_address_grid_wrapper">
                <?php
                if ($resultPaymentWODef->num_rows < 6) {
                    ?>
                    <div class="modal_address_grid_container">
                        <div class="addressitem_container add_address">
                            <h2>Hinzufügen</h2>
                            <form id="addPayment" action="#" method="post">
                                <select name="paymentMethod" id="paymentMethod" required>
                                    <option disabled selected hidden value="">Zahlungstyp</option>
                                    <?php
                                    $meth = getPaymentMethods($conn);
                                    while ($paymentRows = $meth->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $paymentRows['value'] ?>"><?php echo $paymentRows['value'] ?></option>
                                        <?php
                                    }
                                    ?>
                                    <input type="text" name="addNum" id="addNumber" required placeholder="Kartennummer">
                                    <div class="add_data_oneline payments">
                                        <input type="text" name="addProvider" id="addProvider" required placeholder="Provider">
                                        <input type="month" pattern="[0-1]{1}[0-9]{1}/[0-9]{2}" name="expiry_date" id="expiry_date" required placeholder="Ablaufdatum">
                                    </div>
                            </form>
                            <div class="addressitem_addbutton">
                                <button id="add_Payment" form="addPayment" type="submit" name="add_Payment_button">
                                    Hinzufügen
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                } ?>
                <?php
                if ($resultDefPayment !== null) {
                    ?>
                    <div class="modal_address_grid_container">
                        <div class="addressitem_container">
                            <h2><?php echo ucfirst($resultAccount['firstname']); ?><?php echo ucfirst($resultAccount['lastname']); ?></h2>
                            <h4><?php echo $resultDefPayment['provider'] ?></h4>
                            <h4><?php echo $resultDefPayment['account_number'] ?></h4>
                            <h4>Gültig bis: <?php echo $resultDefPayment['expiry_date'] ?></h4>
                            <a class="defaultText">Standard Zahlungsart</a>
                            <div class="address_setting_container">
                                <a href="account.php?delete=<?php echo $resultDefPayment['id'] ?>">
                                    <span id="addressicon" class="material-symbols-outlined" title="Zahlungsart Löschen">delete</span></a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                if ($resultPaymentWODef !== null) {
                    while ($rows = $resultPaymentWODef->fetch_assoc()) {
                        ?>
                        <div class="modal_address_grid_container">
                            <div class="addressitem_container">
                                <h2><?php echo ucfirst($resultAccount['firstname']); ?><?php echo ucfirst($resultAccount['lastname']); ?></h2>
                                <h4><?php echo $resultDefPayment['provider'] ?></h4>
                                <h4><?php echo $resultDefPayment['account_number'] ?></h4>
                                <h4>Gültig bis: <?php echo $resultDefPayment['expiry_date'] ?></h4>
                                <div class="address_setting_container">
                                    <a href="account.php?edit=<?php echo $rows['id'] ?>">
                                        <span id="addressicon" class="material-symbols-outlined" title="Als Standard Setzen">edit_location</span></a>
                                    <a href="account.php?delete=<?php echo $rows['id'] ?>">
                                        <span id="addressicon" class="material-symbols-outlined" title="Zahlungsart Löschen">delete</span></a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } ?>
            </div>
            <div class="modal_buttons">
                <button id="close_payment_modal">Schließen</button>
            </div>
        </div>
    </div>
    <div class="account_modal" id="delete-modal">
        <div class="modal_container">
            <div class="modal_text">
                <div class="modal_header">
                    <span class="material-symbols-outlined">warning</span>
                    <h3>Account Löschen</h3>
                </div>
                <p>Falls du deinen Account für immer löschen möchtest, gib unten deine Daten ein letztes Mal ein und
                    bestätige das löschen. Denk dran, dass das hier nicht rückgängig gemacht werden kann!</p>
                <p id="sad_life">Wir werden dich beim Confectioner vermissen!</p>
            </div>
            <div class="modal_input">
                <form id="deleteAccount" action="includes/account_include.php" method="post">
                    <label for="delemail"></label><input required type="text" name="delemail" id="delemail" placeholder="Email">
                    <label for="delpassword"></label><input required type="password" name="delpassword" id="delpassword" placeholder="Passwort">
                </form>
            </div>
            <div class="modal_buttons">
                <button id="close_modal">Ich will bleiben!</button>
                <button type="submit" form="deleteAccount" id="delete_Account">Account Löschen</button>
            </div>
        </div>
    </div>
    <script src="JS/account.js"></script>
<?php } ?>
</body>

</html>

<?php
include_once 'footer.php';
?>