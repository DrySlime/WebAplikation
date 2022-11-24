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
//function getAllOrderedProducts($conn)
//{
//    $sql = "SELECT * FROM shop_order ORDER BY order_date DESC ;";
//    $stmt = mysqli_stmt_init($conn);
//
//    if (!mysqli_stmt_prepare($stmt, $sql)) {
//        header("location: ../index.php?error=stmtfailed");
//        exit();
//    }
////    mysqli_stmt_prepare($stmt, $sql);
////    mysqli_stmt_bind_param($stmt, "s", $amount);
//    mysqli_stmt_execute($stmt);
//    $resultData = mysqli_stmt_get_result($stmt);
//
//    while ($row = mysqli_fetch_assoc($resultData)) {
//        $array["order_id"] = $row["id"];
//        $array["siteuser_id"] = $row["siteuser_id"];
//        $array["order_date"] = $row["order_date"];
//        $array["payment_method_id"] = $row["payment_method_id"];
//        $array["shipping_address_id"] = $row["shipping_address_id"];
//        $array["shipping_method_id"] = $row["shipping_method_id"];
//        $array["order_total"] = $row["order_total"];
//        $array["order_status_id"] = $row["order_status_id"];
//
//        $allItems[] = $array;
//        unset($array);
//    }
//
//    return $allItems;
//}