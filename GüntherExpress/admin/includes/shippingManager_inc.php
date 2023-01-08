<?php
include_once '../../includes/dbh_include.php';

global $conn;

if (isset($_POST['editname'])) {
    $name = $_POST['editname'];
    $price = $_POST['editprice'];
    $id = $_POST['editshipping'];

    $sql = "UPDATE shipping_method SET shipping_name=?, shipping_price=? WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin_shipping.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $name, $price, $id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("location: ../admin_shipping.php");
    exit();
} else if (isset($_POST['createname'])) {
    $name = $_POST['createname'];
    $price = $_POST['createprice'];

    $sql = "INSERT INTO shipping_method (shipping_name, shipping_price) VALUES (?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin_shipping.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $name, $price);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("location: ../admin_shipping.php");

    exit();
}