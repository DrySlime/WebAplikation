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

function emptyInputProfile($email,$firstname,$lastname,$username){
    $result = false;
    if(empty($email) || empty($firstname) || empty($lastname) || empty($username)){
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

function invalidUserAddress($conn, $addressID){
    $userid = $_SESSION['userid'];
    $sql = "SELECT * FROM user_address WHERE user_id = ? AND address_id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt,"ss",$userid,$addressID);
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



function get___FromCatergory($conn,$whatYouNeed,$amount,$category){

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

    $sql = "SELECT * FROM product WHERE product_category_id = ?;";

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt,"s",$product_id);
    mysqli_stmt_execute($stmt);
    
    $resultData = mysqli_stmt_get_result($stmt);
    
    $itemAttribute[]=array();

    //Error handling: falls man mehr produkte ausgegeben haben will als existieren
    if($amount>mysqli_num_rows($resultData)){
        $amount=mysqli_num_rows($resultData);
    }

    if(mysqli_num_rows($resultData)>0){
        
        for($i=1;$i<$amount+1;$i++){
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


//URl-Parameter werden ausgelesen
function getURLParameter(){
    $url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);
    return $params;
}

//Produktdaten werden aus der Datenbank aufgerufen
function getProductData($conn, $productID){

    $sql = "SELECT * FROM Artikel WHERE ArtikelID = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$productID,);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($resultData);
}
function showExamples($conn,$amount,$category){

    //Gibt viele Attribute aus der Datenbank in einer ...
    //html gerechten sprache wieder zurück.
    
    $itemName = get___FromCatergory($conn,"product_name",$amount,$category);
    $itemImage = get___FromCatergory($conn,"product_image",$amount,$category);
    $itemQty = get___FromCatergory($conn,"qty_in_stock",$amount,$category);
    $itemPrice = get___FromCatergory($conn,"price",$amount,$category);
    $itemDescription = get___FromCatergory($conn,"description",$amount,$category);

    if($amount>count($itemName)-1){
        $amount=count($itemName)-1;
    }

    echo '<div class="'.$category.'_category"><ul>';
    for($i=1;$i<=$amount;$i++){
        echo '<li>Produktname:'.$itemName[$i].'<br>
            <img src='.$itemImage[$i].'><br>
            Stückzahl noch vorhanden:' .$itemQty[$i].'<br>
            Preis:' .$itemPrice[$i].'<br>
            Produktbeschreibung:' .$itemDescription[$i].'<br>';
    }
    echo '</ul></div>';

}
function showRandomCategory($conn,$amount){
    //gibt zufällige Kategorien und dessen Produkte in HTML gerechter Sprache wieder


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
        echo '<h1>'.$row["category_name"].'</h1>';
        
        showExamples($conn,3,$row["category_name"]);
    }
    
    mysqli_stmt_close($stmt);
}
function parentCategoryAmount($conn,$var){
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

function changePassword($conn,$password){
    $sql = " UPDATE site_user SET user_password = ? WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
    $useruid = $_SESSION['userid'];

    mysqli_stmt_bind_param($stmt,"ss",$hashedPassword,$userid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../profile.php?error=none");
    exit();

}

function changeProfile($conn,$username, $name, $surname, $email){
    $sql = " UPDATE site_user SET username = ?, firstname = ?, lastname = ?, email = ? WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }

    $useruid = $_SESSION['userid'];

    mysqli_stmt_bind_param($stmt,"sssss",$username,$name,$surname,$email,$userid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../profile.php?error=none");
    exit();

}

function changeAddress($conn,$addressID, $street, $houseno, $city, $postalCode){
    $sql = " UPDATE address SET address_line1 = ?, street_number = ?, city = ?, postal_code = ? WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt,"sssss",$street,$houseno,$city,$postalCode,$addressID);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../profile.php?error=none");
    exit();

}

function getProfileData($conn){

    $userid = $_SESSION['userid'];

    $sql = "SELECT username, firstname, lastname, email FROM site_user WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$userid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($resultData);
}

function getAllUserAddressData($conn){

    $userid = $_SESSION['userid'];


    $sql = "SELECT * FROM address WHERE id = (SELECT address_id FROM user_address WHERE user_id = ?);";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$userid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    
    return mysqli_fetch_assoc($resultData);
}

function getAddressDataByID($conn){
    

    $sql = "SELECT * FROM address WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"s",$_SESSION['change_address_id']);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    
    return mysqli_fetch_assoc($resultData);
}



