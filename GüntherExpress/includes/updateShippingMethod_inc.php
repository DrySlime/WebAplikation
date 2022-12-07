<?php
if(isset($_POST["send_form"])){

    $name = $_POST['name'];
    $price = $_POST['price'];
    $methodID = $_POST['methodID'];
    

    //Error-Handling
    require_once 'dbh_include.php';
    require_once 'functions_include.php';
    #TODO



    updateShippingMethod($conn,$name,$price,$methodID);


}else{
    header("location: ../shippingMethod_admin.php");
    exit(  );
}