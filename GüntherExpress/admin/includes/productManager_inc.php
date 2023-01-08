<?php
include_once '../../includes/dbh_include.php';

global $conn;

if (isset($_POST['editname'])) {
    $categoryID = $_POST['editcategory'];
    $name = $_POST['editname'];
    $description = $_POST['editdescription'];
    $productImage = $_POST['editimage'];
    $price = $_POST['editprice'];
    $inStock = $_POST['editamount'];
    $productID = $_POST['itemidSelect'];
    $active = $_POST['editactive'];

    $sql = "UPDATE product SET product_name=?, product_category_id=?, product_image=?, qty_in_stock=?, price=?, description=?, active=? WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin_products.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssssss", $name, $categoryID, $productImage, $inStock, $price, $description, $active, $productID);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("location: ../admin_products.php");
    exit();
} else if (isset($_POST['createcategory'])) {
    $categoryID = $_POST['createcategory'];
    $name = $_POST['createname'];
    $description = $_POST['createdescription'];
    $productImage = $_POST['createimage'];
    $price = $_POST['createprice'];
    $inStock = $_POST['createamount'];

    $sql = "INSERT INTO product (product_name,product_category_id,product_image,qty_in_stock,price,description) VALUES (?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin_products.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssss", $name, $categoryID, $productImage, $inStock, $price, $description);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("location: ../admin_products.php");

    exit();
}