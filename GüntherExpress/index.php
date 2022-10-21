<?php
    include_once 'header.php';
    require_once 'includes/dbh_include.php';
    require_once 'includes/functions_include.php';
?>
<?php
    if (isset($_SESSION["useruid"])){
        echo "<p>Moin ". $_SESSION["useruid"]."</p>";
        
        }else{
        
    }
?>

<?php
    //showCategoryList($conn);
    //showExamples($conn,2,"Schuhe");
    
    randomCategory($conn,2);

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
