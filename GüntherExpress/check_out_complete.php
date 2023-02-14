<head>
        <link rel="stylesheet" href="../css/check_out.css">
</head>


<?php 

include_once 'header.php';
include_once 'includes/dbh_include.php';
include_once 'includes/functions_include.php';
include_once 'includes/product_include.php';
include_once 'includes/check_out_include.php';

$userId = getUserIdFromUserName($conn, $_SESSION['useruid']);



checkItemQty($conn, $userId);
doOrder($conn, $userId);
fill_order_line($conn, $userId);
clearShoppingCart($conn, $userId);

header("Location: index.php");



function checkItemQty($conn, $userId){

    $items = getShoppingCartItems($conn, $userId);

    while ($row = $items->fetch_assoc()) {

        $sql = "SELECT * FROM product WHERE id = ?";
        $stmt = mysqli_stmt_init($conn);

        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"s",$row["product_id"]);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        $data = mysqli_fetch_assoc($resultData);
        mysqli_stmt_close($stmt);

        if($data["qty_in_stock"] < $row["qty"]){
            echo "<p class=\"error\">Folgendes Produkt ist leider nicht mehr verfügbar oder nicht in der gewünschten Menge verfügbar: <a  href="."product.php?"."id=".$row["product_id"].">".getProductData($conn, $row['product_id'])["product_name"]." </a> </p>";
            $sql = "DELETE FROM shopping_cart WHERE product_id = ?";
            $stmt = mysqli_stmt_init($conn);
            
            
            mysqli_stmt_prepare($stmt,$sql);
            mysqli_stmt_bind_param($stmt,"s",$row['product_id']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            exit();
        }
        
    }
}

function doOrder($conn, $userId){


    $addressId = $_GET["addressId"];
    $paymentId = $_GET["paymentId"];
    $shippingId = $_GET["shippingId"];
    date_default_timezone_set('Europe/Berlin');
    $date = date("Y-m-d H:i:s");
    $sum = getShoppingCartSum($conn, $userId) + getShippingPrice($conn, $_GET["shippingId"]);

    $sql = "INSERT INTO shop_order (user_id, order_date, payment_method_id, shipping_address_id, shipping_method_id, order_total, order_status_id) VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    
    $keineAhnungWarumDasNötigIst = 1;
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"sssssss",$userId,$date,$paymentId, $addressId, $shippingId, $sum, $keineAhnungWarumDasNötigIst);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function fill_order_line($conn, $userId){
    $orderId = mysqli_insert_id($conn);
    $items = getShoppingCartItems($conn, $userId);

    while ($row = $items->fetch_assoc()) {

        $sql = "INSERT INTO order_line (product_item_id, order_id, qty, price)VALUES (?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"ssss",$row["product_id"],$orderId,$row["qty"], getProductData($conn, $row["product_id"])["price"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        updateStock($conn, $row["product_id"], $row["qty"]);

    }
}

function updateStock($conn, $productId, $buyQty){

    $sql = "SELECT * FROM product WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$productId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($resultData);
    mysqli_stmt_close($stmt);

    $sql = "UPDATE product SET qty_in_stock = ? WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);

    $newStock = ($data["qty_in_stock"]-$buyQty);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"ss",$newStock, $productId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

}

function clearShoppingCart($conn, $userId){
    $sql = "DELETE FROM shopping_cart WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);
    
    
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}


?>


