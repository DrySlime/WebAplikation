<?php
function getAllOrderedProducts($conn)
    #return an array filled with all data you could get from an order which is ordered descending!
{
    $allItems=null;
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
function getAllUser($conn)
    #return an array filled with all USER data you could get from the Database
{
    $allItems=null;
    $sql = "SELECT * FROM site_user ;";
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
        $array["id"] = $row["id"];
        $array["firstname"] = $row["firstname"];
        $array["lastname"] = $row["lastname"];
        $array["email"] = $row["email"];
        $array["username"] = $row["user_uid"];
        $allItems[] = $array;
        unset($array);
    }

    return $allItems;
}function getAllFromUser($conn,$userid)
    #returns an array with all USER Data from $userid
{
    $allItems=null;
    $sql = "SELECT * FROM site_user WHERE id=?;";
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
        $array["id"] = $row["id"];
        $array["firstname"] = $row["firstname"];
        $array["lastname"] = $row["lastname"];
        $array["email"] = $row["email"];
        $array["username"] = $row["user_uid"];
        $allItems[] = $array;
        unset($array);
    }

    return $allItems;
}
function getAdressFromUserID($conn,$userID){
    #returns an array filled with adress information from a $userid
    $allItems=null;
    $sql = "SELECT * FROM address WHERE id=(SELECT address_id FROM user_address WHERE user_id=?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $userID);
    mysqli_stmt_execute($stmt);
    if($resultData = mysqli_stmt_get_result($stmt)){
        while ($row = mysqli_fetch_assoc($resultData)) {
            $array["street_number"] = $row["street_number"];
            $array["address_line"] = $row["address_line1"];
            $array["city"] = $row["city"];
            $array["postal_code"] = $row["postal_code"];
            $allItems[] = $array;
            unset($array);
        }
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
function getAllOrderStatus($conn){
    $sql = "SELECT * FROM order_status ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($resultData)){
        $status["id"] = $row["id"];
        $status["status"] = $row["status"];
        $statusArr[]=$status;
        unset($product);
    }
    return $statusArr;
}
function getProductName($conn,$id){
    #returns the productname from a productID
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
    #get the userID from a $username

    $sql = "SELECT id FROM site_user WHERE upper(user_uid)=upper(?) ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    if ($resultData = mysqli_stmt_get_result($stmt)){

        if($row = mysqli_fetch_assoc($resultData)){
            $id = $row["id"];
            return $id;
        }

    }

    return null;

}

function orderlineToTEXT($conn,$order){
    #a toString method to properly display order details

    $string ="";
     for($k=0;$k<count($order);$k++){
         $so= $order[$k]["qty"]."x ".getProductName($conn,$order[$k]["product_item_id"])." -> ".$order[$k]["price"]." Euro <br>";
         $string=$string.$so;
     }

     return $string;
}
function getAllCategories($conn,){
    $sql = "SELECT id, category_name, parent_category_id FROM product_category ";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while($row=mysqli_fetch_assoc($resultData)){
        $category["id"]=$row["id"];
        $category["category_name"]= $row["category_name"];
        $category["parent_category_id"]= $row["parent_category_id"];
        $categoryArr[]=$category;
        unset($category);
    }

    mysqli_stmt_close($stmt);
    return $categoryArr;
}
function getAllSales($conn){
    $saleArr=null;
    $sql = "SELECT * FROM promotion ";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while($row=mysqli_fetch_assoc($resultData)){
        $sale["id"]=$row["id"];
        $sale["promotion_name"]= $row["promotion_name"];
        $sale["description"]= $row["description"];
        $sale["discount_rate"]= $row["discount_rate"];
        $sale["start_date"]= $row["star_date"];
        $sale["end_date"]= $row["end_date"];

        $saleArr[]=$sale;
        unset($sale);
    }

    mysqli_stmt_close($stmt);
    return $saleArr;
}

function getAllProducts($conn){
    $productArr=null;
    $sql = "SELECT * FROM products ";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../product_admin.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while($row=mysqli_fetch_assoc($resultData)){
        $product["id"]=$row["id"];
        $product["name"]= $row["name"];
        $product["product_category_id"]= $row["product_category_id"];
        $product["product_image"]= $row["product_image"];
        $product["qty_in_stock"]= $row["qty_in_stock"];
        $product["price"]= $row["price"];
        $product["description"]= $row["description"];
        $product["image"]= $row["image"];

        $productArr[]=$product;
        unset($product);
    }

    mysqli_stmt_close($stmt);
    return $productArr;
}
function getAllShippingMethods($conn){
    $sMethodArr=null;
    $sql = "SELECT * FROM  shipping_method";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../shippingmethod_admin.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while($row=mysqli_fetch_assoc($resultData)){
        $sMethod["id"]=$row["id"];
        $sMethod["shipping_name"]= $row["shipping_name"];
        $sMethod["shipping_price"]= $row["shipping_price"];
        

        $sMethodArr[]=$sMethod;
        unset($sMethod);
    }

    mysqli_stmt_close($stmt);
    return $sMethodArr;
}
function deleteSale($conn, $promotionID){
    $sql = "DELETE FROM promotion WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../sale_admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $promotionID);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../sale_admin.php");

}
function deleteCategory($conn, $categoryID){
    $sql = "DELETE FROM product_category WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../category_admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $categoryID);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../category_admin.php");
}
function deleteProduct($conn, $productID){
    $sql = "DELETE FROM product WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../product_admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $productID);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../product_admin.php");

}
function deleteSMethod($conn, $sMethodID){
    $sql = "DELETE FROM shipping_method WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../shippingmethod_admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $promotionID);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../shippingmethod_admin.php");

}
function getCategoryNameViaPromotionID($conn,$promotionID){
    $sql = "SELECT category_id FROM promotion_category WHERE promotion_id=?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $promotionID);

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $id=mysqli_fetch_assoc($resultData)["category_id"];

    mysqli_stmt_close($stmt);

    $sql = "SELECT category_name FROM product_category WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $categoryName=mysqli_fetch_assoc($resultData)["category_name"];

    mysqli_stmt_close($stmt);

    return $categoryName;
}

function getCategoryNameViaID($conn,$categoryID){
    $sql = "SELECT category_name FROM product_category WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../product_admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $categoryID);

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $categoryName=mysqli_fetch_assoc($resultData)["category_name"];

    mysqli_stmt_close($stmt);

    return $categoryName;
}