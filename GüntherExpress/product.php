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


<section>
        <h2> <?php echo $name ?> </h2>
        <?php echo $description ?> <br>
        <b><?php echo $price ?> Euro</b>
        <img src=<?php echo $image;?>> <br>

        
        <b> Menge: </b>
        <select>
                <?php
                for ($i = 0; $i <= $quantaty; $i++) {
                        echo "<option value=".$i.">".$i."</option>";
                    }
                ?>
        </select>
        <br>
        <button type="button"> In den Warenkorb </button>

</section>

<?php
include_once 'footer.php';
?>