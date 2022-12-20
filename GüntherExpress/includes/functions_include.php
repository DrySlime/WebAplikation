<?php
function emptyInputSignup($email,$password,$passwordRepeat,$firstname,$lastname,$username){
    $result = false;
    if(empty($email) || empty($password) || empty($passwordRepeat) || empty($firstname) || empty($lastname) || empty($username)){
        $result=true;
    }else{
        $result=false;
    }
    return $result;
}

function invalidUid($username){
    if(!preg_match("/^[a-zA-Z0-9]*$/",$username)){
        $result=true;
    }else{
        $result = false;
    }
    return $result;
}
function invalidEmail($email){
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result=true;
    }else{
        $result = false;
    }
    return $result;
}
function passwordMatch($password,$passwordRepeat){
    if($password!==$passwordRepeat){
        $result=true;
    }else{
        $result = false;
    }
    return $result;
}
function uidExists($conn, $username,$email){
    $sql = "SELECT * FROM site_user WHERE user_uid = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt,"ss",$username,$email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        mysqli_stmt_close($stmt);
        return $row;
    }else{
        $result = false;
        mysqli_stmt_close($stmt);
        return $result;
    }
}
function emptyInputLogin($password,$username){
    $result = false;
    if( empty($password) || empty($username)){
        $result=true;
    }else{
        $result=false;
    }
    return $result;
}
function createUser($conn,$email,$password,$firstname,$lastname,$username){
    $sql = "INSERT INTO site_user (firstname, lastname, user_uid, email, user_password) VALUES (?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt,"sssss",$firstname,$lastname,$username,$email,$hashedPassword);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../signup.php?error=none");
    exit();
}
function loginUser($conn,$password,$username){
    $uidExists = uidExists($conn, $username,$username);

    if($uidExists===false){
        header("location: ../login.php?error=wronginput");
        exit();
    }

    $pwdHashed = $uidExists["user_password"];
    $checkPwd = password_verify($password,$pwdHashed);
    if($checkPwd === false){
        header("location: ../login.php?error=wronginput");
        exit();
    }else if($checkPwd=== true){
        session_start();
        $_SESSION["userid"]=$uidExists["id"];
        $_SESSION["useruid"]=$uidExists["user_uid"];
        header("location: ../account.php?");
        exit();
    }
    
}


function get___FromCatergory($conn,$whatYouNeed,$amount,$category,$shuffle){

    //Get all Data from a catagory
    //Hier nen Beispiel, du suchst die Bilder von der kategorie Schuhe
    //get___FromCatergory($conn,"product_image","Schuhe")

    $product_id= "SELECT id FROM product_category WHERE category_name = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$product_id)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt,"s", $category);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($resultData)){
        $product_id=$row["id"];
    }else{
        $result = false;
        return $result;
    }

    if($shuffle){
    $sql = "SELECT * FROM product WHERE product_category_id = ? LIMIT ?;";

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt,"ss",$product_id,$amount);
    }else{
        $sql = "SELECT * FROM product WHERE product_category_id = ? LIMIT ?;";

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt,"ss",$product_id,$amount);
    }
    mysqli_stmt_execute($stmt);
    
    $resultData = mysqli_stmt_get_result($stmt);
    
    

    //Error handling: falls man mehr produkte ausgegeben haben will als existieren
    if($amount>mysqli_num_rows($resultData)){
        $amount=mysqli_num_rows($resultData);
    }

    if(mysqli_num_rows($resultData)>0){
        
        for($i=0;$i<$amount;$i++){
            $row =mysqli_fetch_assoc($resultData);
            $itemAttribute[]=$row[$whatYouNeed];
        }
        mysqli_stmt_close($stmt);
        return $itemAttribute;
    }else{
        $result = false;
        mysqli_stmt_close($stmt);
        return $result;
    }

}

function getCategoryfromItem($conn,){
    
}

function getCategoryList($conn){

    //Get all names from the product_category table in an array

    $sql= "SELECT * FROM product_category;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($resultData)>0){

        while($row =mysqli_fetch_assoc($resultData)){
            $array[]=$row["category_name"];
        }
        mysqli_stmt_close($stmt);
        return $array;
    }else{
        $result = false;
        mysqli_stmt_close($stmt);
        return $result;
    }

}
function showCategoryList($conn){
    $arr = getCategoryList($conn);
    echo '<div class="category_list"><ul>';
    for($i=0;$i<count($arr);$i++){
        echo '<li>'.$arr[$i].'<br>';
    }
    echo '</ul></div>';

}

