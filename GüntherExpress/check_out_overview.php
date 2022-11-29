<head>
    <link rel="stylesheet" href="../css/check_out_overview.css">
</head>

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

$items = getShoppingCartItems($conn, $userId);


?>

<body>

    <div class="background">

        <h1>Übersicht:</h1>

        <div class="container">
            
            <div class="address">
                <h1>Lieferaddresse:</h1>
                <?php  
                $sql = "SELECT * FROM address WHERE id = ?;";
                $stmt = mysqli_stmt_init($conn);
            
                mysqli_stmt_prepare($stmt,$sql);
                mysqli_stmt_bind_param($stmt,"s",$_GET["addressId"],);
                mysqli_stmt_execute($stmt);
            
                $resultData = mysqli_stmt_get_result($stmt);
                showAddress(mysqli_fetch_assoc($resultData)) 
                ?>
            </div>

            <div class="payment">
                <h1>Zahlungsart:</h1>
                <?php  
                $sql = "SELECT * FROM user_payment_method WHERE id = ?;";
                $stmt = mysqli_stmt_init($conn);
            
                mysqli_stmt_prepare($stmt,$sql);
                mysqli_stmt_bind_param($stmt,"s",$_GET["paymentId"],);
                mysqli_stmt_execute($stmt);
            
                $resultData = mysqli_stmt_get_result($stmt);
                showPaymentMethod($conn, mysqli_fetch_assoc($resultData));
                ?>
            </div>

            <div class="shipping">
                <h1>Versandmethode:</h1>
                <?php  
                    $sql = "SELECT * FROM shipping_method WHERE id = ?;";
                    $stmt = mysqli_stmt_init($conn);
                
                    mysqli_stmt_prepare($stmt,$sql);
                    mysqli_stmt_bind_param($stmt,"s",$_GET["shippingId"],);
                    mysqli_stmt_execute($stmt);
                
                    $resultData = mysqli_stmt_get_result($stmt);
                    showShippingMethod(mysqli_fetch_assoc($resultData));
                ?>
            </div>

            <div class="price">
                <h1>Kosten:</h1>
                <p>Preis:  <?php echo getShoppingCartSum($conn, $userId) ?> Euro</p>
                <p>Versand:  <?php echo getShippingPrice($conn, $_GET["shippingId"]) ?> Euro</p>
                <p class="end-price">  Gesamt: <br> <?php echo (getShoppingCartSum($conn, $userId) + getShippingPrice($conn, $_GET["shippingId"])) ?> Euro</p>
                <a class="button" href= "order_complete.php"> Kostenpflichtig bestellen</a>
            </div>


            

        </div>

    </div>
</body>

