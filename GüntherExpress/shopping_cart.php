<html>
<head>
    <link rel="stylesheet" href="../css/shopping_cart.css">
</head>

<?php
include_once 'header.php';
include_once 'includes/dbh_include.php';
include_once 'includes/product_include.php';
include_once 'includes/functions_include.php';


if(isset($_SESSION['useruid'])){
    $userName = $_SESSION['useruid'];
}else{
    echo "<div style="."background-color:#f9d4dc".">";
    echo  "<p class="."confirmation".">Sie müssen sich erst <a href="."login.php".">einlogen!</a></p>";
    echo "</div>";
    exit();
}

$userId = getUserIdFromUserName($conn, $userName);


if(isset($_GET["delete"])){
    $sql = "DELETE FROM shopping_cart WHERE user_id = ? AND product_id = ? ";
    $stmt = mysqli_stmt_init($conn);
    
    
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"ss",$userId,$_GET["delete"],);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}


$items = getShoppingCartItems($conn, $userId);


?>
<body>

    <div class="background">

            <?php
            echo "<div class='shopping-cart-container' id='shopping-cart-container'>";
            echo "<h1 class='shopping-cart-text'>Warenkorb:</h1>";

            if($items-> num_rows == 0){
                echo "<h1 style='text-align: center;'>Es befinden sich zurzeit keine Artikel im Warenkorb</h1>";    
            }
                while ($row = $items->fetch_assoc()) {
                    echo "<div class="."product".">";
 
                        echo '<div class= '.'product-image'.'>';
                        echo showShoppingCartImage($conn, $row["product_id"]);
                        echo '</div>';

                        echo '<div class= '.'product-info'.'>';
                        echo showShoppingCartProduct($conn, $row["product_id"], $userId);
                        echo '<p class="product-qty-text"> Menge: '.$row["qty"]." </p>";
                        echo '<a class='.'delete-icon'.' href='.'shopping_cart.php?delete='.$row["product_id"].'>Löschen</a>';
                        echo '</div>';

                    echo '</div>';
                }

            echo "</div>";
            if($items-> num_rows == 0){
                exit(include_once 'footer.php');
            }
            ?>
        

        <div class="button-container">
            
            <form action="check_out_address.php">
                    <input class="button" type="submit" value="Zur Kasse">
            </form>
            <form action="check_out_shipping.php?isFastCheckOut=true">
                    <input type="hidden" name="isFastCheckOut" value="<?php echo "true" ?>">
                    <input class="button" type="submit" value="Schnell Kauf">
            </form>
            <div class="end-price">  Gesamt: <br> <?php echo getShoppingCartSum($conn, $userId) ?> Euro</div>
        </div>

    </div>


</body>
</html>

     
<?php
include_once 'footer.php';
?>