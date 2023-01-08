<?php
include_once "rating_functions_inc.php";
include_once 'dbh_include.php';

global $conn;


if(checkReview($conn, $_POST["itemID"]) == 0){
    addReview($conn, getOrderListID($conn)["id"], $_POST["starValue"]);
} else {
    updateReview($conn, $_POST["itemID"], $_POST["starValue"]);
}
echo "Completed";

exit();


function getOrderListID($conn)
{
    session_start();
    $sql = "SELECT id FROM order_line WHERE product_item_id = ? AND order_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $_POST["itemID"], $_POST["orderID"]);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    session_write_close();
    return mysqli_fetch_assoc($resultData);
}