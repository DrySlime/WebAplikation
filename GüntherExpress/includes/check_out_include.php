<?php
function getShippingPrice($conn, $id){
    $sql = "SELECT * FROM shipping_method WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s", $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($resultData)["shipping_price"];
}

function showAddress($address){
    
    echo "<p>"."Straße: ".$address["address_line1"]."</p>";
    echo "<p>"."Hausnummer: ".$address["street_number"]."</p>";
    echo "<p>"."Stadt: ".$address["city"]."</p>";
    echo "<p>"."PLZ: ".$address["postal_code"]."</p>";
        
}

function showPaymentMethod($conn, $payment){

    $paymentType = getPaymentType($conn, $payment["payment_type_id"]);
        
    echo "<p>"."Zahlungsart: ".$paymentType["value"]."</p>";
    echo "<p>"."Anbieter: ".$payment["provider"]."</p>";
    echo "<p>"."Kontonummer: ".$payment["account_number"]."</p>";
    echo "<p>"."Ablaufdatum: ".$payment["expiry_date"]."</p>";       


}

function getPaymentType($conn, $id){
    $sql = "SELECT * FROM payment_type WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$id,);
    mysqli_stmt_execute($stmt);

    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

}

function showShippingMethod($method){

    echo "<p>"."Versand: ".$method["shipping_name"]."</p>";
    echo "<p>"."Kosten: ".$method["shipping_price"]." Euro</p>";
    

}

?>