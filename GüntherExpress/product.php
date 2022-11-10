<?php
include_once 'header.php';
include_once 'includes/dbh_include.php';
require_once 'includes/product_include.php';
?>

<?php
        //ID des Produkts wird aus der URL extrahiert
        $productID = $_GET["id"];
        $productData = getProductData($conn, $productID);
        
        
        if(is_null($productData)){
                echo "<p>Dieses Produkt existiert leider nicht!</p>";
                exit();
        }

        //Produktdaten werden zur anzeige gespeichert
        $name = $productData["product_name"];
        $description = $productData["description"];
        $price = $productData["price"];
        $image = $productData["product_image"];
        $quantaty = $productData["qty_in_stock"];
        
?>

<html>

<head>
        <link rel="stylesheet" href="../CSS/product.css">
</head>

<body>
        <div class="product-background">
                <!-- Darstellung des Produkts -->
                <div class="product-container">
                
                        <?php showProductImage($conn, $productID); ?>

                        <div class="product-right-side">
                        <?php showProduct($conn, $productID); ?>
                        

                        <!-- Select Tag um die Menge auszuwählen -->
                        <p class="product-qty-text"> Menge: </p>
                        <select class="product-qty-selection" id="selectQuantaty" onchange="checkValue(this)">
                                <?php
                                for ($i = 0; $i <= $quantaty; $i++) {
                                        echo "<option value=".$i.">".$i."</option>";
                                }
                                ?>
                        </select>
                        <br>

                        <!-- Ausgewählte Menge wird im Ruckgabeformula gespeichert -->
                        

                        <!-- Formula um DAten an den Server zu schicken -->
                        
                        <form action="shopping_cart_insert.php" onsubmit='getSelectValue()' method="post">
                                <input type="hidden" name="pID" value=<?php echo "$productID" ?>>
                                <input type="hidden" name="pName" value=<?php echo "$name" ?>>
                                <input type="hidden" name="quantaty" id="buyQuantaty">
                                <input type="hidden" name="image" value=<?php echo "$image" ?>>
                                <input class="product-shopping-cart-btn" type="submit" value="In den Warenkorb" name="into_shopping_cart" id="into_shopping_cart" disabled="true">
                        </form> 
                        </div>
                                   
                </div>
        </div>

        <script> 
                function getSelectValue(){
                        document.getElementById("buyQuantaty").value = document.getElementById("selectQuantaty").value; 
                }

                function checkValue(object){
                        if(object.value == 0){
                                document.getElementById("into_shopping_cart").disabled = true ;
                        }else{
                                document.getElementById("into_shopping_cart").disabled = false ;
                        }    
                }
        </script>
</body>
        
</html>


<?php
include_once 'footer.php';
?>