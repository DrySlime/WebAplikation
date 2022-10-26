<?php
include_once 'header.php';
include_once 'includes/dbh_include.php';
require_once 'includes/product_include.php';
?>

<?php
        //ID des Produkts wird aus der URL extrahiert
        $productID = $_GET["pid"];
        $productData = getProductData($conn, $productID);
        
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


<section>
        <h2> <?php echo $name ?> </h2>
        <?php echo $description ?> <br>
        <b><?php echo $price ?> Euro</b>
        <img src=<?php echo $image;?>> <br>

        
        <b> Menge: </b>
        <select id="selectQuantaty">
                <?php
                for ($i = 0; $i <= $quantaty; $i++) {
                        echo "<option value=".$i.">".$i."</option>";
                    }
                ?>
        </select>
        <br>

        <script> 
        function getSelectValue(){
                document.getElementById("buyQuantaty").value = document.getElementById("selectQuantaty").value; 
        }
        </script>

        <form action="shopping_cart_submit.php" onsubmit='getSelectValue()' method="post">
                <input type="hidden" name="pID" value=<?php echo "$productID" ?>>
                <input type="hidden" name="quantaty" id="buyQuantaty">
                <input type="hidden" name="userID" value="1">
                <input type="submit" value="In den Warenkorb" name="into_shopping_cart">
        </form>

</section>

<?php
include_once 'footer.php';
?>