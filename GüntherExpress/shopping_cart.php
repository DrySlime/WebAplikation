<?php
include_once 'header.php';
include_once 'includes/dbh_include.php';
include_once 'includes/product_include.php';
include_once 'includes/functions_include.php';


$userID = $_SESSION['useruid'];
$items = getShoppingCartItems($conn, getUserIdFromUserName($conn, $userID));

echo "<h1>Warenkorb:</h1>";


while ($row = $items->fetch_assoc()) {
    echo '<div>';
    echo showProduct($conn, $row["product_id"]);
    echo 'Menge: '.$row["qty"];
    echo '</div>';
}

?>


<?php
include_once 'footer.php';
?>