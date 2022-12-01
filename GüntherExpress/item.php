<!DOCTYPE html>
<html lang="en">

<?php
include_once 'header.php';
?>

<head>
    <link rel="stylesheet" href="CSS/item.css">
    <link rel="stylesheet" href="CSS/swiper.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
</head>

<body>
<div class="items_header_wrapper">
    <div class="items_page_header">
        <h1>UHHHHHHHHHHH</h1>
        <img src="img/cadbury.png">
    </div>
    <div class="searchbar_wrapper">
        <form action="#">
            <div class="searchbar_container">
                <input type="text" name="search" id="search" placeholder="Suchen" required>
                <button type="submit">Suchen</button>
            </div>
        </form>
    </div>
</div>
<div class="item_wrapper">
    <div class="item_section_left">
        <div class="item_image_container">
            <img src="img/oreo.png">
        </div>
    </div>
    <div class="item_section_right">
        <div class="item_data_wrapper">
            <div class="item_data_container">
                <div class="item_data_category">
                    <h4>Schokolade</h4>
                </div>
                <div class="item_data_name">
                    <h3>Kanker</h3>
                </div>
                <div class="item_data_rating">
                    <h4>Bewertungen</h4>
                    <div class="item_rating_stars">
                        <span class="material-symbols-outlined checked" id="star1">star</span>
                        <span class="material-symbols-outlined checked" id="star2">star</span>
                        <span class="material-symbols-outlined checked" id="star3">star</span>
                        <span class="material-symbols-outlined" id="star4">star</span>
                        <span class="material-symbols-outlined" id="star5">star</span>
                    </div>
                </div>
                <div class="item_data_description">
                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt
                        ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo
                        dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor
                        sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                        invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                </div>
                <div class="item_data_price">
                    <h4>420.69 €</h4>
                </div>
                <div class="item_data_settings">
                    <div class="item_amount_settings">
                        <button class="buttonAmount" id="decreaseAmount" onclick="removeFromAmount()"><span class="material-icons md48">remove_circle</span></button>
                        <h4>1</h4>
                        <button class="buttonAmount" id="increaseAmount" onclick="addToAmount()"><span class="material-icons md48">add_circle</span></button>
                    </div>
                    <div class="item_add_settings">
                        <h4>Hinzufügen</h4>
                        <button class="buttonAddCart" id="addToCart" onclick="addToCart()"><i
                                    class="material-symbols-outlined" style="pointer-events: none;">shopping_cart</i>
                        </button>
                    </div>
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
            <div class='swiper-slide'>
                <div class='image_wrapper'>
                    <a href=item.php?id=""><img src="img/oreo.png"></a>
                </div>
            </div>
            <div class='swiper-slide'>
                <div class='image_wrapper'>
                    <a href=item.php?id=""><img src="img/oreo.png"></a>
                </div>
            </div>
            <div class='swiper-slide'>
                <div class='image_wrapper'>
                    <a href=item.php?id=""><img src="img/oreo.png"></a>
                </div>
            </div>
            <div class='swiper-slide'>
                <div class='image_wrapper'>
                    <a href=item.php?id=""><img src="img/oreo.png"></a>
                </div>
            </div>
            <div class='swiper-slide'>
                <div class='image_wrapper'>
                    <a href=item.php?id=""><img src="img/oreo.png"></a>
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