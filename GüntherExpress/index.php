<?php
include_once 'header.php';
?>
<?php
    if (isset($_SESSION["useruid"])){
        echo "<p<Moin ". $_SESSION["useruid"]."</p>";
        
        }else{
        
    }
?>

    

<?php
include_once 'footer.php';
?>
