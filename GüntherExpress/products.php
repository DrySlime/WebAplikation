<!DOCTYPE html>
<html lang="de">

<?php
include_once 'header.php';
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
        <h1>Schokolade</h1>
        <img src="img/cadbury.png" alt="">
    </div>
    <div class="searchbar_wrapper">
        <form action="#">
            <div class="searchbar_container">
                <input type="text" name="search" id="search" placeholder="Suchen" required>
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
                        <h4><?php echo $value ?></h4><?php } ?>
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
                <div class="product_container">
                    <div class="product_img">
                        <img src="img/macaronProduct.png">
                    </div>
                    <div class="product_description">
                        <h2>Kanker</h2>
                        <h4>420.69€</h4>
                    </div>
                    <div class="product_add_to_cart">
                        <span class="material-symbols-outlined">local_mall</span>
                    </div>
                </div>
                <div class="product_container">
                    <div class="product_img">
                        <img src="img/macaronProduct.png">
                    </div>
                    <div class="product_description">
                        <h2>Kanker</h2>
                        <h4>420.69€</h4>
                    </div>
                    <div class="product_add_to_cart">
                        <span class="material-symbols-outlined">local_mall</span>
                    </div>
                </div>
                <div class="product_container">
                    <div class="product_img">
                        <img src="img/macaronProduct.png">
                    </div>
                    <div class="product_description">
                        <h2>Kanker</h2>
                        <h4>420.69€</h4>
                    </div>
                    <div class="product_add_to_cart">
                        <span class="material-symbols-outlined">local_mall</span>
                    </div>
                </div>
                <div class="product_container">
                    <div class="product_img">
                        <img src="img/macaronProduct.png">
                    </div>
                    <div class="product_description">
                        <h2>Kanker</h2>
                        <h4>420.69€</h4>
                    </div>
                    <div class="product_add_to_cart">
                        <span class="material-symbols-outlined">local_mall</span>
                    </div>
                </div>
                <div class="product_container">
                    <div class="product_img">
                        <img src="img/macaronProduct.png">
                    </div>
                    <div class="product_description">
                        <h2>Kanker</h2>
                        <h4>420.69€</h4>
                    </div>
                    <div class="product_add_to_cart">
                        <span class="material-symbols-outlined">local_mall</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php
include_once 'footer.php';
?>
