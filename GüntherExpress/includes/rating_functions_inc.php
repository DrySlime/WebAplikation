<?php 

function getRating($conn,$productID){

    #returns a double value between 1-5

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
function getAllFromReview(){
    #returns a 2d Array filled with all review informations

}

function getOwnProductReview($conn,$product){
    #shows review information for one product for the person
        $sql = "SELECT * FROM user_review WHERE ordered_product_id = ? AND siteuser_id = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../account.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $_SESSION['userid'], $product);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        header("location: ../account.php?error=none")
}


function addReview($conn,$product,$rating){
    #adds review information for one product
    $sql = "INSERT INTO user_review (siteuser_id, ordered_product_id, rating_value, comment) VALUES (?,?,?,"save me");";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../account.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sss", $_SESSION['userid'], $product, $rating);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        header("location: ../account.php?error=none")
}

?>