<?php
if(isset($_POST["send_form"])){

    $name = $_POST['methodName'];
    $price = $_POST['shippingPrice'];
    $methodID = $_POST['methodID'];
    

    //Error-Handling
    require_once 'dbh_include.php';
    require_once 'functions_include.php';
    #TODO
    if(invalidDiscountrate($discount)!==false){
        header("location: ../shippingMethod_admin.php?error=invalidDiscount");
        exit();
    }
    if(invalidDate($startDate,$endDate)!==false){
        header("location: ../shippingMethod_admin.php?error=invalidDate");
        exit();
    }


    updateShippingMethod($conn,$name,$price,$methodID);


}else{
    header("location: ../shippingMethod_admin.php");
    exit(  );
}