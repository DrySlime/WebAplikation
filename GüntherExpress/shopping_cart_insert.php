<?php
include 'includes/dbh_include.php';
include 'includes/functions_include.php';


// Gesendete Daten
$userName = $_POST['userID'];
$productId = $_POST['pID'];
$productName = $_POST['pName'];
$quantaty = $_POST['quantaty'];
$image = $_POST['image'];



$userId = getUserIdFromUserName($conn, $userName);
insert_into_cart($conn, $userId, $productId, $quantaty);


// Item wird in den Einkaufswagen gelegt
function insert_into_cart($conn, $userId, $productId, $quantaty){

    $sql = "INSERT INTO shopping_cart (user_id, product_id, qty) VALUES (?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    
    
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"sss",$userId,$productId,$quantaty);
    mysqli_stmt_execute($stmt);
    
    mysqli_stmt_close($stmt);
}





?>


<h2>Folgender Gegenstand wurde <?php echo $quantaty;?> mal in den Warenkorb gelegt:</h2>

<h2> <?php echo $productName ?> </h2>
<img src=<?php echo $image;?>> <br>

<form action="index.php">
    <input type="button" value="Weiter einkaufen">
</form>

<form action="shopping_cart.php">
    <input type="button" value="Zum Einkaufswagen">
</form>