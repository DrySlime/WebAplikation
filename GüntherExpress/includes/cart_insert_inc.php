<?php
include 'dbh_include.php';
include_once 'functions_include.php';
include_once "item_function.php";
global $conn;

function runCartProcess(){
    global $conn;

    if (isset($_SESSION['useruid'])) {
        $userName = $_SESSION['useruid'];
    } else {
        header('Location: login.php');
        exit();
    }
    $userId = getUserIdFromUserName($conn, $userName);

    insert_into_cart($conn, $userId, $_GET['pID'], $_GET['quantity']);
}

// Item wird in den Einkaufswagen gelegt
function insert_into_cart($conn, $userId, $productId, $quantity){
    $sql = "SELECT qty FROM shopping_cart WHERE user_id = ? AND product_id = ?";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $userId, $productId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($resultData);
    mysqli_stmt_close($stmt);

    if ($data == null) {
        $sql = "INSERT INTO shopping_cart (user_id, product_id, qty) VALUES (?,?,?)";
        $stmt = mysqli_stmt_init($conn);

        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $userId, $productId, $quantity);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $sql = "UPDATE shopping_cart SET qty = ? WHERE user_id = ? AND product_id = ?";
        $stmt = mysqli_stmt_init($conn);

        $newQuantity = ($quantity + $data["qty"]);

        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $newQuantity, $userId, $productId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
?>

