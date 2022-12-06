<?php
function convertCategoryNameToID($conn,$name){
    $sql = "SELECT id FROM product_category WHERE category_name =?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$name);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($resultData)>0){
        $row =mysqli_fetch_assoc($resultData);
        $id=$row["id"];

    }else{
        $id=null;
    }
    mysqli_stmt_close($stmt);
    return $id;
}
function productsSearchbar($conn,$searchTerm, $categoryID){
    $searchTerm = "%".$searchTerm."%";
    $sql = "SELECT * FROM product WHERE product_category_id=? AND UPPER(product_name) LIKE UPPER(?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"ss",$categoryID, $searchTerm);
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
            $itemArr[]=$itemAttribute;
            unset($itemAttribute);
        }
    }else{
        $itemArr=null;
    }
    mysqli_stmt_close($stmt);
    return $itemArr;
}
function getAllFromProductIDs($conn, $IDArr){



    $sql = "SELECT * FROM product WHERE id = ?;";

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    for($i=0;$i<count($itemId);$i++){
        mysqli_stmt_bind_param($stmt,"s",$itemId[$i]);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $row =mysqli_fetch_assoc($resultData);

        $itemAttribute["id"]=$row["id"];
        $itemAttribute["product_name"]=$row["product_name"];
        $itemAttribute["product_image"]=$row["product_image"];
        $itemAttribute["qty_in_stock"]=$row["qty_in_stock"];
        $itemAttribute["price"]=$row["price"];
        $itemAttribute["description"]=$row["description"];
        $itemArr[]=$itemAttribute;
        unset($itemAttribute);
    }

    mysqli_stmt_close($stmt);


    return $itemArr;
}