<?php

function isValidPurchase($conn,$productID){
    #checks the Database wether the user has purchased the product ($productID)
    return false;
}
 function getAvrgRating($conn, $productID){
    #this returns the average rating of the product
    #returns a double value between 1-5 which represents the rating from the $productID

    $rating=0;

    $sql = "SELECT id FROM order_line WHERE product_item_id =?;";
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
                $orderLine[]=$row["id"];;
            }
        }else{
            $orderLine=null;
        }
        mysqli_stmt_close($stmt);
        
            
    if($orderLine!=null){
        for($i=0;$i<count($orderLine);$i++){
            $sql = "SELECT rating_value FROM user_review WHERE ordered_product_id =?;";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt,$sql)){
                    header("location: ../index.php?error=stmtfailed");
                    exit();
            }
            mysqli_stmt_prepare($stmt,$sql);
            mysqli_stmt_bind_param($stmt,"s",$orderLine[$i]);
            mysqli_stmt_execute($stmt);
            $resultData = mysqli_stmt_get_result($stmt);
                
            $row =mysqli_fetch_assoc($resultData);
            $ratingArr[]=$row["rating_value"];  
        }
        
        foreach($ratingArr as $singleRating){
            $rating+=$singleRating;
        }
        $rating=$rating/count($ratingArr);        
    }
    return $rating;   
}

function getReviewableProducts($conn,$uid){
    #1 wir gehen alle shop_order durch die zur userid gehört und nehmen da alle ids

    #2 diese shop order ids werden nun in orderline benutzt, hier suchen wir damit dann,
    # die product id und speichern die id dazugehörige orderline id

    #returns an array which contains a product id and a orderline_id of all the products a user can review

    

    $sql = "SELECT id FROM shop_order WHERE user_id =?;";
    $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"s",$uid);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($resultData)>0){
            while($row =mysqli_fetch_assoc($resultData)){
                $shopOrder[]=$row["id"];;
            }
        }else{
        $shopOrder=null;
        }
    mysqli_stmt_close($stmt);
    if($shopOrder!=null){
        $anzahlOrder=count($shopOrder);
        for($i=0;$i<$anzahlOrder;$i++){
            $sql = "SELECT id, product_item_id FROM order_line WHERE order_id =?;";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("location: ../index.php?error=stmtfailed");
                exit();
            }
            mysqli_stmt_prepare($stmt,$sql);
            mysqli_stmt_bind_param($stmt,"s",$shopOrder[$i]);
            mysqli_stmt_execute($stmt);
            $resultData = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($resultData)>0){
                $row =mysqli_fetch_assoc($resultData);
                $orderLineID=$row["id"];
                $productID=$row["product_item_id"];
                $returnArr["orderlineID"]=$orderLineID;
                $returnArr["productID"]=$productID;
                $x[]=$returnArr;
                unset($returnArr);

            }else{
                $x=null;
                $shopOrder=null;
            }
        }
    }else{$x=null;}
    
    return $x;
    
}
#TODO get x amount of ratings and comments from database sorted by ratevalue... display x amount like:
#TODO CHRIS gibt 5 Sterne.
#TODO Kommentar: gefällt mir perfekt
#TODO If button is pressed load and display next y many comments
function getProductReview($conn,$amount,$sortBy,$productID){
    #sortby 1= ascending, 2= descending

    $sql = "SELECT id FROM order_line WHERE product_item_id =?;";
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
            $orderLine[]=$row["id"];;
        }
    }else{
        $orderLine=null;
    }
    mysqli_stmt_close($stmt);
    #-----------------
    if($orderLine!=null){
        for($i=0;$i<count($orderLine);$i++){
            if($sortBy==1){
                $sql = "SELECT comment, rating_value, user_id FROM user_review WHERE ordered_product_id =? ORDER BY rating_value ASC LIMIT $amount;";

            }else if($sortBy==2){
                $sql = "SELECT comment, rating_value, user_id FROM user_review WHERE ordered_product_id =? ORDER BY rating_value DESC LIMIT $amount ;";

            }
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("location: ../index.php?error=stmtfailed");
                exit();
            }
            mysqli_stmt_prepare($stmt,$sql);
            mysqli_stmt_bind_param($stmt,"s",$orderLine[$i]);
            mysqli_stmt_execute($stmt);
            $resultData = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($resultData)>0){
                $row =mysqli_fetch_assoc($resultData);

                $data["comment"]=$row["comment"];
                $data["rating_value"]=$row["rating_value"];

                $data["username"]=getUsername($conn,$row["user_id"]);
                $nutzer[]=$data;
                unset($data);

            }else{$nutzer=null;}
        }
        return $nutzer;
    }

}
function getUsername($conn,$userID){
    $sql = "SELECT user_uid FROM site_user WHERE id =$userID;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($resultData)>0) {
        $row = mysqli_fetch_assoc($resultData);
        $username = $row["user_uid"];
        return $username;
    }
}
?>