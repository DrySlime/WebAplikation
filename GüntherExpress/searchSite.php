<?php
    include_once 'header.php';
    require_once 'includes/dbh_include.php';
    require_once 'includes/functions_include.php';
    require_once 'includes/product_include.php';
?>
<?php
    $searchbarValue = $_POST['searchbar'];

    $searchArr=searchbar($searchbarValue,$conn);
    
    if($searchArr!=null){
        for($i=0;$i<count($searchArr);$i++){
            $productData = getProductData($conn,$searchArr[$i]);

            $name = $productData["product_name"];
            $description = $productData["description"];
            $price = $productData["price"];
            $image = $productData["product_image"];
        
            echo"<div name='product_box'>
                        <p>".$name."</p>
                        <img name='product_image' src='".$image."'>
                        <p>Verkaufspreis: ".$price."</p>
                </div>";
        }
    }else{
        echo"<p>Produkt nicht vorhanden, überprüfen sie ihre eingabe</p>";
    }
    


    




?>
    
<?php
    include_once 'footer.php';
?>