function totalAmount($conn,$categoryName){
    $product_id= "SELECT id FROM product_category WHERE category_name = ? ;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$product_id)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt,"s", $categoryName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($resultData)){
        $categoryID=$row["id"];
    }

    $product_id= "SELECT COUNT(*) as total FROM product WHERE product_category_id = ? ;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$product_id)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt,"s", $categoryID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($resultData)){
        $totalamount=$row["total"];
    }
    return $totalamount;
}
function getAllFromCategory($conn,$category,$amount){

    //returns a 3d Array filled with items
    // id=0
    // name=1
    // image=2
    // qty=3
    // price=4
    // description=5
    // Example: get image of the first item $itemArr[0][2];
    $product_id= "SELECT id FROM product_category WHERE category_name = ? ORDER BY RAND() LIMIT ? ;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$product_id)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt,"ss", $category,$amount);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($resultData)){
        $product_id=$row["id"];
    }else{
        $result = false;
        return $result;
    }


        $sql = "SELECT id FROM product WHERE product_category_id = ? ;";

        if(!mysqli_stmt_prepare($stmt,$sql)) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        
        mysqli_stmt_bind_param($stmt,"s",$product_id);

    mysqli_stmt_execute($stmt);
    
    $resultData = mysqli_stmt_get_result($stmt);
    
    




    if(mysqli_num_rows($resultData)>0){
        while($row =mysqli_fetch_assoc($resultData)){
            $itemId[]=$row["id"];
        }
    }else{
        $result = false;
        return $result;
    }

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
function showItems($conn,$amount,$categoryName){

    //Gibt $amount viele Attribute aus der Datenbank in einer
    //html gerechten sprache wieder zurück.
    
    $item=getAllFromCategory($conn,$amount,$categoryName,true);

    if($amount>count($item)){
        $amount=count($item);
    }

    for($i=0;$i<count($item);$i++){
        echo '
                
                    <li>
                    <a href="product.php?id='.$item[$i][0].'">
                    <div class="product_image">
                        <img src='.$item[$i][2].' alt="'.$item[$i][1].'.png" >
                    </div></a>';
    }
   

}

function searchbar($searchInput,$conn){
    #returns an array filled with ids of products.css inwhich the product name is like $searchbarInput

    $searchInput = "%".$searchInput."%";
    
    $sql = "SELECT id FROM product WHERE UPPER(product_name) LIKE UPPER(?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../category.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$searchInput);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($resultData)>0){
        while($row =mysqli_fetch_assoc($resultData)){
            $productIds[]=$row["id"];
        }
    }else{$productIds=null;}
    mysqli_stmt_close($stmt);
    return $productIds;
}
function searchItemInCategory($searchInput,$conn){
    #returns an array filled with ids of products.css inwhich the product name is like $searchbarInput

    $searchInput = "%".$searchInput."%";
    
    $sql = "SELECT id FROM product_category WHERE UPPER(category_name) LIKE UPPER(?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../category.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$searchInput);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($resultData)>0){
        while($row =mysqli_fetch_assoc($resultData)){
            $productIds[]=$row["id"];
        }
    }else{$productIds=null;}
    mysqli_stmt_close($stmt);
    return $productIds;
}
function returnParentIds($conn,$parentCategory){
    //returns all  parent Id in an array
    $sql = "SELECT parent_category_id FROM product_category WHERE category_name=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../category.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$parentCategory);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($resultData)>0){
        while($row =mysqli_fetch_assoc($resultData)){
            $parentId[]=$row["parent_category_id"];
        }
    }
    mysqli_stmt_close($stmt);
    return $parentId;
}
function returnChildrenIds($conn,$parentCategory){
    //returns all  child Ids in an array
    $parentId=returnParentIds($conn,$parentCategory);
    
    $sql = "SELECT id FROM product_category WHERE parent_category_id=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../category.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$parentId[0]);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);


    if(mysqli_num_rows($resultData)>0){
        while($row =mysqli_fetch_assoc($resultData)){
            $childId[]=$row["id"];
        }
        
        if($childId[0]==$parentId[0]){
        
            array_shift($childId);
        }
        
    }
    for($i=0;$i<count($childId);$i++){
        
        if($parentCategory==convertIdToCategoryName($conn,$childId[$i])){
            $tmp=$childId[$i];
            array_shift($childId);
            $childId[0]=$tmp;
        }
    }
    mysqli_stmt_close($stmt);
    return $childId;
}
function convertIdToCategoryName($conn,$id){
    //converts an id into a categoryname
    //returns a string
    $sql = "SELECT category_name FROM product_category WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../category.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($resultData)>0){
        $row =mysqli_fetch_assoc($resultData);
        $categoryName=$row["category_name"];
    }
    mysqli_stmt_close($stmt);
    return $categoryName;

}
function convertCategoryNameToID($conn,$categoryName){
    //converts an categoryName into an id
    //returns a string
    $sql = "SELECT id FROM product_category WHERE category_name=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../category.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$categoryName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($resultData)>0){
        $row =mysqli_fetch_assoc($resultData);
        $categoryName=$row["id"];
    }
    mysqli_stmt_close($stmt);
    return $categoryName;

}

