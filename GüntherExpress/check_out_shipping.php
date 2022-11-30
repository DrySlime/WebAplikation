<?php
include_once 'header.php';
include_once 'includes/dbh_include.php';
include_once 'includes/product_include.php';
include_once 'includes/functions_include.php';
include_once 'includes/check_out_include.php';


$userName;

if(isset($_SESSION['useruid'])){
    $userName = $_SESSION['useruid'];
}else{
    echo "<div style="."background-color:#f9d4dc".">";
    echo  "<p class="."confirmation".">Sie müssen sich erst <a href="."login.php".">einlogen!</a></p>";
    echo "</div>";
    exit();
}


function showShippingMethods($conn){
 
    $sql = "SELECT * FROM shipping_method";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_execute($stmt);

    $shippingMethods = mysqli_stmt_get_result($stmt);

    while ($row1 = $shippingMethods->fetch_assoc()) {

        echo "<div class="."shipping_method".">";
            showShippingMethod($row1);
            echo '<p><a class="button" href='.'check_out_overview.php?addressId='.$_GET["addressId"].'&paymentId='.$_GET["paymentId"].'&shippingId='.$row1["id"].'>Wählen</a> </p>';
        echo '</div>';
    }
    
}


?>


<html>
    <head>
        <link rel="stylesheet" href="../css/check_out.css">
    </head>
    <body>
        <div class="background">
            <h1>Wählen sie eine Versandoption: </h1>
            <div class="container">
                <?php showShippingMethods($conn); ?>
            </div>
        </div>
    </body>
</html>