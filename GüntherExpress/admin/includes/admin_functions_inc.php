<?php

require_once "../includes/dbh_include.php";
function getAllOrderedProducts($conn)
    #return an array filled with all data you could get from an order which is ordered descending!
{
    $allItems = null;
    $sql = "SELECT * FROM shop_order ORDER BY order_date ASC ;";
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
    $allItems = null;
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
}

function getAllFromUser($conn, $userid)
    #returns an array with all USER Data from $userid
{
    $allItems = null;
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

function getAdressFromUserID($conn, $userID)
{
    #returns an array filled with adress information from an $userid
    $allItems = null;
    $sql = "SELECT * FROM address WHERE id=(SELECT address_id FROM user_address WHERE user_id=?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $userID);
    mysqli_stmt_execute($stmt);
    if ($resultData = mysqli_stmt_get_result($stmt)) {
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

function getAllOrderedProductsFromOrderID($conn, $orderID)
{
    #returns an array with all inforamtion about an $orderID

    $allItems = null;
    $sql = "SELECT * FROM shop_order WHERE id=? ORDER BY order_date DESC ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $orderID);
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

function getUsername($conn, $userID)
{
    #get the username from an $userID

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

function getPaymentMethod($conn, $paymentmethodID)
{
    #returns a String value of a $paymentmethodID


    $sql = "SELECT payment_type_id FROM user_payment_method WHERE id=? ;";
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
    $paymentmethodType = $row["payment_type_id"];


    $sql = "SELECT value FROM payment_type WHERE id=? ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $paymentmethodType);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($resultData);
    $paymentmethod = $row["value"];


    return $paymentmethod;
}

function getShippingAdress($conn, $id)
{
    #returns all information about the address from its corresponding $id

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
    $shippingadress = $row["address_line1"] . " " . $row["street_number"] . ", " . $row["postal_code"] . ", " . $row["city"];


    return $shippingadress;
}

function getShippingMethod($conn, $id)
{
    #returns the shipping name corresponding to its id

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

function getOrderStatus($conn, $id)
{
    #returns the String status of its corresponding id

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

function getOrderLine($conn, $id)
{
    #returns all required information about an orderline to its corresponding id

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

    while ($row = mysqli_fetch_assoc($resultData)) {
        $product["product_item_id"] = $row["product_item_id"];
        $product["qty"] = $row["qty"];
        $product["price"] = $row["price"];
        $productArr[] = $product;
        unset($product);
    }
    return $productArr;
}

function getAllOrderStatus($conn)
{
    #returns all possible order status and their IDs

    $statusArr = null;

    $sql = "SELECT * FROM order_status ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        $status["id"] = $row["id"];
        $status["status"] = $row["status"];
        $statusArr[] = $status;
        unset($product);
    }
    return $statusArr;
}

function getProductName($conn, $id)
{
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

function getUserID($conn, $username)
{
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
    if ($resultData = mysqli_stmt_get_result($stmt)) {

        if ($row = mysqli_fetch_assoc($resultData)) {
            $id = $row["id"];
            return $id;
        }

    }

    return null;

}

function orderlineToTEXT($conn, $order)
{
    #a toString method to properly display order details

    $string = "";
    for ($k = 0; $k < count($order); $k++) {
        $so = $order[$k]["qty"] . "x " . getProductName($conn, $order[$k]["product_item_id"]) . " -> " . $order[$k]["price"] . " Euro <br>";
        $string = $string . $so;
    }

    return $string;
}

function getAllCategories($conn)
{
    #returns all necessary information of all categories

    $sql = "SELECT id, category_name, parent_category_id FROM product_category;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        $category["id"] = $row["id"];
        $category["category_name"] = $row["category_name"];
        $category["parent_category_id"] = $row["parent_category_id"];
        $categoryArr[] = $category;
        unset($category);
    }

    mysqli_stmt_close($stmt);
    return $categoryArr;
}

function getAllProducts($conn)
{
    #returns all information of all products in an array

    $productArr = null;
    $sql = "SELECT * FROM product ";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../product_admin.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        $product["id"] = $row["id"];
        $product["product_name"] = $row["product_name"];
        $product["product_category_id"] = $row["product_category_id"];
        $product["product_image"] = $row["product_image"];
        $product["qty_in_stock"] = $row["qty_in_stock"];
        $product["price"] = $row["price"];
        $product["description"] = $row["description"];


        $productArr[] = $product;
        unset($product);
    }

    mysqli_stmt_close($stmt);
    return $productArr;
}

function getAllShippingMethods($conn)
{
    $sMethodArr = null;
    $sql = "SELECT * FROM  shipping_method";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../shippingmethod_admin.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        $sMethod["id"] = $row["id"];
        $sMethod["shipping_name"] = $row["shipping_name"];
        $sMethod["shipping_price"] = $row["shipping_price"];


        $sMethodArr[] = $sMethod;
        unset($sMethod);
    }

    mysqli_stmt_close($stmt);
    return $sMethodArr;
}

function deleteCategory($conn, $categoryID)
{
    $sql = "UPDATE product_category SET active = 0 WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../category_admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $categoryID);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../category_admin.php");
}

function deleteProduct($conn, $productID)
{
    $sql = "UPDATE product SET active = 0 WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../product_admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $productID);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../product_admin.php");

}

function deleteSMethod($conn, $sMethodID)
{
    $sql = "UPDATE shipping_method SET active = 0 WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../shippingmethod_admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $sMethodID);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../shippingmethod_admin.php");

}

function getCategoryNameViaID($conn, $categoryID)
{
    $sql = "SELECT category_name FROM product_category WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../product_admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $categoryID);

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $categoryName = mysqli_fetch_assoc($resultData)["category_name"];

    mysqli_stmt_close($stmt);

    return $categoryName;
}


/*
 *
 * Admin Dashboard Panel
 *
 */
function getLastMonths()
{
    $months = array();
    for ($i = 0; $i <= 6; $i++) {
        $months[] = date("m, Y", strtotime("-" . $i . " month"));
    }
    return array_reverse($months);

}

function getOrderCountFromMonth($conn, $date)
{
    $month = explode(", ", $date)[0];
    $year = explode(", ", $date)[1];
    $sql = "SELECT COUNT(*) AS count FROM shop_order WHERE YEAR(order_date) = ? AND MONTH(order_date) = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $year, $month);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return mysqli_fetch_assoc($resultData)["count"];
}

function getSumFromMonth($conn, $date)
{
    $month = explode(", ", $date)[0];
    $year = explode(", ", $date)[1];

    $sql = "SELECT SUM(order_total) FROM shop_order WHERE YEAR(order_date) = ? AND MONTH(order_date) = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $year, $month);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $resultData = mysqli_fetch_assoc($resultData);
    if($resultData['SUM(order_total)'] == null){
        return 0;
    }
    return $resultData['SUM(order_total)'];
}

function getCount($conn, $countData){
    $sql = null;
    switch ($countData){
        case "user":
            $sql = "SELECT COUNT(*) AS count FROM site_user";
            break;
        case "product":
            $sql = "SELECT COUNT(*) AS count FROM product";
            break;
        case "orders":
            $sql = "SELECT COUNT(*) AS count FROM shop_order";
            break;
    }
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return mysqli_fetch_assoc($resultData)["count"];
}

function getLastTenOrders($conn) {
    $sql = "SELECT * FROM shop_order ORDER BY id DESC LIMIT 10";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $resultData;
}

function getEmptyProducts($conn) {
    $sql = "SELECT * FROM product WHERE qty_in_stock = 0";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $resultData;
}

function getPaymentTypeFromOrder($conn, $userid, $orderid) {
    $sql = "SELECT `user_payment_method`.`payment_type_id`, `shop_order`.`payment_method_id`, `shop_order`.`siteuser_id` FROM `user_payment_method` LEFT JOIN `shop_order` ON `shop_order`.`payment_method_id` = `user_payment_method`.`id` WHERE `shop_order`.`siteuser_id` = ? AND `shop_order`.`id` = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $userid, $orderid);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    $sql = "SELECT payment_type.value AS value FROM payment_type WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", mysqli_fetch_assoc($resultData)["payment_type_id"]);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return mysqli_fetch_assoc($resultData);
}