function getAllAttributesFromItemViaID($ItemID,$conn){
    $sql = "SELECT * FROM product WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../category.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$ItemID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($resultData)>0){
        while($row =mysqli_fetch_assoc($resultData)){
            $item[]=$row["parent_category_id"];
        }
    }
    mysqli_stmt_close($stmt);
    return $item;

}

function getItemIdsFromCategory($conn,$CategoryID,$amount){
    #returns $amount many ProductIds in an array from a categoryID

    $sql = "SELECT id FROM product WHERE product_category_id = ? ORDER BY rand() LIMIT  ?;";
    
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../category.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"ss",$CategoryID,$amount);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($resultData)>0){
        while($row =mysqli_fetch_assoc($resultData)){
            $itemIDs[]=$row["id"];
        }
    }else{
        $itemIDs=null;
    }
    mysqli_stmt_close($stmt);
    return $itemIDs;

    

}
function getImage($conn,$productID){
    $sql = "SELECT product_image FROM product WHERE id=$productID;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    while($row =mysqli_fetch_assoc($resultData)){
        $img=$row["product_image"];
    }

    return $img;
}
function getRandomItems($conn,$amount){
    $sql = "SELECT * FROM product ORDER BY rand() LIMIT ?;";
    $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"s",$amount);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        
            while($row =mysqli_fetch_assoc($resultData)){
                $array[]=$row["id"];
                $array[]=$row["product_name"];
                $array[]=$row["description"];
                $array[]=$row["product_image"];
                $array[]=$row["price"];
                

                $allItems[]=$array; 
                unset($array);
            }
        
        return $allItems;
        
}

function parentCategoryAmount($conn,$var){
        //returns an integer of the total parentcategories
        $bool=true;
        $count=0;
        while($bool){
            $sql = "SELECT * FROM product_category WHERE id = ? AND parent_category_id = ?;";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("location: ../index.php?error=stmtfailed");
                exit();
            }

            mysqli_stmt_bind_param($stmt,"ss",$var,$var);
            mysqli_stmt_execute($stmt);

            $resultData = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($resultData)>0){
                $var++;
                $count++;
            }else{
                $bool = false;
            }
        }
        mysqli_stmt_close($stmt);
        return $count;
}

//Username wird in UserId umgewandelt
function getUserIdFromUserName($conn, $userName){

    $sql = "SELECT * FROM site_user WHERE user_uid = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$userName,);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($resultData)["id"];
}
function invalidDiscountrate($discount){
    if(strlen($discount)>2 || !preg_match("/^[0-9]*$/",$discount)){
        echo strlen($discount);
        return true;
    }
    return false;
}
function createSale($conn,$categoryID,$title,$description,$discount,$startDate,$endDate){
    #create promotion, create promotion category
    if (saleTitleExists($conn,$title)){
        header("location: ../sale_admin.php?error=titleExists");
        exit();
    }
    $sql = "INSERT INTO promotion (promotion_name, description, discount_rate, star_date, end_date) VALUES (?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }



    mysqli_stmt_bind_param($stmt,"sssss",$title,$description,$discount,$startDate,$endDate);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    $sql = "SELECT id FROM promotion WHERE promotion_name=?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$title);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $promotionID= mysqli_fetch_assoc($resultData)["id"];

    mysqli_stmt_close($stmt);


    $sql = "INSERT INTO promotion_category (category_id,promotion_id) VALUES (?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"ss",$categoryID,$promotionID);

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../sale_admin.php?error=none");
    exit();
}
function createCategory($conn,$title,$parentID){

    $sql = "INSERT INTO product_category (parent_category_id, category_name) VALUES (?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../category_admin.php?error=stmtfailed");
        exit();
    }



    mysqli_stmt_bind_param($stmt,"ss",$parentID,$title);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

}
function createProduct($conn,$categoryID,$name,$productImage,$description,$price,$inStock){

    $sql = "INSERT INTO product (product_name,product_category_id,product_image,qty_in_stock,price,description) VALUES (?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../product_admin.php?error=stmtfailed");
        exit();
    }



    mysqli_stmt_bind_param($stmt,"ssssss",$name,$categoryID,$productImage,$inStock,$price,$description);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

}
function createShippingMethod($conn,$name,$price){

    $sql = "INSERT INTO shipping_method (shipping_name, shipping_price) VALUES (?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../shippingmethod_admin.php?error=stmtfailed");
        exit();
    }



    mysqli_stmt_bind_param($stmt,"ss",$name,$price);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

}
function invalidDate($startDate,$endDate){
    if ($endDate<=date("Y-m-d")||$startDate>$endDate){
        return true;
    }
    return false;
}

