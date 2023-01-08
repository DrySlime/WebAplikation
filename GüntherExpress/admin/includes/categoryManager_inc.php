<?php
include_once '../../includes/dbh_include.php';

global $conn;

if (isset($_POST['editname'])) {
    $name = $_POST['editname'];
    $id = $_POST['editcategory'];
    $active = $_POST['editactive'];

    $sql = "UPDATE product_category SET category_name=?, active=? WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin_categories.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $name, $active, $id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("location: ../admin_categories.php");
    exit();
} else if (isset($_POST['createname'])) {
    $name = $_POST['createname'];

    $sql = "INSERT INTO product_category (category_name) VALUES (?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin_categories.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("location: ../admin_categories.php");

    exit();
}