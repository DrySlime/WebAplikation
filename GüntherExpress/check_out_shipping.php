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

$userId = getUserIdFromUserName($conn, $userName);
if(isset($_GET["addressId"])){
    $addressId = $_GET["addressId"];
    $paymentId = $_GET["paymentId"];
}


if(isset($_GET["isFastCheckOut"]) and $_GET["isFastCheckOut"] == "true"){

    $sql = "SELECT * FROM user_address WHERE user_id=? AND is_default_address=?";
    $stmt = mysqli_stmt_init($conn);

    $eins = 1;

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"ss", $userId, $eins);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $addressId = mysqli_fetch_assoc($resultData)["address_id"];

    $sql = "SELECT * FROM user_payment_method WHERE user_id=? AND is_default_pay_method=?";
    $stmt = mysqli_stmt_init($conn);

    $eins = 1;

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"ss", $userId, $eins);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $paymentId = mysqli_fetch_assoc($resultData)["id"];

}

function showShippingMethods($conn, $addressId, $paymentId){
 
    $sql = "SELECT * FROM shipping_method";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_execute($stmt);

    $shippingMethods = mysqli_stmt_get_result($stmt);

    while ($row1 = $shippingMethods->fetch_assoc()) {

        
        echo '<a class=address href='.'check_out_overview.php?addressId='.$addressId.'&paymentId='.$paymentId.'&shippingId='.$row1["id"].'>';
            echo '<p class="box-headline">Versandoption:</p>';
            showShippingMethod($row1);
        echo '</a>';
    }
    
}


?>


<html>
    <head>
        <link rel="stylesheet" href="../css/check_out.css">
    </head>
    <body>
     <div class="background"> 
            <div class="container">
                <div class="headline-container">
                    <h1 class="headline">Versandoption: </h1>
                </div>  
                <div class="box-container">
                    <?php showShippingMethods($conn, $addressId, $paymentId); ?>
                </div>  
            </div>
        </div>
    </body>
</html>

<?php
include_once 'footer.php';
?>