<!DOCTYPE html>
<html lang="de">

<?php
include_once 'header.php';
include_once 'hero.php';
?>

<head>
    <link rel="stylesheet" href="CSS/index.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
    <title>The Confectioner</title>
</head>

<body>
<div class="newitems">
    <div class="newitems_header">
        <h1>Neuheiten</h1>
        <h4>Schau was beim Confectioner neu eingetroffen ist!</h4>
    </div>
    <div class="swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="image_wrapper">
                    <img src="img/macaronProduct.png">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="image_wrapper">
                    <img src="img/macaronProduct.png">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="image_wrapper">
                    <img src="img/macaronProduct.png">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="image_wrapper">
                    <img src="img/macaronProduct.png">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="image_wrapper">
                    <img src="img/macaronProduct.png">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="image_wrapper">
                    <img src="img/macaronProduct.png">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="image_wrapper">
                    <img src="img/macaronProduct.png">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="image_wrapper">
                    <img src="img/macaronProduct.png">
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
</div>

<div class="bestsellers">
    <div class="bestsellers_header">
        <h1>Bestseller</h1>
        <h4>Hol Dir die beliebtesten Schokoladen unserer Kunden!</h4>
    </div>
    <div class="swiper">
        <div class="swiper-wrapper">
            <?php
                require_once "includes/review_functions.php";

                $arr=getBestRatedProducts($conn,9);
                for ($i=0;$i<count($arr);$i++){
                    echo"
                        <div class='swiper-slide'>
                            <div class='image_wrapper'>
                                <img src=".getImage($conn,$arr[$i]).">
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