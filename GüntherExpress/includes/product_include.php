
<?php
require_once 'includes/sale_function.php';

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
    if(onSale($conn,$productID)){
        $newPrice=updatePrice($conn,$productID);
        
    }else{
            $newPrice = "";   
    }

    if(onSale($conn,$productID)){
        echo 
    
        '<h2>'  .$name.  '</h2>
        <div>'  .$description.  '</div> <br>
        <div>Alter Preis: '  .$price.  '  -->   NEUER PREIS: '.$newPrice.' Euro</div>
        <img src='  .$image.'> <br>';
    }else{
        echo 
    
        '<h2>'  .$name.  '</h2>
        <div>'  .$description.  '</div> <br>
        <div>'  .$price.  'Euro</div>
        <img src='  .$image.'> <br>';
    }
    

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