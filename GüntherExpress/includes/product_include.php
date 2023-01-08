<?php

//Produktdaten werden aus der Datenbank aufgerufen
function getProductData($conn, $productID)
{
    $sql = "SELECT * FROM product WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $productID,);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($resultData);
}

function getShoppingCartItems($conn, $userId)
{
    $sql = "SELECT * FROM shopping_cart WHERE user_id = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $userId,);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
}