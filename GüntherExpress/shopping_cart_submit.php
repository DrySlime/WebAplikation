<?php

include_once 'includes/dbh_include.php';

if (isset($_POST["into_shopping_cart"])) {
    $user = $_POST['userID'];
    $product = $_POST['pID'];
    $quantaty = $_POST['quantaty'];
}

$sql = "INSERT INTO shopping_cart (user_id, product_id, qty) VALUES (?,?,?);";
$stmt = mysqli_stmt_init($conn);


mysqli_stmt_prepare($stmt,$sql);
mysqli_stmt_bind_param($stmt,"sss",$user,$product,$quantaty);
mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);

?>

<h2>Folgender Gegenstand wurde in den Warenkorb gelegt:</h2>


