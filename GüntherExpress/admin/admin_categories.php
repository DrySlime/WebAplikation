<?php
include_once "includes/admin_functions_inc.php";
include_once "../includes/dbh_include.php";
include_once "admin_header.php";

global $conn;

$allCategories = getCategoryData($conn, null);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="CSS/admin_small_assets.css">
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
        <h1>Kategorie Übersicht</h1>
        <h4>Hier werden alle Produkt Kategorien auf The Confectioner aufgelistet!</h4>
    </div>
    <div class="admin_dashboard_header_image">
        <img src="../img/gummies.png" alt="">
    </div>
</div>
<div class="admin_dashboard_wrapper">
    <div class="admin_dashboard_container">
        <div class="admin_data_wrapper">
            <div class="admin_data_container">
                <h4>Kategorie Suchen</h4>
                <div class="admin_data_search">
                    <?php
                    $id = null;
                    if (isset($_POST["cidSearch"])) {
                        $id = $_POST["cidSearch"];
                    }
                    if (isset($_POST["categorySearch"])) {
                        $id = $_POST["categorySearch"];
                    }
                    ?>
                    <form class="admin_data_search_form" id="searchCategoryForm" action="admin_categories.php" method="post">
                        <label for="cidSearch">Nach ID Suchen:</label><input type="text" id="cidSearch" value="<?php echo $id ?>" name="cidSearch" placeholder="Kategorie ID">
                        <label for="categorySearch">Nach Kategorie Suchen:</label><select id="categorySearch" name="categorySearch">
                            <option disabled selected hidden value="">Kategorie Suchen</option>
                            <?php
                            for ($i = 0; $i < count($allCategories); $i++) {
                                if ($id !== null && $allCategories[$i]["id"] == $id) { ?>
                                    <option selected="selected" value="<?php echo $allCategories[$i]["id"] ?>"><?php echo $allCategories[$i]["category_name"] ?></option>
                                    <?php
                                } else {
                                    ?>
                                    <option value="<?php echo $allCategories[$i]["id"] ?>"><?php echo $allCategories[$i]["category_name"] ?></option>
                                    <?php
                                }
                            } ?>
                        </select>
                    </form>
                    <div class="admin_data_search_buttons">
                        <button class="reset_searchCategoryForm" id="resetForm">Zurücksetzen</button>
                        <button type="submit" id="searchCategoryForm" form="searchCategoryForm">Suchen</button>
                    </div>
                </div>
                <div class="admin_data_table">
                    <?php
                    $categoryArr = getCategoryData($conn, $id);
                    ?>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th></th>
                        </tr>
                        <?php
                        if ($categoryArr == null) {
                            ?>
                            <tr>
                                <td>-/-</td>
                                <td>-/-</td>
                            </tr>
                            <?php
                        } else {
                            for ($i = 0; $i < count($categoryArr); $i++) {
                                ?>
                                <tr>
                                    <td class="disabled_<?php echo $categoryArr[$i]["active"] ?>"> <?php echo $categoryArr[$i]["id"] ?></td>
                                    <td class="disabled_<?php echo $categoryArr[$i]["active"] ?>"> <?php echo $categoryArr[$i]["category_name"] ?></td>
                                    <td class="alignRight">
                                        <button class="data_edit_button" id="editCategory_<?php echo $categoryArr[$i]["id"] ?>">Bearbeiten</button>
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
                    <h4>Kategorie Hinzufügen</h4>
                    <div class="admin_data_side_spacer">
                        <form id="addCategory" action="includes/categoryManager_inc.php" method="post">
                            <label for="createname">Kategorie Name</label><input required type="text" name="createname" id="createname" placeholder="Name">
                        </form>
                        <div class="admin_data_submit_button">
                            <button form="addCategory" type="submit" name="saveCategoryNew">Hinzufügen</button>
                        </div>
                    </div>
                </div>
                <div id="editData" class="admin_data_container">
                    <h4>Kategorie Bearbeiten</h4>
                    <div class="admin_data_side_spacer">
                        <form id="editCategories" action="includes/categoryManager_inc.php" method="post">
                            <div class="data_Double_Container">
                                <div class="data_double_label">
                                    <label for="editcategory">Kategorie</label><select required id="editcategory" name="editcategory">
                                        <option disabled selected hidden value="">Kategorie Wählen</option>
                                        <?php
                                        for ($i = 0; $i < count($allCategories); $i++) {
                                            ?>
                                            <option value="<?php echo $allCategories[$i]["id"] ?>"><?php echo $allCategories[$i]["category_name"] ?></option>
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
                            <label for="editname">Kategorie Name</label><input required type="text" name="editname" id="editname" placeholder="Name">
                        </form>
                        <div class="admin_data_submit_button">
                            <button form="editCategories" type="submit" name="saveCategoryEdit">Speichern</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="JS/adminForms.js"></script>
<script src="JS/adminCategories.js"></script>
</body>
</html>

<?php
include_once "admin_footer.php";
?>
