<?php
function getAllFromProductID($conn,$productID){

    $sql = "SELECT * FROM product WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$productID);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($resultData)>0){
        while($row =mysqli_fetch_assoc($resultData)){

            $itemAttribute["id"]=$row["id"];
            $itemAttribute["product_name"]=$row["product_name"];
            $itemAttribute["product_image"]=$row["product_image"];
            $itemAttribute["qty_in_stock"]=$row["qty_in_stock"];
            $itemAttribute["price"]=$row["price"];
            $itemAttribute["description"]=$row["description"];
            $itemAttribute["product_category_id"]=$row["product_category_id"];
            $itemArr[]=$itemAttribute;
            unset($itemAttribute);
        }
    }else{
        $itemArr=null;
    }
    mysqli_stmt_close($stmt);
    return $itemArr;
}