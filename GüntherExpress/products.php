<!DOCTYPE html>
<html lang="de">

<?php
include_once 'header.php';
include_once 'includes/products_function.php';
?>
<?php
if(!isset($_POST["search"])){
    $name=$_GET["name"];
    $items = getAllFromCategory($conn, $name);

}else{
    $name=$_POST["skrrr"];
    $items = productsSearchbar($conn,$_POST["search"],convertCategoryNameToID($conn, $name));
}


?>

<head>
    <link rel="stylesheet" href="CSS/products.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
</head>

<body>
<div class="products_page_wrapper">
    <div class="products_page_header">
        <h1><?php echo $name ?></h1>
        <img src="img/cadbury.png" alt="">
    </div>
    <div class="searchbar_wrapper">
        <form action="products.php" method="post">
            <div class="searchbar_container">
                <input type="text" name="search" id="search" placeholder="Suchen" required>
                <input type="text" name="skrrr" id="skrrr" value="<?php echo $name ?>" hidden>
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
                    <?php foreach (getCategoryList($conn) as $key => $value) { ?>
                        <?php echo "
                          <a href='products.php?name=" . $value . "'><h4>" . $value . "</h4></a>
                        " ?><?php } ?>
                </div>
                <div class="sidebar_options_header">
                    <h4>Preis</h4>
                </div>
                <div class="sidebar_options_settings slider_wrapper">
                    <form action="" method="post">
                        <div class="form_container">
                            <div class="settings_input_container">
                                <input type="text" name="min" id="min" placeholder="Min">
                                <h4 class="separator">-</h4>
                                <input type="text" name="max" id="max" placeholder="Max">
                            </div>
                            <div class="settings_button">
                                <button type="submit" name="applyfilter">Anwenden</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="products_items">
            <div class="products_grid_wrapper">
                <?php
                if($items!=null){
                    for ($i = 0; $i < count($items); $i++) {
                        echo '
                        <div class="product_container">
                            <div class="product_img">
                            <a href="item.php?id=' . $items[$i]["id"] . '">
                                <img src=' . $items[$i]["product_image"] . ' width="265px" height="200px">
                            </a>
                            </div>
                            <div class="product_description">
                                <a href="item.php?id=' . $items[$i]["id"] . '">
                                    <h2>' . $items[$i]["product_name"] . '</h2>
                                </a>
                                <h4>' . $items[$i]["price"] . ' €</h4>
                            </div>
                            <div class="product_add_to_cart">
                                <span class="material-symbols-outlined">local_mall</span>
                            </div>
                        </div>
                    ';
                    }
                }else{
                    echo "<h3 style='color: #fc466b'>Dieses produkt ist nicht unter ".$name." bekannt!</h3>";

                    $items = getAllFromCategory($conn, $name);

                    for ($i = 0; $i < count($items); $i++) {
                        echo '
                        <div class="product_container">
                            <div class="product_img">
                            <a href="item.php?id=' . $items[$i]["id"] . '">
                                <img src=' . $items[$i]["product_image"] . ' width="265px" height="200px">
                            </a>
                            </div>
                            <div class="product_description">
                                <a href="item.php?id=' . $items[$i]["id"] . '">
                                    <h2>' . $items[$i]["product_name"] . '</h2>
                                </a>
                                <h4>' . $items[$i]["price"] . ' €</h4>
                            </div>
                            <div class="product_add_to_cart">
                                <span class="material-symbols-outlined">local_mall</span>
                            </div>
                        </div>
                    ';
                    }
                }

                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php
include_once 'footer.php';
?>
