<?php
    session_start();
    require_once 'dbh_include.php';
    require_once 'functions_include.php';
    if (isset($_POST["review_button"])) {
        $comment = $_POST['Text1'];
        $rating = $_POST['star'];
        $productID =$_POST["productID"];
        $orderlineID = $_POST["orderlineID"];
        $siteUser = $_SESSION["userid"];
        var_dump($orderlineID);


        $sql = "SELECT id FROM user_review WHERE ordered_product_id=$orderlineID;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($resultData)){
            $user_review_id=$row["id"];

            $sql = "UPDATE user_review SET user_id=$siteUser , ordered_product_id =$orderlineID, rating_value=$rating, comment='$comment' WHERE id=$user_review_id;";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("location: ../index.php?error=stmtfailed");
                exit();
            }
            mysqli_stmt_execute($stmt);
            header("location: ../rateProducts.php?thankyou=1");
            exit();

        }else{
            $sql = "INSERT INTO user_review (user_id,ordered_product_id,rating_value,comment) VALUES ($siteUser,$orderlineID,$rating,'$comment');";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("location: ../index.php?error=stmtfailed");
                exit();
            }
            mysqli_stmt_execute($stmt);
            header("location: ../rateProducts.php?thankyou=1");
            exit();
        }




    } else {
        header("location: ../login.php");
        exit();
    }
?>