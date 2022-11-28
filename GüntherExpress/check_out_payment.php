<?php
include_once 'header.php';
include_once 'includes/dbh_include.php';
include_once 'includes/product_include.php';
include_once 'includes/functions_include.php';


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

        $paymentType = getPaymentType($conn, $row1["payment_type_id"]);

        echo "<div class="."payment_method".">";

            
                echo "<p>"."Zahlungsart: ".$paymentType["value"]."</p>";
                echo "<p>"."Anbieter: ".$row1["provider"]."</p>";
                echo "<p>"."Kontonummer: ".$row1["account_number"]."</p>";
                echo "<p>"."Ablaufdatum: ".$row1["expiry_date"]."</p>";
                echo '<a href='.'check_out_shipping.php?addressId='.$_GET["addressId"].'&paymentId='.$row1["id"].'>Wählen</a>';
            

        echo '</div>';
    }
    
}

function getPaymentType($conn, $id){
    $sql = "SELECT * FROM payment_type WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$id,);
    mysqli_stmt_execute($stmt);

    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

}
 

?>


<html>
    <head>
        <link rel="stylesheet" href="../css/check_out.css">
    </head>
    <body>
        <p>Folgende Adressen sind in ihrem Konto hinterlegt: </p>
        <?php showUserPaymentMethods($conn, $userId); ?>
        <p>Wählen sie eine Zahlungsmethode aus oder <a href="profile.php">fügen sie eine neue hinzu!</a></p>
    </body>
</html>