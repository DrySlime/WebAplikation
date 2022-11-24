<?php
function getAllOrderedProducts($conn)
{
    $sql = "SELECT * FROM shop_order ORDER BY order_date DESC ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
//    mysqli_stmt_prepare($stmt, $sql);
//    mysqli_stmt_bind_param($stmt, "s", $amount);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        $array["order_id"] = $row["id"];
        $array["siteuser_id"] = $row["siteuser_id"];
        $array["order_date"] = $row["order_date"];
        $array["payment_method_id"] = $row["payment_method_id"];
        $array["shipping_address_id"] = $row["shipping_address_id"];
        $array["shipping_method_id"] = $row["shipping_method_id"];
        $array["order_total"] = $row["order_total"];
        $array["order_status_id"] = $row["order_status_id"];

        $allItems[] = $array;
        unset($array);
    }

    return $allItems;
}
function getAllOrderedProductsFromUserID($conn, $userid)
{
    $allItems=null;
    $sql = "SELECT * FROM shop_order WHERE siteuser_id=? ORDER BY order_date DESC ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        $array["order_id"] = $row["id"];
        $array["siteuser_id"] = $row["siteuser_id"];
        $array["order_date"] = $row["order_date"];
        $array["payment_method_id"] = $row["payment_method_id"];
        $array["shipping_address_id"] = $row["shipping_address_id"];
        $array["shipping_method_id"] = $row["shipping_method_id"];
        $array["order_total"] = $row["order_total"];
        $array["order_status_id"] = $row["order_status_id"];

        $allItems[] = $array;
        unset($array);

    }

    return $allItems;

}
function getUsername($conn,$userID){
    $sql = "SELECT user_uid FROM site_user WHERE id=? ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $userID);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($resultData);
    $username = $row["user_uid"];



    return $username;
}
function getPaymentMethod($conn,$paymentmethodID){
    $sql = "SELECT value FROM payment_type WHERE id=? ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $paymentmethodID);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($resultData);
    $paymentmethod = $row["value"];



    return $paymentmethod;
}
function getShippingAdress($conn,$id){
    $sql = "SELECT * FROM address WHERE id=? ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($resultData);
    $shippingadress = $row["address_line1"]." ".$row["street_number"].", ".$row["postal_code"].", ".$row["city"];



    return $shippingadress;
}
function getShippingMethod($conn,$id){
    $sql = "SELECT shipping_name FROM shipping_method WHERE id=? ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($resultData);
    $shippingname = $row["shipping_name"];



    return $shippingname;
}
function getOrderStatus($conn,$id){
    $sql = "SELECT status FROM order_status WHERE id=? ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($resultData);
    $shippingname = $row["status"];



    return $shippingname;
}
function getOrderLine($conn,$id){
    $sql = "SELECT product_item_id, qty, price FROM order_line WHERE order_id=? ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($resultData)){
        $product["product_item_id"] = $row["product_item_id"];
        $product["qty"] = $row["qty"];
        $product["price"] = $row["price"];
        $productArr[]=$product;
        unset($product);

    }


    return $productArr;
}
function getProductName($conn,$id){
    $sql = "SELECT product_name FROM product WHERE id=? ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($resultData);
    $productname = $row["product_name"];



    return $productname;
}
function getUserID($conn,$username){

    $sql = "SELECT id FROM site_user WHERE upper(user_uid)=upper(?) ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($resultData);
    $id = $row["id"];




    return $id;
}

function orderlineToTEXT($conn,$order){
    $string ="";
     for($k=0;$k<count($order);$k++){
         $so= $order[$k]["qty"]."x ".getProductName($conn,$order[$k]["product_item_id"])." -> ".$order[$k]["price"]." Euro <br>";
         $string=$string.$so;
     }

     return $string;
}