<?php
require_once "dbh_include.php";
require_once "admin_functions_inc.php";
if(isset($_POST["delButton"])){
    $promotionID=$_POST["promotionID"];
    deleteSale($conn,$promotionID);
}
