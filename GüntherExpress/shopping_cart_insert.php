<?php
include_once 'header.php';
include 'includes/dbh_include.php';
include 'includes/functions_include.php';


$userName;

if(isset($_SESSION['useruid'])){
    $userName = $_SESSION['useruid'];
}else{
    echo  "<p>Sie müssen sich erst <a href="."login.php".">einlogen!</a></p>";
    exit();
}


$productId = $_POST['pID'];
$productName = $_POST['pName'];
$quantaty = $_POST['quantaty'];
$image = $_POST['image'];



$userId = getUserIdFromUserName($conn, $userName);
insert_into_cart($conn, $userId, $productId, $quantaty);


// Item wird in den Einkaufswagen gelegt
function insert_into_cart($conn, $userId, $productId, $quantaty){


    
    $sql = "SELECT qty FROM shopping_cart WHERE user_id = ? AND product_id = ?";
    $stmt = mysqli_stmt_init($conn);
    
    
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"ss",$userId,$productId,);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $data =  mysqli_fetch_assoc($resultData);
    mysqli_stmt_close($stmt);

    if($data == null){

        $sql = "INSERT INTO shopping_cart (user_id, product_id, qty) VALUES (?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        
        
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"sss",$userId,$productId,$quantaty);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }else{
        $sql = "UPDATE shopping_cart SET qty = ? WHERE user_id = ? AND product_id = ? ";
        $stmt = mysqli_stmt_init($conn);
        
        $newQuantaty = ($quantaty+$data["qty"]);
        
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"sss",$newQuantaty , $userId, $productId,);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    
}





?>


<h2>Folgender Gegenstand wurde <?php echo $quantaty;?> mal in den Warenkorb gelegt:</h2>

<h2> <?php echo $productName ?> </h2>
<img src=<?php echo $image;?>> <br>

<form action="index.php">
    <input type="submit" value="Weiter einkaufen">
</form>

<form action="shopping_cart.php">
    <input type="submit" value="Zum Einkaufswagen">
</form>