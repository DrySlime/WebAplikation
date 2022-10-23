<?php
    include_once 'header.php';
    require_once 'includes/dbh_include.php';
    require_once 'includes/functions_include.php';
?>
<?php
    $parentCategory=$_GET["parentCategory"];
    showChildCategoriesAndItems($conn,$parentCategory,2);

    
?>

    

<?php
include_once 'footer.php';
?>