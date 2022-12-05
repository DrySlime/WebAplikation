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


function showUserPaymentMethods($conn, $userId){

    
    $sql = "SELECT * FROM user_payment_method WHERE user_id = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$userId,);
    mysqli_stmt_execute($stmt);

    $paymentMethods = mysqli_stmt_get_result($stmt);

    while ($row1 = $paymentMethods->fetch_assoc()) {

        echo '<a class=address href='.'check_out_shipping.php?addressId='.$_GET["addressId"].'&paymentId='.$row1["id"].'>';
            echo '<p class="box-headline">Zahlunsgmethode:</p>'; 
            showPaymentMethod($conn, $row1);
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
                    <h1 class="headline">Zahlungsmethode: </h1>
                </div>  
                <div class="box-container">
                    <?php showUserPaymentMethods($conn, $userId); ?>
                </div>  
            </div>
            <a class="addBtn link " href="href="profile.php>Neue Bezahlmethode hinzufügen</a>
        </div>

    </body>
</html>