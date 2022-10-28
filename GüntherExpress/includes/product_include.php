
<?php

//URl-Parameter werden ausgelesen
function getURLParameter(){
    $url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);
    return $params;
}

//Produktdaten werden aus der Datenbank aufgerufen
function getProductData($conn, $productID){

    $sql = "SELECT * FROM product WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$productID,);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($resultData);
}

function show_product($name, $description, $price, $image){

    echo 
    '<h2>'  .$name.  '</h2>
     <div>'  .$description.  '</div> <br>
     <div>'  .$price.  'Euro</div>
     <img src='  .$image.'> <br>';

}

?>