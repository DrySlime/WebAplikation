<?php
#TODO productLine id herausfinden
    session_start();
    require_once 'dbh_include.php';
    require_once 'functions_include.php';
    if (isset($_POST["review_button"])) {
        $comment = $_POST['Text1'];
        $rating = $_POST['star'];
        $productID =$_POST["productID"];
        $productLine = $_POST["productlineID"];
        $siteUser = $_SESSION["userid"];

        $sql = "INSERT INTO user_review (siteuser_id,ordered_product_id,rating_value,comment) VALUES ($siteUser,$orderlineID,$rating,$comment);";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_execute($stmt);
        header("location: ../rateProducts.php?thankyou=1");     
        exit(); 
    } else {
        header("location: ../login.php");
        exit();
    }
?>