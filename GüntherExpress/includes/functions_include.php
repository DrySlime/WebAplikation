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
        return $row;
    }else{
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);


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
        header("location: ../index.php?");
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
        return $itemAttribute;
    }else{
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
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
        return $array;
    }else{
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}
function showCategoryList($conn){
    $arr = getCategoryList($conn);
    echo '<div class="category_list"><ul>';
    for($i=0;$i<count($arr);$i++){
        echo '<li>'.$arr[$i].'<br>';
    }
    echo '</ul></div>';

}


function getAllFromCategory($conn,$amount,$category,$shuffle){

    //returns a 3d Array filled with items
    // id=0
    // name=1
    // image=2
    // qty=3
    // price=4
    // description=5
    // Example: get image of the first item $itemArr[0][2];
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
        $sql = "SELECT id FROM product WHERE product_category_id = ? ORDER BY rand() LIMIT ?;";

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt,"ss",$product_id,$amount);
    }else{
        $sql = "SELECT id FROM product WHERE product_category_id = ? LIMIT ?;";

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
        
        $itemAttribute[]=$row["id"];
        $itemAttribute[]=$row["product_name"];
        $itemAttribute[]=$row["product_image"];
        $itemAttribute[]=$row["qty_in_stock"];
        $itemAttribute[]=$row["price"];
        $itemAttribute[]=$row["description"];
        $itemArr[]=$itemAttribute;
        unset($itemAttribute);
    }
    
    mysqli_stmt_close($stmt);


    return $itemArr;
}
function showExamples($conn,$amount,$category){

    //Gibt $amount viele Attribute aus der Datenbank in einer
    //html gerechten sprache wieder zurück.
    
    $item=getAllFromCategory($conn,$amount,$category,true);

    if($amount>count($item)){
        $amount=count($item);
    }

    for($i=0;$i<count($item);$i++){
        echo '<div class="product">
            <li><div class="product_name product_info">Produktname:'.$item[$i][1].'</div>
            <a href="product.php?='.$item[$i][0].'">
            <div class="product_image">
            <img src='.$item[$i][2].' alt="'.$item[$i][1].'.png">
            </div></a>
            <div class="product_qty product_info">Stückzahl noch vorhanden:' .$item[$i][3].'</div>
            <div class="product_price product_info">Preis:' .$item[$i][4].'</div>
            <div class="product_description product_info">Produktbeschreibung:' .$item[$i][5].'</div>
            </div><br>';
    }
   

}
function showRandomCategoryAndItems($conn,$amount,$productAmount){
    //gibt x=$amount zufällige Kategorien und dessen Produkte in HTML gerechter Sprache wieder



    $sql = "SELECT * FROM product_category;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($resultData)>0){
        while($row =mysqli_fetch_assoc($resultData)){
            $array[]=$row["id"];
        }
        $array=array_unique($array);
    }
    
    $maxAmount=count($array)-parentCategoryAmount($conn,1);
    if($maxAmount<$amount){
        $amount=$maxAmount;
    }
    
    
    $i=0;
    $uniqueTMP[]=array();
    unset($uniqueTMP[0]);

    $uniqueTMP=range(1,$maxAmount);
    shuffle($uniqueTMP);

    foreach($uniqueTMP as $var){
        $unique[]=$var+parentCategoryAmount($conn,1);
    }
    
    foreach($unique as $var){
        
        $sql = "SELECT category_name FROM product_category WHERE id = ?;";

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"s",$var);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $row=mysqli_fetch_assoc($resultData);
        echo '<div class="category_item_line"><ul>';
        echo '<div class="header_name category_info"><h1>'.$row["category_name"].'</h1></div>';
        showExamples($conn,$productAmount,$row["category_name"]);
        echo '</ul></div>';
    }
    
    
    mysqli_stmt_close($stmt);
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