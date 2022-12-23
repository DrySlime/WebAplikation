<!DOCTYPE html>
<html lang="de">

<?php
include_once 'header.php';
include_once 'includes/products_function.php';
global $conn;
?>


<head>
    <link rel="stylesheet" href="CSS/products.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
    <title></title>
</head>


<?php
if(isset($_POST["priceSearch"])){

    $name=$_GET["name"];
    $min=$_POST["min"];
    $max=$_POST["max"];
    if($min>$max){
        $error="Eingabe überprufen!!";
        echo "<body onload='scrollToElement()'></body>";
        goto next;
    }
    $items= searchByPrice($conn,$name,$min,$max);
}elseif (!isset($_POST["search"])) {

    next:
    $name = $_GET["name"];
    $items = getAllFromCategory($conn, $name, totalAmount($conn, $name));


} else {
    $name = $_POST["search"];
    $items = searchProduct($conn, $_POST["search"]);
}


?>


<body>
<div class="products_page_wrapper">
    <div class="products_page_header">
        <h1><?php echo $name ?></h1>
        <img src="img/cadbury.png" alt="">
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
                    <?php foreach (getCategoryList($conn) as $key => $value) { ?>
                        <?php echo "
                          <a href='products.php?name=" . $value . "'><h4>" . $value . "</h4></a>
                        " ?><?php } ?>
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
                            <?php if(isset($error)){echo "<h3 style='color: #D4045F'>".$error."</h3>";} ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="products_items">
            <div class="products_grid_wrapper">
                <?php
                if ($items != null) {
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
                            <div class="product_add_to_cart" id="'. $items[$i]["id"] .'" onclick="add(this.id)">
                                <span class="material-symbols-outlined">local_mall</span>
                            </div>
                        </div>
                    ';
                    }
                } else {
                    echo "<h3 style='color: #fc466b'>Dieses produkt ist nicht bekannt!</h3>";

                }

                ?>
                <script>
                    function add(id){
                        window.location = "shopping_cart_insert.php?pID="+id+"&quantaty=1";
                    }
                </script>
            </div>
        </div>
    </div>
</div>
</body>
<script src="JS/products.js"></script>
</html>

<?php
include_once 'footer.php';
?>