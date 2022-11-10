<!DOCTYPE html>
<html lang="de">

<?php
include_once 'header.php';
include_once 'hero.php';
session_start();
$_SESSION['useruid'] = 1234;
?>

<head>
    <script src="JS/index.js"></script>
    <link rel="stylesheet" href="CSS/index.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <title>The Confectioner</title>
</head>

<body">


    <?php $item=getRandomItems($conn, 10); ?>
    <div class="item_border" id="item_border_1">
        <a href="javascript:void(0);">
            <div class="scroll_left_button" id="scroll_left_button_1">
                <div class="arrow_left"><img src="img/arrow_left.png"></div>
            </div>
        </a>
        <a href="javascript:void(0);">
            <div class="scroll_right_button" id="scroll_right_button_1">
                <div class="arrow_right">
                    <img src="img/arrow_right.png">
                </div>
            </div>
        </a>
        <div class="category_item_line category_item_line_1" id="category_item_line_1">
            <h1>Vorschläge</h1>
            <ul>



            <?php
                for($i=0;$i<count($item);$i++){
                    echo '
                    
                        <li>
                        <a href="product.php?id='.$item[$i][0].'">
                        <div class="product_image">
                            <img src='.$item[$i][3].' alt="'.$item[$i][1].'.png" >
                        </div></a>';
                }
            ?>


            </ul>
        </div>
    </div>';

    <?php showRandomCategoriesAndItems($conn,2,2); ?>

    <div class="bestsellers">
        <div class="bestsellers_header">
            <h1>
                Bestseller
            </h1>
            <h4>
                Hol Dir die beliebtesten Knabbereien unserer Kunden!
            </h4>
        </div>
        <div class="bestsellers_scroller">

        </div>
    </div>

    <div class="newitems">
        <div class="newitems_header">
            <h1>
                Neuheiten
            </h1>
            <h4>
                Schau was beim Confectioner neu eingetroffen ist!
            </h4>
        </div>
        <div class="newitems_scroller">
        </div>
    </div>
</body>

</html>

<?php
include_once 'footer.php';
?>