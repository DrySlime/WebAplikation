<?php
include_once "admin_header.php";
include_once "includes/admin_functions_inc.php";
include_once "../includes/dbh_include.php";

global $conn;
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" href="CSS/admin_shared_assets.css">
        <link rel="stylesheet" href="CSS/admin_orders.css">
        <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <title></title>
    </head>
    <body>
    <div class="admin_dashboard_header_wrapper">
        <div class="admin_dashboard_header_container">
            <h1>Bestellungen Übersicht</h1>
            <h4>Hier werden alle Bestellung, welche auf The Confectioner gemacht wurden, aufgelistet!</h4>
        </div>
        <div class="admin_dashboard_header_image">
            <img src="../img/gummies.png" alt="">
        </div>
    </div>
    <div class="admin_dashboard_wrapper">
        <div class="admin_dashboard_container">
            <div class="admin_data_wrapper">
                <div class="admin_data_container">
                    <h4>Bestellung Suchen</h4>
                    <div class="admin_data_search">
                        <?php
                        $id = null;
                        $user = null;
                        if (isset($_POST["userSearch"])) {
                            $user = $_POST["userSearch"];
                        }
                        if (isset($_POST["bidSearch"])) {
                            $id = $_POST["bidSearch"];
                        }
                        ?>
                        <form class="admin_data_search_form" id="searchOrderForm" action="admin_orders.php" method="post">
                            <label for="bidSearch">Bestellungs ID:</label><input type="text" id="bidSearch" value="<?php echo $id ?>" name="bidSearch" placeholder="Bestellungs ID">
                            <label for="userSearch">Nutzer ID:</label><input type="text" id="userSearch" value="<?php echo $user ?>" name="userSearch" placeholder="Nutzer ID"><label for="userSearch"></label>
                        </form>
                        <div class="admin_data_search_buttons">
                            <button class="reset_searchOrderForm" id="resetForm">Zurücksetzen</button>
                            <button type="submit" form="searchOrderForm">Suchen</button>
                        </div>
                    </div>
                    <div class="admin_data_table">
                        <?php
                        $productArray = getOrderData($conn, $user, $id);
                        ?>
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>Nutzer</th>
                                <th>Datum</th>
                                <th>Zahlungs</th>
                                <th>Lieferadresse</th>
                                <th>Versand</th>
                                <th>Kosten</th>
                                <th>Inhalt</th>
                                <th></th>
                            </tr>
                            <?php
                            if ($productArray == null) {
                                ?>
                                <tr>
                                    <td>-/-</td>
                                    <td>-/-</td>
                                    <td>-/-</td>
                                    <td>-/-</td>
                                    <td>-/-</td>
                                    <td>-/-</td>
                                    <td>-/-</td>
                                    <td>-/-</td>
                                </tr>
                                <?php
                            } else {
                                for ($i = 0; $i < count($productArray); $i++) {
                                    $order = getOrderLine($conn, $productArray[$i]["order_id"]);
                                    ?>
                                    <tr>
                                        <td><?php echo $productArray[$i]["order_id"] ?></td>
                                        <td><?php echo getUsername($conn, $productArray[$i]["siteuser_id"]) ?></td>
                                        <td><?php echo $productArray[$i]["order_date"] ?></td>
                                        <td><?php echo getPaymentMethod($conn, $productArray[$i]["payment_method_id"]) ?></td>
                                        <td><?php echo getShippingAdress($conn, $productArray[$i]["shipping_address_id"]) ?></td>
                                        <td><?php echo getShippingMethod($conn, $productArray[$i]["shipping_method_id"]) ?></td>
                                        <td><?php echo $productArray[$i]["order_total"] ?> €</td>
                                        <td><?php echo orderlineToTEXT($conn, $order) ?></td>
                                    </tr>
                                    <?php
                                }
                            } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="JS/adminForms.js"></script>
    </body>
    </html>
<?php require_once "admin_footer.php" ?>