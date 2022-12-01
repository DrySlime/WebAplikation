<?php 

include 'includes/dbh_include.php';
include 'includes/functions_include.php';
include 'includes/product_include.php';
include 'includes/check_out_include.php';


$userId = getUserIdFromUserName($_SESSION['useruid']);
$addressId = $_GET["addressId"];
$paymentId = $_GET["paymentId"];
$shippingId = $_GET["shippingId"];

function doOrder($conn){

}



















?>