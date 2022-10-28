<?php
include_once 'header.php';
include_once 'includes/dbh_include.php';
require_once 'includes/product_include.php';
?>

<?php
        //ID des Produkts wird aus der URL extrahiert
        $productID = $_GET["id"];
        $productData = getProductData($conn, $productID);
        $userID = $_SESSION['useruid'];
        
        if(is_null($productData)){
                echo "<p>Dieses Produkt existiert leider nicht!</p>";
                exit();
        }

        //Produktdaten werden zur anzeige gespeichert
        $name = $productData["name"];
        $description = $productData["description"];
        $price = $productData["price"];
        $image = $productData["product_image"];
        $quantaty = $productData["qty_in_stock"];
        
?>


<div>
        <!-- Darstellung des Produkts -->
        <div>
                <div>
                <?php show_product($name, $description, $price, $image); ?>
                </div>

                <!-- Select Tag um die Menge auszuwählen -->
                <div> Menge: </div>
                <select id="selectQuantaty">
                        <?php
                        for ($i = 0; $i <= $quantaty; $i++) {
                                echo "<option value=".$i.">".$i."</option>";
                        }
                        ?>
                </select>
                <br>

                <!-- Ausgewählte Menge wird im Ruckgabeformula gespeichert -->
                <script> 
                function getSelectValue(){
                        document.getElementById("buyQuantaty").value = document.getElementById("selectQuantaty").value; 
                }
                </script>

                <!-- Formula um DAten an den Server zu schicken -->
                
                <form action="shopping_cart_submit.php" onsubmit='getSelectValue()' method="post">
                        <input type="hidden" name="pID" value=<?php echo "$productID" ?>>
                        <input type="hidden" name="pName" value=<?php echo "$name" ?>>
                        <input type="hidden" name="quantaty" id="buyQuantaty">
                        <input type="hidden" name="userID" value=<?php echo "$userID" ?>>
                        <input type="hidden" name="image" value=<?php echo "$image" ?>>
                        <input type="submit" value="In den Warenkorb" name="into_shopping_cart">
                </form>       
        </div>
</div>

<?php
include_once 'footer.php';
?>