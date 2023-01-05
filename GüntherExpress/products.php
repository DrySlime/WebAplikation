<!DOCTYPE html>
<html lang="de">

<?php
include_once 'header.php';
include_once 'includes/products_function.php';
global $conn;
?>

<head>
    <link rel="stylesheet" href="CSS/searchbar_header.css">
    <link rel="stylesheet" href="CSS/products.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
    <title></title>
</head>

<?php
if (isset($_POST["priceSearch"])) {
    $name = $_GET["name"];
    $min = $_POST["min"];
    $max = $_POST["max"];
    if (!is_numeric($min) || $min < 0) {
        $min = 0;
    }
    if (!is_numeric($max)) {
        $max = 9999;
    }
    if ($min > $max) {
        $error = "Eingabe überprufen!!";
        echo "<body onload='scrollToElement()'></body>";
        goto next;
    }
    $items = searchByPrice($conn, $name, $min, $max);
} elseif (!isset($_POST["search"])) {
    next:
    $name = $_GET["name"];
    $items = getAllFromCategory($conn, $name, totalAmount($conn, $name));
} else {
    $name = $_POST["search"];
    $items = searchProduct($conn, $_POST["search"]);
}
?>

<body>
<div class="page_header_wrapper">
    <div class="page_page_header">
        <h1><?php echo $name ?></h1>
        <img src="img/cadbury.png" alt="Andre Caputo">
    </div>
    <div class="searchbar_wrapper">
        <form action="products.php" method="post">
            <div class="searchbar_container">
                <label for="search"></label><input type="text" name="search" id="search" placeholder="Suchen" required>
                <button type="submit">Suchen</button>
            </div>
        </form>
    </div>
    <div class="products_content_wrapper">
        <div class="products_sidebar_container">
            <div class="sidebar_header">
                <h1>Produkt Filter</h1>
            </div>
            <div class="sidebar_options">
                <div class="sidebar_options_header">
                    <h4>Kategorien</h4>
                </div>
                <div class="sidebar_options_settings">
                    <?php foreach (getCategoryList($conn) as $key => $value) {
                        if ($value == $name) {
                            echo "
                            <a href='products.php?name=" . $value . "'><h4 style='color: #fc466b'>" . $value . "</h4></a>
                            ";
                        } else {
                            echo "
                          <a href='products.php?name=" . $value . "'><h4>" . $value . "</h4></a>
                        ";
                        }
                    } ?>
                </div>
                <div class="sidebar_options_header">
                    <h4>Preis</h4>
                </div>
                <div class="sidebar_options_settings slider_wrapper" id="search123">
                    <form action="products.php?name=<?php echo $name ?>" method="post">
                        <div class="form_container">
                            <div class="settings_input_container">
                                <label for="min"></label><input type="text" name="min" id="min" placeholder="Min">
                                <h4 class="separator">-</h4>
                                <label for="max"></label><input type="text" name="max" id="max" placeholder="Max">
                                <input type="text" name="priceSearch" value="true" hidden>
                            </div>
                            <div class="settings_button">
                                <button type="submit" name="applyfilter">Anwenden</button>
                            </div>
                            <?php if (isset($error)) {
                                echo "<h3 style='color: #D4045F'>" . $error . "</h3>";
                            } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="products_items">
            <?php
            if ($items != null) {
                ?>
                <div class="products_grid_wrapper">
                    <?php
                    for ($i = 0; $i < count($items); $i++) {
                        echo '
                        <div class="product_container">
                            <div class="product_img">
                                <a href="item.php?id=' . $items[$i]["id"] . '">
                                    <img src=' . $items[$i]["product_image"] . ' width="265px" alt="" height="200px">
                                </a>
                            </div>
                            <div class="product_description">
                                <a href="item.php?id=' . $items[$i]["id"] . '">
                                    <h2>' . $items[$i]["product_name"] . '</h2>
                                </a>
                                <h4>' . $items[$i]["price"] . ' €</h4>
                            </div>
                            <div class="product_add_to_cart" id="' . $items[$i]["id"] . '" onclick="add(this.id)">
                                <span class="material-symbols-outlined">local_mall</span>
                            </div>
                        </div>
                    ';
                    }
                    ?>
                    <script>
                        function add(id) {
                            window.location = "cart_added.php?pID=" + id + "&quantity=1";
                        }
                    </script>
                </div>
                <?php
            } else {
                ?>
                <div class="products_no_item_wrapper">
                    <img src="img/backdrop.png" alt="Andre Caputo">
                    <h4>The Confectioner kennt diesen Artikel leider nicht...</h4>
                    <p>Vielleicht findest du aber etwas anderes leckeres!</p>
                </div>
            <?php }
            ?>
        </div>
    </div>
</div>
</body>
<script src="JS/products.js"></script>
</html>

<?php
include_once 'footer.php';
?>