<?php
include_once 'dbh_include.php';
include_once 'product_include.php';
include_once 'functions_include.php';
global $conn;

    if (isset($_GET["delete"])) {
        $sql = "DELETE FROM shopping_cart WHERE user_id = ? AND product_id = ? ";
        $stmt = mysqli_stmt_init($conn);


        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $_SESSION['userid'], $_GET["delete"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    if (isset($_GET["checkout_button"])) {
        $sql = "DELETE FROM shopping_cart WHERE user_id = ?  AND qty = 0";
        $stmt = mysqli_stmt_init($conn);


        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $_SESSION['userid']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("location: ../checkout.php?error=none");
        exit();
    }

    if(isset($_GET["increase"])){
        $sql = "UPDATE shopping_cart SET qty=qty+1 WHERE user_id = ?  AND product_id = ?";
        $stmt = mysqli_stmt_init($conn);


        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $_SESSION['userid'],$_GET["increase"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("location: ../cart.php?error=none");
        exit();
    }

    if(isset($_GET["decrease"])){
        $sql = "UPDATE shopping_cart SET qty=qty-1 WHERE user_id = ?  AND product_id = ? AND qty > 1";
        $stmt = mysqli_stmt_init($conn);


        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $_SESSION['userid'],$_GET["decrease"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("location: ../cart.php?error=none");
        exit();

    }

    function getWholeQty($cart) {
        $_SESSION['wholeQty'] = 0;
        while ($row = $cart->fetch_assoc()) {
            $_SESSION['wholeQty'] = $row['qty']+$_SESSION['wholeQty'];
        }
    }