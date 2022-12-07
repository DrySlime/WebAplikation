<?php
if(isset($_POST["send_form"])){
    global $conn;
    $categoryID = $_POST['category_id'];
    $name = $_POST['product_name'];
    $description = $_POST['description'];
    $productImage = $_POST['productImage'];
    $price = $_POST['price'];
    $inStock = $_POST['qty_in_stock'];
    $productID = $_POST['productID'];


    //Error-Handling
    require_once 'dbh_include.php';
    require_once 'functions_include.php';
    #TODO


    updateProduct($conn,$categoryID,$name,$description,$productImage,$price,$inStock,$productID);


}else{
    header("location: ../product_admin.php");
    exit(  );
}