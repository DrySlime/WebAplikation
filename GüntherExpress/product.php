<?php
include_once 'header.php';
include_once 'includes/dbh_include.php';
require_once 'includes/functions_include.php';
?>

<?php
        //ID des Produkts wird aus der URL extrahiert
        $productID = getURLParameter()['pid'];
      
        //Produktdaten werden aus der Datenbank aufgerufen
        $sql = "SELECT * FROM Artikel WHERE ArtikelID = ?;";
        $stmt = mysqli_stmt_init($conn);

        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"s",$productID,);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($resultData);

        //Produktdaten werden zur anzeige gespeichert
        $aName = $row["Name"];
        $aBeschreibung = $row["Beschreibung"];
        $aPreis = $row["Preis"];
        // Hier noch ein Bild hinzufügen
?>


<section>
        <h2> <?php echo $aName ?> </h2>
        <?php echo $aBeschreibung ?> <br>
        <b><?php echo $aPreis ?></b>
        <img src=""> <br>
        <button type="button"> In den Warenkorb </button>
</section>