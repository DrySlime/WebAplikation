<!DOCTYPE html>
<html lang="en">
<?php
    include_once 'header.php';
    require_once 'includes/dbh_include.php';
    require_once 'includes/functions_include.php';
    require_once 'includes/review_functions.php';
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitte Bewerten</title>
</head>
<?php
    $uid=$_SESSION["userid"];
    # wir benötigen eine funktion die alle bewertbaren produkte  in einem array wiedergibt   
    # im array muss die die orderline id sowie die product id gespeichert sein
    $array = getReviewableProducts($conn,$uid);
?>

<?php
    if($array!=null){
        for($i=0;$i<count($array);$i++){
            $orderlineID=$array[$i]["orderlineID"];
            $productID=$array[$i]["productID"];
            echo
                "<div name='product_shell'>
                    <a href='review.php?orderlineID=".$orderlineID."&productID=".$productID."'>
                        <h1>Bitte bewerten Sie : ".getProductnameFromID($conn,$productID)."</h1>
                        <img src=".getImageFromID($conn,$productID)." name='productPic' alt='PRODUKT'>
                    </a>
                </div>";
        }
    }else{
        echo "Sie haben keine bewertbaren Produkte, kaufen Sie doch gerne was ein!";
    }
    
?>

</html>
<?php
    include_once "footer.php";    
?>
