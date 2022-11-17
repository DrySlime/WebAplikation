<?php
include_once 'header.php';
include_once 'includes/dbh_include.php';
require_once 'includes/product_include.php';
require_once 'includes/review_functions.php';
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
        $name = $productData["product_name"];
        $description = $productData["description"];
        $price = $productData["price"];
        $image = $productData["product_image"];
        $quantaty = $productData["qty_in_stock"];
        
?>


<div>
        <!-- Darstellung des Produkts -->
        <div>
                <div>
                <?php showProduct($conn, $productID); ?>
                </div>

                <!-- Select Tag um die Menge auszuwählen -->
                <div> Menge: </div>
                <select id="selectQuantaty" onchange="checkValue(this)">
                        <?php
                        for ($i = 0; $i <= $quantaty; $i++) {
                                echo "<option value=".$i.">".$i."</option>";
                        }
                        ?>
                </select>
                <br>
                <div name="avgBewertung">
                        <!-- fürs erste will ich einfach nur einen zahlenwwert zwischen 1-5 berechnen und ausgeben -->
                        BEWERTUNG <?php echo getAvrgRating($conn,$productID)?> Sterne <br>

                </div>
                <div name="kundenbewertungen">
                    <?php
                        $nutzer=getProductReview($conn,3,2,$productID);
                        if($nutzer!=0){
                            for($i=0;$i<count($nutzer);$i++){
                                echo "
                                    <div id='kommentar".$i."' name='kommentarbox'>
                                        <h1>".$nutzer[$i]['username']."</h1>
                                        Bewertung: ".$nutzer[$i]['rating_value']."<br>
                                        Kommentar: ".$nutzer[$i]['comment']."
                                    </div>
                                ";
                            }
                        }

                    ?>
                </div>

                <!-- Ausgewählte Menge wird im Ruckgabeformula gespeichert -->
                

                <!-- Formula um DAten an den Server zu schicken -->
                
                <form action="shopping_cart_insert.php" onsubmit='getSelectValue()' method="post">
                        <input type="hidden" name="pID" value=<?php echo "$productID" ?>>
                        <input type="hidden" name="pName" value=<?php echo "$name" ?>>
                        <input type="hidden" name="quantaty" id="buyQuantaty">
                        <input type="hidden" name="userID" value=<?php echo "$userID" ?>>
                        <input type="hidden" name="image" value=<?php echo "$image" ?>>
                        <input type="submit" value="In den Warenkorb" name="into_shopping_cart" id="into_shopping_cart">
                </form>       
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

<?php
include_once 'footer.php';
?>