function updateSale($conn,$categoryID,$title,$description,$discount,$startDate,$endDate,$promoID){
    #create promotion, create promotion category

    $sql = "UPDATE promotion SET promotion_name=?, description=?, discount_rate=?, star_date=?, end_date=?  WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }



    mysqli_stmt_bind_param($stmt,"ssssss",$title,$description,$discount,$startDate,$endDate,$promoID);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    $sql = "SELECT id FROM promotion WHERE promotion_name=?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$title);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $promotionID= mysqli_fetch_assoc($resultData)["id"];

    mysqli_stmt_close($stmt);

    $sql = "UPDATE promotion_category SET category_id=?,promotion_id=? WHERE promotion_id=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"sss",$categoryID,$promotionID,$promotionID);

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../sale_admin.php?error=none");
    exit();
}
function updateCategory($conn,$parentID,$title,$id){
    #create promotion, create promotion category
    $sql = "UPDATE product_category SET parent_category_id=?, category_name=? WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }



    mysqli_stmt_bind_param($stmt,"sss",$parentID,$title,$id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../category_admin.php?error=none");
    exit();
}

function  updateProduct($conn,$categoryID,$name,$description,$productImage,$price,$inStock,$productID){
    #create promotion, create promotion category
    $sql = "UPDATE product SET product_name=?, product_category_id=?, product_image=?, qty_in_stock=?, price=?, description=? WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../product_admin.php?error=stmtfailed");
        exit();
    }



    mysqli_stmt_bind_param($stmt,"sssssss",$name,$categoryID,$productImage,$inStock,$price,$description,$productID);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../product_admin.php?error=none");
    exit();
}

function updateShippingMethod($conn,$name,$price,$id){
    #create promotion, create promotion category
    $sql = "UPDATE shipping_method SET shipping_name=?, shipping_price=? WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../shippingmethod_admin.php?error=stmtfailed");
        exit();
    }



    mysqli_stmt_bind_param($stmt,"sss",$name,$price,$id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../shippingmethod_admin.php?error=none");
    exit();
}

function saleTitleExists($conn, $saleTitle){
    $sql = "SELECT promotion_name FROM promotion WHERE promotion_name = ? ;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt,"s",$saleTitle);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if(mysqli_fetch_assoc($resultData)){
        mysqli_stmt_close($stmt);
        return true;
    }else{
        $result = false;
        mysqli_stmt_close($stmt);
        return $result;
    }

    
}

# Für die Account-Seite

function getaccountData($conn){

    $userid = $_SESSION['userid'];

    $sql = "SELECT user_uid, firstname, lastname, email, user_password FROM site_user WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$userid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return mysqli_fetch_assoc($resultData);
}

function getDefUserAddressData($conn){

    $userid = $_SESSION['userid'];


    $sql = "SELECT * FROM address INNER JOIN user_address ON address.id = user_address.address_id WHERE user_id = ? AND user_address.is_default_address = 1";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$userid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    
    return mysqli_fetch_assoc($resultData);
}

function getUserAddressDataWODef($conn){

    $userid = $_SESSION['userid'];


    $sql = "SELECT * FROM address INNER JOIN user_address ON address.id = user_address.address_id WHERE user_id = ? AND user_address.is_default_address = 0";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$userid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    
    return $resultData;
}

