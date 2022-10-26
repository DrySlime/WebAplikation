<?php
include 'includes/dbh_include.php';


// Gesendete Daten
$userName = $_POST['userID'];
$productId = $_POST['pID'];
$productName = $_POST['pName'];
$quantaty = $_POST['quantaty'];
$image = $_POST['image'];



$userId = getUserId($conn, $userName);
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

//Username wird in UserId umgewandelt
function getUserId($conn, $userName){

    $sql = "SELECT * FROM site_user WHERE user_uid = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$userName,);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($resultData)["id"];
}



?>


<h2>Folgender Gegenstand wurde <?php echo $quantaty;?> mal in den Warenkorb gelegt:</h2>

<h2> <?php echo $productName ?> </h2>
<img src=<?php echo $image;?>> <br>

