<?php
include_once 'header.php';
include_once 'includes/dbh_include.php'
?>

<?php

    //URl-Parameter werden ausgelesen
    $url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);


        
    $sql = "SELECT * FROM Artikel WHERE ArtikelID = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt,"s",$params['pid'],);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($resultData);

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