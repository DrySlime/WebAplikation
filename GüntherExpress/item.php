<!DOCTYPE html>
<html lang="en">

<?php
include_once 'header.php';
include_once "includes/item_function.php";
include_once "includes/functions_include.php";
include_once  "includes/review_functions.php";
global $conn;

$id=$_GET["id"];
$product=getAllFromProductID($conn, $id);
$categoryName= convertIdToCategoryName($conn,$product[0]["product_category_id"]);
$moreProducts= getAllFromCategory($conn,$categoryName, 10);
$stars=getAvrgRating($conn,$product[0]["id"]);

?>

<head>
    <link rel="stylesheet" href="CSS/item.css">
    <link rel="stylesheet" href="CSS/swiper.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
    <title></title>
</head>

<body>
<div class="items_header_wrapper">
    <div class="items_page_header">
        <h1><?php echo $categoryName ?></h1>
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
</div>
<div class="item_wrapper">
    <div class="item_section_left">
        <div class="item_image_container">
            <img src="<?php echo $product[0]["product_image"] ?>" alt="" >
        </div>
    </div>
    <div class="item_section_right">
        <div class="item_data_wrapper">
            <div class="item_data_container">
                <div class="item_data_category">
                    <h4><?php echo $categoryName ?></h4>
                </div>
                <div class="item_data_name">
                    <h3><?php echo $product[0]["product_name"] ?></h3>
                </div>
                <div class="item_data_rating">
                    <h4>Bewertungen</h4>

                    <div class="item_rating_stars">
                        <?php
                            for($i=0;$i<5;$i++){
                                if($i<round($stars)){
                                    echo '<span class="material-symbols-outlined checked" id="star'.$i.'">star</span>';
                                }else{
                                    echo '<span class="material-symbols-outlined" id="star'.$i.'">star</span>';
                                }
                            }
                            echo "<span> ".$stars." Sterne </span>";
                        ?>

                    </div>
                </div>
                <div class="item_data_description">
                    <p><?php echo $product[0]["description"] ?></p>
                </div>
                <div class="item_data_price">
                    <h4><?php echo $product[0]["price"] ?>€</h4>
                </div>
                <div class="item_data_settings">
                    <div class="item_amount_settings">
                        <button class="buttonAmount" id="decreaseAmount" onclick="removeFromAmount()"><span class="material-icons md48">remove_circle</span></button>
                        <h4 id="amount">1</h4>
                        <button class="buttonAmount" id="increaseAmount" onclick="addToAmount()"><span class="material-icons md48">add_circle</span></button>
                    </div>

                    <button class="item_add_settings" id="addToCart" onclick="addToCart()">
                            <h4>Hinzufügen</h4>
                            <i class="material-symbols-outlined" style="pointer-events: none;">shopping_cart</i>
                    </button>    

                        <script> 

                            function addToCart(){
                                var amount = getSelectValue();
                                window.location = "shopping_cart_insert.php?pID=" + "<?php echo $product[0]['id'] ?>" + "&quantaty=" + amount;
                            }
                            
                            function getSelectValue(){
                               return document.getElementById("amount").innerHTML; 
                            }

                            function removeFromAmount(){
                                if(Number(document.getElementById("amount").innerHTML) != 0){
                                    document.getElementById("amount").innerHTML = Number(document.getElementById("amount").innerHTML) - 1;
                                }
                            }

                            function addToAmount(){
                                if(Number(document.getElementById("amount").innerHTML) < <?php echo $product[0]['qty_in_stock'] ?>)
                                document.getElementById("amount").innerHTML = Number(document.getElementById("amount").innerHTML) + 1;
                                
                            }
                        </script>

                        
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="related_items_wrapper">
    <div class="related_items_header">
        <h1>Ähnliche Artikel</h1>
        <h4>Wie wäre es hiermit?</h4>
    </div>
    <div class="swiper">
        <div class="swiper-wrapper">
            <?php
             for($i=0;$i<count($moreProducts);$i++){
                 echo "
                    <div class='swiper-slide'>
                        <div class='image_wrapper'>
                            <a href='item.php?id=".$moreProducts[$i]["id"]."'><img src=".$moreProducts[$i]["product_image"]." alt=''></a>
                        </div>
                    </div>
                 ";

             }
            ?>

        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
</div>

<script type="module">
    import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.esm.browser.min.js'

    const swiper = new Swiper('.swiper', {
        spaceBetween: 25,
        slidesPerView: 5,
        grabCursor: true,
        loop: true,
        freeMode: true,
        autoplay: {
            delay: 3000,
            pauseOnMouseEnter: true,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            type: 'bullets',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>
</body>

</html>

<?php
include_once 'footer.php';
?>