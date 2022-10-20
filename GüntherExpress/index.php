<?php
include_once 'header.php';
?>
<?php
    if (isset($_SESSION["useruid"])){
        echo "<p>Moin ". $_SESSION["useruid"]."</p>";
        
        }else{
        
    }
?>
<?php
    require_once 'includes/dbh_include.php';
    require_once 'includes/functions_include.php';
    
    
    

    showExamples($conn,2,"Schuhe");
    



    // for($i=1;$i<count($itemNames); $i++){
    //     try{
    //         @print $itemNames[$i];
    //     }catch(Exception $e){

    //     }
        
    // }

?>

    

<?php
include_once 'footer.php';
?>