function changeAccount($conn,$username, $name, $surname, $email,$newPassword){
    $sql = "UPDATE site_user SET user_uid = ?, firstname = ?, lastname = ?, email = ? WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../account.php?error=stmtfailed");
        exit();
    }
    $userid = $_SESSION['userid'];
    mysqli_stmt_bind_param($stmt,"sssss",$username,$name,$surname,$email,$userid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    $_SESSION['useruid'] = $username;
    if ($newPassword != null) {
        changePassword($conn,$newPassword);
    }
}

function changePassword($conn,$password){
    $sql = " UPDATE site_user SET user_password = ? WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../account.php?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
    $userid = $_SESSION['userid'];

    mysqli_stmt_bind_param($stmt,"ss",$hashedPassword,$userid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

}

function rightPassword($conn,$password){
    $username = $_SESSION['useruid'];
    $uidExists = uidExists($conn, $username,$username);

    if($uidExists===false){
        header("location: ../profile.php?error=wronginput");
        exit();
    }

    $pwdHashed = $uidExists["user_password"];
    $checkPwd = password_verify($password,$pwdHashed);
    return $checkPwd;

}

function rightEmail($conn,$email){
    $username = $_SESSION['useruid'];
    $uidExists = uidExists($conn, $username,$username);
    if($uidExists===false){
        header("location: ../account.php?error=wronginput");
        exit();
    }
    $checkEmail = $uidExists["email"];
    return $checkEmail == $email;
}

function addAddress($conn, $street, $houseno, $city, $postalCode){
    $sql = " INSERT INTO address (street_number, address_line1, city, postal_code) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../account.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt,"ssss",$houseno,$street,$city,$postalCode);
    mysqli_stmt_execute($stmt);
    bindAddressToUser($conn, $street, $houseno, $city, $postalCode);
    

    mysqli_stmt_close($stmt);
}

function bindAddressToUser($conn, $street, $houseno, $city, $postalCode){
    $userid = $_SESSION['userid'];
    $address = getAddressIDByData($conn, $street, $houseno, $city, $postalCode);
    $addressid = $address['id'];
    if (alreadyBindAddress($conn,$addressid,$userid)) {
        header("location: ../account.php?error=none");
        exit();
    }
    else {
        $sql = "INSERT INTO user_address (user_id, address_id) VALUES (?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../account.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt,"ss",$userid,$addressid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    

    header("location: ../account.php?error=none");
    exit();
    }
    
}

function unbindAddress($conn,$addressid){
    $userid = $_SESSION['userid'];

    $sql = "DELETE FROM user_address WHERE user_id = ? AND address_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt,"ss",$userid,$addressid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    

    header("location: ../profile.php?error=none");
    exit();
} 

function alreadyBindAddress($conn, $addressid,$userid){
    $sql = "SELECT * FROM user_address WHERE address_id = ? AND user_id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../account.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt,"ss",$addressid,$userid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return true;
    }else{
        return false;
    }
    mysqli_stmt_close($stmt);

}

function getAddressIDByData($conn,$street, $houseno, $city, $postalCode){
    

    $sql = "SELECT * FROM address WHERE street_number = ? AND address_line1 = ? AND city = ? AND postal_code = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"ssss",$houseno, $street, $city, $postalCode);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    
    return $resultData -> fetch_assoc();
}

function getPersonalOrderIDsDescending($conn){

    $userid = $_SESSION['userid'];


    $sql = "SELECT id FROM shop_order WHERE siteuser_id = ? ORDER BY id DESC";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$userid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    
    return $resultData;
}

function getPersonalOrderDataByID($conn,$orderID){

    $sql = "SELECT * FROM shop_order INNER JOIN site_user ON shop_order.siteuser_id = site_user.id INNER JOIN payment_type ON shop_order.payment_method_id = payment_type.id INNER JOIN address ON shop_order.shipping_address_id = address.id  INNER JOIN shipping_method ON shop_order.shipping_method_id = shipping_method.id INNER JOIN order_status ON shop_order.order_status_id = order_status.id  WHERE shop_order.id=?";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$userid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    
    return $resultData-> fetch_assoc();
}

function getObjectOrderDataByID($conn,$orderID){

    $sql = "SELECT product.product_name, product.product_image, order_line.qty, product.price FROM order_line INNER JOIN product ON order_line.product_item_id = product.id WHERE order_line.order_id=?";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$userid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    
    return $resultData;
}

function deactivateUser($conn){
    $userid = $_SESSION['userid'];
    $sql = "UPDATE site_user SET active = 0 WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$userid);
    mysqli_stmt_execute($stmt);

    
    mysqli_stmt_close($stmt);
}

