<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="CSS/hero.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <title>The Confectioner</title>
</head>

<body>
    <div class="hero">
        <div class="hero_left">
            <div class="hero_text">
                <h1>
                    You're never too old for Chocolates!
                </h1>
                <h4>
                 The Confectioner bietet Dir die größte Auswahl an allerlei Süßigkeiten aus jeder Ecke der Welt. Du willst was neues probieren? Wie wärs mit:
                </h4>
            </div>
            <div class="hero_search">
                <form action="#">
                    <div class="searchbar_container">
                    <input type="text" name="search" id="search" placeholder= <?php echo getRandomProductName($conn)?> required>
                        <button type="submit">Suchen</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="hero_right">
            <img src="/img/backdrop.png" alt="Andre Caputo" style="object-fit: cover; object-position: 100% 0;">
        </div>
    </div>
</body>

</html>


<?php
include 'includes/dbh_include.php';
function getRandomProductName($conn){
    $sql = "SELECT * FROM product WHERE qty_in_stock > ?;";
    $stmt = mysqli_stmt_init($conn);

    $a = 0;

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$a,);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $productArray = array();

    while ($row = $resultData->fetch_assoc()) {
        array_push($productArray, $row["product_name"] );
    }
    
    return json_encode($productArray[rand(0, count($productArray)-1)]);
}
?>