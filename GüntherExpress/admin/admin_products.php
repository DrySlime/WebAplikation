<?php
include_once "includes/admin_functions_inc.php";
include_once "../includes/dbh_include.php";
include_once "admin_header.php";
global $conn;

$categories = getCategoryData($conn, null);
$allProducts = getProductData($conn, null, null, null);
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" href="CSS/admin_shared_assets.css">
        <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <title></title>
    </head>
    <body>
    <div class="admin_dashboard_header_wrapper">
        <div class="admin_dashboard_header_container">
            <h1>Produkt Übersicht</h1>
            <h4>Hier werden alle Produkte auf The Confectioner aufgelistet!</h4>
        </div>
        <div class="admin_dashboard_header_image">
            <img src="../img/gummies.png" alt="">
        </div>
    </div>
    <div class="admin_dashboard_wrapper">
        <div class="admin_dashboard_container">
            <div class="admin_data_wrapper">
                <div id="showData" class="admin_data_container">
                    <h4>Produkt Suchen</h4>
                    <div class="admin_data_search">
                        <?php
                        $name = null;
                        $id = null;
                        $category = null;
                        if (isset($_POST["nameSearch"])) {
                            $name = $_POST["nameSearch"];
                        }
                        if (isset($_POST["pidSearch"])) {
                            $id = $_POST["pidSearch"];
                        }
                        if (isset($_POST["category"])) {
                            $category = $_POST["category"];
                        }
                        ?>
                        <form class="admin_data_search_form" id="searchProductForm" action="admin_products.php" method="post">
                            <label for="pidSearch">Produkt ID:</label><input type="text" id="pidSearch" name="pidSearch" value="<?php echo $id ?>" placeholder="Produkt ID">
                            <label for="nameSearch">Produkt Name:</label><input type="text" id="nameSearch" name="nameSearch" value="<?php echo $name ?>" placeholder="Produkt Name">
                            <label for="category">Kategorie:</label><select id="category" name="category">
                                <option disabled selected hidden value="">Kategorie Suchen</option>
                                <?php
                                for ($i = 0; $i < count($categories); $i++) {
                                    if ($category !== null && $categories[$i]["id"] == $category) { ?>
                                        <option selected="selected" value="<?php echo $categories[$i]["id"] ?>"><?php echo $categories[$i]["category_name"] ?></option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $categories[$i]["id"] ?>"><?php echo $categories[$i]["category_name"] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </form>
                        <div class="admin_data_search_buttons">
                            <button class="reset_searchProductForm" id="resetForm">Zurücksetzen</button>
                            <button id="searchProductForm" type="submit" form="searchProductForm">Suchen</button>
                        </div>
                    </div>
                    <div class="admin_data_table">
                        <?php
                        $productArr = getProductData($conn, $name, $id, $category);
                        ?>
                        <table>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Kategorie</th>
                                <th>Preis</th>
                                <th>Vorrat</th>
                                <th></th>
                            </tr>
                            <?php
                            if ($productArr == null) {
                                ?>
                                <tr>
                                    <td>-/-</td>
                                    <td>-/-</td>
                                    <td>-/-</td>
                                    <td>-/-</td>
                                    <td>-/-</td>
                                    <td>-/-</td>
                                </tr>
                                <?php
                            } else {
                                for ($i = 0; $i < count($productArr); $i++) {
                                    ?>
                                    <tr id="table_row_<?php echo $productArr[$i]["id"] ?>">
                                        <td><img src="<?php echo $productArr[$i]["product_image"] ?>"></td>
                                        <td class="disabled_<?php echo $productArr[$i]["active"] ?>"><?php echo $productArr[$i]["id"] ?></td>
                                        <td class="disabled_<?php echo $productArr[$i]["active"] ?>"><?php echo $productArr[$i]["product_name"] ?></td>
                                        <td class="disabled_<?php echo $productArr[$i]["active"] ?>"><?php echo getCategoryNameViaID($conn, $productArr[$i]["product_category_id"]) ?></td>
                                        <td class="disabled_<?php echo $productArr[$i]["active"] ?>"><?php echo $productArr[$i]["price"] ?> €</td>
                                        <td class="disabled_<?php echo $productArr[$i]["active"] ?>"><?php echo $productArr[$i]["qty_in_stock"] ?></td>
                                        <td class="alignRight">
                                            <button class="data_edit_button" id="editProduct_<?php echo $productArr[$i]["id"] ?>">Bearbeiten</button>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                        </table>
                    </div>
                </div>
                <div class="admin_data_subcontainer">
                    <div id="addData" class="admin_data_container">
                        <h4>Artikel Hinzufügen</h4>
                        <div class="admin_data_side_spacer">
                            <form id="addProducts" action="includes/productManager_inc.php" method="post">
                                <label for="category">Kategorie:</label><select required id="createcategory" name="createcategory">
                                    <option disabled selected hidden value="">Kategorie Wählen</option>
                                    <?php
                                    for ($i = 0; $i < count($categories); $i++) {
                                        ?>
                                        <option value="<?php echo $categories[$i]["id"] ?>"><?php echo $categories[$i]["category_name"] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <label for="createname">Name:</label><input required type="text" name="createname" id="createname" placeholder="Name">
                                <label for="createimage">Produkt Bild:</label><input required type="text" name="createimage" id="createimage" placeholder="Bild URL">
                                <label for="createdescription">Beschreibung:</label><textarea required type="text" name="createdescription" id="createdescription" placeholder="Beschreibung"></textarea>
                                <div class="data_Double_Container">
                                    <div class="data_double_label">
                                        <label for="createprice">Preis:</label><input required type="text" name="createprice" id="createprice" placeholder="Preis">
                                    </div>
                                    <div class="data_double_label">
                                        <label for="createamount">Vorrat:</label><input required type="text" name="createamount" id="createamount" placeholder="Vorrätige Menge">
                                    </div>
                                </div>
                            </form>
                            <div class="admin_data_submit_button">
                                <button form="addProducts" type="submit" id="saveProductNew" name="saveProductNew">Hinzufügen</button>
                            </div>
                        </div>
                    </div>
                    <div id="editData" class="admin_data_container">
                        <h4>Artikel Bearbeiten</h4>
                        <div class="admin_data_side_spacer">
                            <form id="editProducts" action="includes/productManager_inc.php" method="post">
                                <div class="data_Double_Container">
                                    <div class="data_double_label">
                                        <label for="itemidSelect">Produkt:</label><select required id="itemidSelect" name="itemidSelect">
                                            <option disabled selected hidden value="">Produkt Wählen</option>
                                            <?php
                                            for ($i = 0; $i < count($allProducts); $i++) {
                                                ?>
                                                <option value="<?php echo $allProducts[$i]["id"] ?>"><?php echo $allProducts[$i]["id"] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="data_double_label">
                                        <label for="editcategory">Kategorie:</label><select required id="editcategory" name="editcategory">
                                            <option disabled selected hidden value="">Kategorie Wählen</option>
                                            <?php
                                            for ($i = 0; $i < count($categories); $i++) {
                                                ?>
                                                <option value="<?php echo $categories[$i]["id"] ?>"><?php echo $categories[$i]["category_name"] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <label for="editactive">De-/Aktivieren:</label><select required id="editactive" name="editactive">
                                    <option value="1">Aktiviert</option>
                                    <option value="0">Deaktiviert</option>
                                </select>
                                <label for="editname">Name:</label><input required type="text" name="editname" id="editname" placeholder="Name">
                                <label for="editimage">Produkt Bild:</label><input required type="text" name="editimage" id="editimage" placeholder="Bild URL">
                                <label for="editdescription">Beschreibung:</label><textarea required type="text" name="editdescription" id="editdescription" placeholder="Beschreibung"></textarea>
                                <div class="data_Double_Container">
                                    <div class="data_double_label">
                                        <label for="editprice">Preis:</label><input required type="text" name="editprice" id="editprice" placeholder="Preis">
                                    </div>
                                    <div class="data_double_label">
                                        <label for="editamount">Vorrat:</label><input required type="text" name="editamount" id="editamount" placeholder="Vorrätige Menge">
                                    </div>
                                </div>
                            </form>
                            <div class="admin_data_submit_button">
                                <button form="editProducts" type="submit" id="saveProductEdit" name="saveProductEdit">Speichern</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="JS/adminForms.js"></script>
    <script src="JS/adminProducts.js"></script>
    </body>
    </html>
<?php
include_once "admin_footer.php";
?>