<!DOCTYPE html>
<?php
    include_once "header.php";
    require_once "includes/review_functions.php";
    require_once 'includes/dbh_include.php';
    require_once 'includes/functions_include.php';
?>
<html lang="ger">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deine Bewertungen</title>
</head>
<?php
    $productID = $_GET["productID"];
    $orderlineID = $_GET["orderlineID"]
?> 
<body>
    <!-- <img src= alt=""> -->
    <?php echo "<img src=".getImgaeFromID($conn,$productID)." >";?>
    <div name="rating_shell">
        <form action="includes/review_include.php" method="post">
            <input type="hidden" name="productID" value=<?php $productID ?> />
            <input type="hidden" name="orderlineID" value=<?php $orderlineID ?> />
            <div class="rating">
                <input id="star5" name="star" type="radio" value="1" class="radio-btn hide" />
                <label for="star5">☆</label>
                <input id="star4" name="star" type="radio" value="2" class="radio-btn hide" />
                <label for="star4">☆</label>
                <input id="star3" name="star" type="radio" value="3" class="radio-btn hide" />
                <label for="star3">☆</label>
                <input id="star2" name="star" type="radio" value="4" class="radio-btn hide" />
                <label for="star2">☆</label>
                <input id="star1" name="star" type="radio" value="5" class="radio-btn hide" />
                <label for="star1">☆</label>
                <div class="clear"></div>
            </div>
            <textarea name="Text1" cols="40" rows="5" placeholder=""></textarea><br>
            <!-- TODO: es muss unterschiedenwerden zwischen einer bewertung neu schreiben und eine bewertung zu aktualisieren. -->
            <button type="submit" name="review_button" >Review</button><br>
        </form>
    </div>
</body>
</html>
<?php
    include_once "footer.php";
?>