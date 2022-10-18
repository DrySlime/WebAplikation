<?php
include_once 'header.php';
include_once 'includes/dbh_include.php';
require_once 'includes/functions_include.php';
?>

<?php
        //ID des Produkts wird aus der URL extrahiert
        $productID = getURLParameter()['pid'];
        $productData = getProductData($conn, $productID);
        
        if(is_null($productData)){
                echo "<p>Dieses Produkt existiert leider nicht!</p>";
                exit();
        }

        //Produktdaten werden zur anzeige gespeichert
        $aName = $productData["Name"];
        $aBeschreibung = $productData["Beschreibung"];
        $aPreis = $productData["Preis"];
        // Hier noch ein Bild hinzufügen
?>


<section>
        <h2> <?php echo $aName ?> </h2>
        <?php echo $aBeschreibung ?> <br>
        <b><?php echo $aPreis ?> Euro</b>
        <img src=""> <br>
        <button type="button"> In den Warenkorb </button>
</section>
