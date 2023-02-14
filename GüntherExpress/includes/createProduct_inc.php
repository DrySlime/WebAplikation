<?php

if(isset($_POST["send_form"])){
    global $conn;
    $categoryID = $_POST['category_id'];
    $name = $_POST['name'];
    $productImage = $_POST['pImage'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $inStock = $_POST['inStock'];



    #TODO
    //Error-Handling
    require_once 'dbh_include.php';
    require_once 'functions_include.php';

    
    
    createProduct($conn,$categoryID,$name,$productImage,$description,$price,$inStock, );


}header("location: ../product_admin.php");
exit(  );