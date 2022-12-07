<?php
require_once "dbh_include.php";
require_once "admin_functions_inc.php";
if(isset($_POST["delButton"])){
    global $conn;
    $promotionID=$_POST["promotionID"];
    deleteSale($conn,$promotionID);
}
