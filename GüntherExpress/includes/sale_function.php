<?php
function onSale($conn,$productID){
    //returns true if product is on sale
    $sql = "SELECT promotion_id  FROM promotion_category WHERE product_id=? ;";
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
        return true;
        
        
    }else{return false;}
    

    
}
function updatePrice($conn, $productID){
    //wir finden raus welche promotion aktiv ist

    $sql = "SELECT promotion_id  FROM promotion_category WHERE product_id=? ;";
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
        $row =mysqli_fetch_assoc($resultData);
        $promotionID=$row["promotion_id"];
        
        
    }else{$promotionID=null;}
    mysqli_stmt_close($stmt);

    //_______wir holen die discount rate in einer variabel
    
    $sql = "SELECT discount_rate FROM promotion WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../category.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$promotionID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($resultData)>0){
        while($row =mysqli_fetch_assoc($resultData)){
            $discount_rate=$row["discount_rate"];
        }
    }else{$discount_rate=null;}
    mysqli_stmt_close($stmt);
    
    
    //wir schauen nach was der alte preis war
    $sql = "SELECT price FROM product WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../category.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$productID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($resultData)>0){
        while($row =mysqli_fetch_assoc($resultData)){
            $oldPrice=$row["price"];
        }
    }else{$oldPrice=null;}
    mysqli_stmt_close($stmt);

    $newPirce=$oldPrice*(1-$discount_rate);
    

    return $newPirce;
}

?>