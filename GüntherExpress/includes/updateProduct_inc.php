<?php
if(isset($_POST["send_form"])){

    $categoryID = $_POST['category_id'];
    $name = $_POST['productName'];
    $description = $_POST['description'];
    $productImage = $_POST['productImage'];
    $price = $_POST['price'];
    $inStock = $_POST['qtyInStock'];
    $image = $_POST['image'];
    $productID = $_POST['productID'];


    //Error-Handling
    require_once 'dbh_include.php';
    require_once 'functions_include.php';
    #TODO
    if(invalidDiscountrate($discount)!==false){
        header("location: ../product_admin.php?error=invalidDiscount");
        exit();
    }
    if(invalidDate($startDate,$endDate)!==false){
        header("location: ../product_admin.php?error=invalidDate");
        exit();
    }

    updateProduct($conn,$categoryID,$name,$description,$productImage,$price,$inStock,$image,$productID);


}else{
    header("location: ../product_admin.php");
    exit(  );
}