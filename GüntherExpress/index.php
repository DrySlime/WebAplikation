
<?php
    include_once 'header.php';
    require_once 'includes/dbh_include.php';
    require_once 'includes/functions_include.php';
?>

<?php
if (isset($_SESSION["useruid"])) {
    echo "<p>Moin " . $_SESSION["useruid"] . "</p>";
} else {
}
?>

<?php
    
    showRandomCategoriesAndItems($conn,$categoryAmount=4,$productAmount=2);


?>

    

<?php
include_once 'footer.php';
?>