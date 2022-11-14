
<?php


//Produktdaten werden aus der Datenbank aufgerufen
function getProductData($conn, $productID){

    $sql = "SELECT * FROM product WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$productID,);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($resultData);
}


function showProduct($conn, $productID){

    $productData = getProductData($conn, $productID);

    $name = $productData["product_name"];
    $description = $productData["description"];
    $price = $productData["price"];
    

    echo 
    '
    <h2 class= '.'product-headline'.'>'  .$name.  '</h2>
    <p class= '.'product-description'.'>'  .$description.  '</p> <br>
    <div class= '.'product-price'.'>'  .$price.  ' Euro</div>
    ';

}

function getSumPrice($conn, $productID, $userID){

    $singlePrice = getProductData($conn, $productID)["price"];
    
    $sql = "SELECT * FROM shopping_cart WHERE user_id = ? AND product_id = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"ss",$userID, $productID,);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $quantaty = mysqli_fetch_assoc($resultData)["qty"];

    return $singlePrice*$quantaty;
    
}

function getShoppingCartSum($conn, $userID){

    $items = getShoppingCartItems($conn, $userID);
    $sum = 0;

    while ($row = $items->fetch_assoc()) {
        $sum = $sum + (getProductData($conn, $row["product_id"])["price"] * $row["qty"]);
    }

    return $sum;

}

function showShoppingCartProduct($conn, $productID, $userID){

    $productData = getProductData($conn, $productID);

    $name = $productData["product_name"];
    $price = $productData["price"];
    $sumprice = getSumPrice($conn, $productID, $userID);

    echo 
    '
    <h2 class= '.'product-headline'.'>'  .$name.  '</h2>
    <p class= '.'product-price'.'>'  .$price.  ' Euro</p>
    <div class= '.'product-sum-price'.'>'  .$sumprice.  ' Euro</div>
    ';

}

function showShoppingCartImage($conn, $productID){
    $productData = getProductData($conn, $productID);
    $image = $productData["product_image"];

    echo 
    '
    <a  href='.'product.php?'.'id='.''.$productData["id"].'> <img class='.'image'.' src='.$image.''.'> </a> <br>
    ';
}

function showProductImage($conn, $productID){
    $productData = getProductData($conn, $productID);
    $image = $productData["product_image"];

    echo 
    '<div class= '.'product-left-side'.'>
    <img class= '.'product-image'.' src='  .$image.'> <br>
    </div>';
}

function getShoppingCartItems($conn, $userId){
    $sql = "SELECT * FROM shopping_cart WHERE user_id = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$userId,);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
}

?>