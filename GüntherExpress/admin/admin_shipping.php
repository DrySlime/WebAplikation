<?php
include_once "includes/admin_functions_inc.php";
include_once "../includes/dbh_include.php";
include_once "admin_header.php";
global $conn;

$allShippingMethods = getShippingMethodDataAdmin($conn, null);

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" href="CSS/admin_small_assets.css">
        <link rel="stylesheet" href="CSS/admin_shared_assets.css">
        <link rel="stylesheet" href="CSS/admin_shipping.css">
        <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <title></title>
    </head>
    <body>
    <div class="admin_dashboard_header_wrapper">
        <div class="admin_dashboard_header_container">
            <h1>Versand Übersicht</h1>
            <h4>Hier werden alle Versand Möglichkeiten auf The Confectioner aufgelistet!</h4>
        </div>
        <div class="admin_dashboard_header_image">
            <img src="../img/gummies.png" alt="">
        </div>
    </div>
    <div class="admin_dashboard_wrapper">
        <div class="admin_dashboard_container">
            <div class="admin_data_wrapper">
                <div class="admin_data_container">
                    <h4>Versand Suchen</h4>
                    <div class="admin_data_search">
                        <?php
                        $id = null;
                        if (isset($_POST["vidSearch"])) {
                            $id = $_POST["vidSearch"];
                        }
                        if (isset($_POST["shippingSearch"])) {
                            $id = $_POST["shippingSearch"];
                        }
                        ?>
                        <form class="admin_data_search_form" id="searchShippingForm" action="admin_shipping.php" method="post">
                            <label for="vidSearch">Versand ID:</label><input type="text" value="<?php echo $id ?>" id="vidSearch" name="vidSearch" placeholder="Versand ID">
                            <label for="shippingSearch">Versand Name:</label><select id="shippingSearch" name="shippingSearch">
                                <option disabled selected hidden value="">Versand Suchen</option>
                                <?php
                                for ($i = 0; $i < count($allShippingMethods); $i++) {
                                    if ($id !== null && $allShippingMethods[$i]["id"] == $id) { ?>
                                        <option selected="selected" value="<?php echo $allShippingMethods[$i]["id"] ?>"><?php echo $allShippingMethods[$i]["shipping_name"] ?></option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $allShippingMethods[$i]["id"] ?>"><?php echo $allShippingMethods[$i]["shipping_name"] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </form>
                        <div class="admin_data_search_buttons">
                            <button class="reset_searchShippingForm" id="resetForm">Zurücksetzen</button>
                            <button type="submit" id="searchShippingForm" form="searchShippingForm">Suchen</button>
                        </div>
                    </div>
                    <div class="admin_data_table">
                        <?php
                        $SMethodArr = getShippingMethodDataAdmin($conn, $id);
                        ?>
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>Versand</th>
                                <th>Versandkosten</th>
                                <th></th>
                            </tr>
                            <?php
                            if ($SMethodArr == null) {
                                ?>
                                <tr>
                                    <td>-/-</td>
                                    <td>-/-</td>
                                    <td>-/-</td>
                                </tr>
                                <?php
                            } else {
                                for ($i = 0; $i < count($SMethodArr); $i++) {
                                    ?>
                                    <tr>
                                        <td><?php echo $SMethodArr[$i]["id"] ?></td>
                                        <td><?php echo $SMethodArr[$i]["shipping_name"] ?></td>
                                        <td><?php echo $SMethodArr[$i]["shipping_price"] ?> €</td>
                                        <td class="alignRight">
                                            <button class="data_edit_button" id="editShipping_<?php echo $SMethodArr[$i]["id"] ?>">Bearbeiten</button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>
                <div class="admin_data_subcontainer">
                    <div id="addData" class="admin_data_container">
                        <h4>Versand Hinzufügen</h4>
                        <div class="admin_data_side_spacer">
                            <form id="addShipping" action="includes/shippingManager_inc.php" method="post">
                                <label for="createname">Versand Name</label><input required type="text" name="createname" id="createname" placeholder="Name">
                                <label for="createprice">Versand Kosten</label><input required type="text" name="createprice" id="createprice" placeholder="Versandkosten">
                            </form>
                            <div class="admin_data_submit_button">
                                <button form="addShipping" type="submit" name="saveShippingNew">Hinzufügen</button>
                            </div>
                        </div>
                    </div>
                    <div id="editData" class="admin_data_container">
                        <h4>Versand Bearbeiten</h4>
                        <div class="admin_data_side_spacer">
                            <form id="editShip" action="includes/shippingManager_inc.php" method="post">
                                <div class="data_Double_Container">
                                    <div class="data_double_label">

                                        <label for="editshipping">Versand</label><select required id="editshipping" name="editshipping">
                                            <option disabled selected hidden value="">Versand Wählen</option>
                                            <?php
                                            for ($i = 0; $i < count($allShippingMethods); $i++) {
                                                ?>
                                                <option value="<?php echo $allShippingMethods[$i]["id"] ?>"><?php echo $allShippingMethods[$i]["shipping_name"] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="data_double_label">
                                        <label for="editactive">De-/Aktivieren:</label><select required id="editactive" name="editactive">
                                            <option value="1">Aktiviert</option>
                                            <option value="0">Deaktiviert</option>
                                        </select>
                                    </div>
                                </div>
                                <label for="editname">Versand Name</label><input required type="text" name="editname" id="editname" placeholder="Name">
                                <label for="editprice">Lieferkosten</label><input required type="text" name="editprice" id="editprice" placeholder="Versandkosten">
                            </form>
                            <div class="admin_data_submit_button">
                                <button form="editShip" type="submit" name="saveShippingEdit">Speichern</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="JS/adminForms.js"></script>
    <script src="JS/adminShipping.js"></script>
    </body>
    </html>

<?php
include_once "admin_footer.php";
?>