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

 function getUserAdress($conn, $userId){
    $sql = "SELECT address_id FROM user_address WHERE user_id = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s", $userId,);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
 }

 function showUserAddress($conn, $addressIds){

    while ($row = $addressIds->fetch_assoc()) {
        $sql = "SELECT * FROM address WHERE id = ?;";
        $stmt = mysqli_stmt_init($conn);

        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"s",$row["address_id"],);
        mysqli_stmt_execute($stmt);

        $addresses = mysqli_stmt_get_result($stmt);

        while ($row1 = $addresses->fetch_assoc()) {
            echo "<div class="."address".">";
    
                showAddress($row1);
                echo '<a class="button" href='.'check_out_payment.php?addressId='.$row1["id"].'>Wählen</a>';

             echo '</div>';
            
            
        }
    }
 }

?>


<html>
    <head>
        <link rel="stylesheet" href="../css/check_out.css">
    </head>
    <body>
        <p>Folgende Adressen sind in ihrem Konto hinterlegt: </p>
        <div class="container">
             <?php showUserAddress($conn, getUserAdress($conn, $userId)); ?>
        </div>  

        <p>Wählen sie eine Adresse aus oder <a href="profile.php">fügen sie eine neue hinzu!</a></p>
    </body>
</html>