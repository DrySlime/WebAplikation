<?php
include_once "dbh_include.php";

$orderID=$_POST["orderID"];
$statusID=$_POST["statusID"];

$sql = "UPDATE shop_order SET order_status_id=? WHERE id=?;";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt,$sql)){
    header("location: ../shippingmethod_admin.php?error=stmtfailed");
    exit();
}



mysqli_stmt_bind_param($stmt,"ss",$statusID,$orderID);
mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);

header("location: ../orderedProducts_admin.php");
exit();
