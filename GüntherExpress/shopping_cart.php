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

echo "<div>";
echo "<h1>Warenkorb:</h1>";


while ($row = $items->fetch_assoc()) {
    echo '<div>';
    echo showProduct($conn, $row["product_id"]);
    echo 'Menge: '.$row["qty"];
    echo "<br>";
    echo "<a href="."shopping_cart.php?delete=".$row["product_id"].">Löschen</a>";
    echo '</div>';
}

?>

<form action="check_out.php">
    <input type="submit" value="Zur Kasse">
</form>

<?php
echo "</div>";
?>

<?php
include_once 'footer.php';
?>