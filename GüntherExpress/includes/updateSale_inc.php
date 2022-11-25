<?php
if(isset($_POST["send_form"])){

    $categoryID = $_POST['category_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $discount = $_POST['discount'];
    $startDate = $_POST['start-date'];
    $endDate = $_POST['end-date'];
    $promoID = $_POST['promoID'];


    //Error-Handling
    require_once 'dbh_include.php';
    require_once 'functions_include.php';

    if(invalidDiscountrate($discount)!==false){
        header("location: ../sale_admin.php?error=invalidDiscount");
        exit();
    }
    if(invalidDate($startDate,$endDate)!==false){
        header("location: ../sale_admin.php?error=invalidDate");
        exit();
    }


    updateSale($conn,$categoryID,$title,$description,$discount,$startDate,$endDate, $promoID);


}else{
    header("location: ../sale_admin.php");
    exit(  );
}