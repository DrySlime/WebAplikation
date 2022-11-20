<head>
    <link rel="stylesheet" href="../css/shopping_cart.css">
</head>

<?php
include_once 'header.php';
include_once 'includes/dbh_include.php';
include_once 'includes/product_include.php';
include_once 'includes/functions_include.php';


$userName = $_SESSION['useruid'];
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

        <h1 class="shopping-cart-text">Warenkorb:</h1>

        <div class="shopping-cart-container" id="shopping-cart-container">
            <?php
                while ($row = $items->fetch_assoc()) {
                    echo "<div class="."product".">";
 
                        echo '<div class= '.'product-image'.'>';
                        echo showShoppingCartImage($conn, $row["product_id"]);
                        echo '</div>';

                        echo '<div class= '.'product-info'.'>';
                        echo showShoppingCartProduct($conn, $row["product_id"], $userId);
                        echo '<p> Menge: '.$row["qty"]." </p>";
                        echo '<a class='.'delete-icon'.' href='.'shopping_cart.php?delete='.$row["product_id"].'>X</a>';
                        echo '</div>';

                    echo '</div>';
                }
            ?>

            

            <form action="check_out_shipping.php">
                    <input class="button" type="submit" value="Zur Kasse">
            </form>
            <div class="end-price">  Gesamt: <br> <?php echo getShoppingCartSum($conn, $userId) ?> Euro</div>

        </div>

    </div>
</body>


<?php
include_once 'footer.php';
?>