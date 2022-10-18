<?php
include_once 'header.php';
?>
<?php
    if (isset($_SESSION["useruid"])){
        echo "<p<Moin ". $_SESSION["useruid"]."</p>";
        
        }else{
        
    }
?>
<div id="logo">
    <a href="#" >
       <img src="img/Logo.png" alt="Günther Express" width="400">
    </a>
</div>
    

<?php
include_once 'footer.php';
?>
