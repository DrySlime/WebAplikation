<?php
require_once "dbh_include.php";
require_once "admin_functions_inc.php";
if(isset($_POST["delButton"])){
    global $conn;
    $productID=$_POST["productID"];
    deleteProduct($conn,$productID);
}
