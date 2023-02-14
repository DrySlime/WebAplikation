<?php

if(isset($_POST["send_form"])){
    global $conn;
    $name = $_POST['name'];
    $price = $_POST['price'];

    require_once 'dbh_include.php';
    require_once 'functions_include.php';

    createShippingMethod($conn,$name,$price);

}header("location: ../shippingmethod_admin.php");
exit(  );