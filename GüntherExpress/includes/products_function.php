<?php
require_once "functions_include.php";

function searchByPrice($conn, $category, $min, $max)
{
    $categoryID = convertCategoryNameToID($conn, $category);
    if ($categoryID == null) {
        $sql = "SELECT * FROM product WHERE upper(product_name) LIKE upper(?) AND price<=? AND price>=?;";
    } else {
        $sql = "SELECT * FROM product WHERE product_category_id = ? AND price<=? AND price>=?;";
    }

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    if ($categoryID == null) {
        $productName = "%" . $category . "%";

        mysqli_stmt_bind_param($stmt, "sss", $productName, $max, $min);
    } else {
        mysqli_stmt_bind_param($stmt, "sss", $categoryID, $max, $min);
    }

    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($resultData) > 0) {
        while ($row = mysqli_fetch_assoc($resultData)) {
            $itemAttribute["id"] = $row["id"];
            $itemAttribute["product_name"] = $row["product_name"];
            $itemAttribute["product_image"] = $row["product_image"];
            $itemAttribute["qty_in_stock"] = $row["qty_in_stock"];
            $itemAttribute["price"] = $row["price"];
            $itemAttribute["description"] = $row["description"];
            $itemArr[] = $itemAttribute;
            unset($itemAttribute);
        }
    } else {
        $itemArr = null;
    }
    mysqli_stmt_close($stmt);
    return $itemArr;
}

function searchProduct($conn, $searchTerm)
{
    $searchTerm = "%" . $searchTerm . "%";
    $sql = "SELECT * FROM product WHERE active = 1 AND UPPER(product_name) LIKE UPPER(?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $searchTerm);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($resultData) > 0) {
        while ($row = mysqli_fetch_assoc($resultData)) {

            $itemAttribute["id"] = $row["id"];
            $itemAttribute["product_name"] = $row["product_name"];
            $itemAttribute["product_image"] = $row["product_image"];
            $itemAttribute["qty_in_stock"] = $row["qty_in_stock"];
            $itemAttribute["price"] = $row["price"];
            $itemAttribute["description"] = $row["description"];
            $itemArr[] = $itemAttribute;
            unset($itemAttribute);
        }
    } else {
        $itemArr = null;
    }
    mysqli_stmt_close($stmt);
    return $itemArr;
}