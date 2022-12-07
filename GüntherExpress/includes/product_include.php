
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
    $image = $productData["product_image"];

    echo 
    
    '<h2>'  .$name.  '</h2>
     <div>'  .$description.  '</div> <br>
     <div>'  .$price.  'Euro</div>
     <img src='  .$image.' alt="imigi"> <br>';

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