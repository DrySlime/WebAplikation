<?php

if(isset($_POST["send_form"])){

    $name = $_POST['name'];
    $price = $_POST['price'];
    


    #TODO
    //Error-Handling
    require_once 'dbh_include.php';
    require_once 'functions_include.php';

    if(invalidDiscountrate($discount)!==false){
        header("location: ../shippingmethod_admin.php?error=invalidDiscount");
        exit();
    }
    if(invalidDate($startDate,$endDate)!==false){
        header("location: ../shippingmethod_admin.php?error=invalidDate");
        exit();
    }

    createShippingMethod($conn,$name,$price);


}else{
    header("location: ../shippingmethod_admin.php");
    exit(  );
}