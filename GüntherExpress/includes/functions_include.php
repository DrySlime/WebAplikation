<?php
function emptyInputSignup($email, $password, $passwordRepeat, $firstname, $lastname, $username)
{
    $result = false;
    if (empty($email) || empty($password) || empty($passwordRepeat) || empty($firstname) || empty($lastname) || empty($username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUid($username)
{
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function passwordMatch($password, $passwordRepeat)
{
    if ($password !== $passwordRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $email)
{
    $sql = "SELECT * FROM site_user WHERE active = 1 AND user_uid = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        mysqli_stmt_close($stmt);
        return $row;
    } else {
        $result = false;
        mysqli_stmt_close($stmt);
        return $result;
    }
}

function emptyInputLogin($password, $username)
{
    $result = false;
    if (empty($password) || empty($username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function createUser($conn, $email, $password, $firstname, $lastname, $username)
{
    $sql = "INSERT INTO site_user (firstname, lastname, user_uid, email, user_password) VALUES (?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $username, $email, $hashedPassword);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../login.php?error=registered");
    exit();
}

function loginUser($conn, $password, $username)
{
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header("location: ../login.php?error=wronginput");
        exit();
    }

    $pwdHashed = $uidExists["user_password"];
    $checkPwd = password_verify($password, $pwdHashed);
    if ($checkPwd === false) {
        header("location: ../login.php?error=wronginput");
        exit();
    } else if ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["id"];
        $_SESSION["useruid"] = $uidExists["user_uid"];
        header("location: ../account.php?");
        exit();
    }

}


function get___FromCatergory($conn, $whatYouNeed, $amount, $category, $shuffle)
{

    //Get all Data from a catagory
    //Hier nen Beispiel, du suchst die Bilder von der kategorie Schuhe
    //get___FromCatergory($conn,"product_image","Schuhe")

    $product_id = "SELECT id FROM product_category WHERE category_name = ? AND active=1;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $product_id)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $category);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($resultData)) {
        $product_id = $row["id"];
    } else {
        $result = false;
        return $result;
    }

    if ($shuffle) {
        $sql = "SELECT * FROM product WHERE product_category_id = ? LIMIT ?;";

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $product_id, $amount);
    } else {
        $sql = "SELECT * FROM product WHERE product_category_id = ? LIMIT ?;";

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $product_id, $amount);
    }
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);


    //Error handling: falls man mehr produkte ausgegeben haben will als existieren
    if ($amount > mysqli_num_rows($resultData)) {
        $amount = mysqli_num_rows($resultData);
    }

    if (mysqli_num_rows($resultData) > 0) {

        for ($i = 0; $i < $amount; $i++) {
            $row = mysqli_fetch_assoc($resultData);
            $itemAttribute[] = $row[$whatYouNeed];
        }
        mysqli_stmt_close($stmt);
        return $itemAttribute;
    } else {
        $result = false;
        mysqli_stmt_close($stmt);
        return $result;
    }

}

function getCategoryfromItem($conn,)
{

}

function getCategoryList($conn)
{

    //Get all names from the product_category table in an array

    $sql = "SELECT * FROM product_category WHERE active = 1;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($resultData) > 0) {

        while ($row = mysqli_fetch_assoc($resultData)) {
            $array[] = $row["category_name"];
        }
        mysqli_stmt_close($stmt);
        return $array;
    } else {
        $result = false;
        mysqli_stmt_close($stmt);
        return $result;
    }

}

function totalAmount($conn, $categoryName)
{
    $product_id = "SELECT id FROM product_category WHERE category_name = ? ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $product_id)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $categoryName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($resultData)) {
        $categoryID = $row["id"];
    }

    $product_id = "SELECT COUNT(*) as total FROM product WHERE product_category_id = ? ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $product_id)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $categoryID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($resultData)) {
        $totalamount = $row["total"];
    }
    return $totalamount;
}

function getAllFromCategory($conn, $category, $amount)
{

    //returns a 3d Array filled with items
    // id=0
    // name=1
    // image=2
    // qty=3
    // price=4
    // description=5
    // Example: get image of the first item $itemArr[0][2];
    $product_id = "SELECT id FROM product_category WHERE category_name = ? ORDER BY RAND() LIMIT ? ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $product_id)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $category, $amount);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($resultData)) {
        $product_id = $row["id"];
    } else {
        $result = false;
        return $result;
    }

    $sql = "SELECT id FROM product WHERE product_category_id = ? ;";

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $product_id);

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);


    if (mysqli_num_rows($resultData) > 0) {
        while ($row = mysqli_fetch_assoc($resultData)) {
            $itemId[] = $row["id"];
        }
    } else {
        $result = false;
        return $result;
    }

    $sql = "SELECT * FROM product WHERE id = ? AND active = 1;";

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    for ($i = 0; $i < count($itemId); $i++) {
        mysqli_stmt_bind_param($stmt, "s", $itemId[$i]);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($resultData);
        if ($row != null) {
            $itemAttribute["id"] = $row["id"];
            $itemAttribute["product_name"] = $row["product_name"];
            $itemAttribute["product_image"] = $row["product_image"];
            $itemAttribute["qty_in_stock"] = $row["qty_in_stock"];
            $itemAttribute["price"] = $row["price"];
            $itemAttribute["description"] = $row["description"];
            $itemArr[] = $itemAttribute;
            unset($itemAttribute);
        }
    }
    mysqli_stmt_close($stmt);
    return $itemArr;
}

function showItems($conn, $amount, $categoryName)
{

    //Gibt $amount viele Attribute aus der Datenbank in einer
    //html gerechten sprache wieder zurück.

    $item = getAllFromCategory($conn, $amount, $categoryName, true);

    if ($amount > count($item)) {
        $amount = count($item);
    }

    for ($i = 0; $i < count($item); $i++) {
        echo '
                
                    <li>
                    <a href="product.php?id=' . $item[$i][0] . '">
                    <div class="product_image">
                        <img src=' . $item[$i][2] . ' alt="' . $item[$i][1] . '.png" >
                    </div></a>';
    }


}

function searchbar($searchInput, $conn)
{
    #returns an array filled with ids of products.css inwhich the product name is like $searchbarInput

    $searchInput = "%" . $searchInput . "%";

    $sql = "SELECT id FROM product WHERE UPPER(product_name) LIKE UPPER(?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../category.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $searchInput);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($resultData) > 0) {
        while ($row = mysqli_fetch_assoc($resultData)) {
            $productIds[] = $row["id"];
        }
    } else {
        $productIds = null;
    }
    mysqli_stmt_close($stmt);
    return $productIds;
}

function searchItemInCategory($searchInput, $conn)
{
    #returns an array filled with ids of products.css inwhich the product name is like $searchbarInput

    $searchInput = "%" . $searchInput . "%";

    $sql = "SELECT id FROM product_category WHERE active = 1 AND UPPER(category_name) LIKE UPPER(?) ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../category.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $searchInput);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($resultData) > 0) {
        while ($row = mysqli_fetch_assoc($resultData)) {
            $productIds[] = $row["id"];
        }
    } else {
        $productIds = null;
    }
    mysqli_stmt_close($stmt);
    return $productIds;
}

function convertIdToCategoryName($conn, $id)
{
    //converts an id into a categoryname
    //returns a string
    $sql = "SELECT category_name FROM product_category WHERE id=? AND active = 1;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../category.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($resultData) > 0) {
        $row = mysqli_fetch_assoc($resultData);
        $categoryName = $row["category_name"];
    }
    mysqli_stmt_close($stmt);
    return $categoryName;
}

function convertCategoryNameToID($conn, $categoryName)
{
    //converts an categoryName into an id
    //returns a string
    $sql = "SELECT id FROM product_category WHERE category_name=? AND active = 1;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../category.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $categoryName);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($resultData) > 0) {
        $row = mysqli_fetch_assoc($resultData);
        $categoryID = $row["id"];
    } else {
        $categoryID = null;
    }
    mysqli_stmt_close($stmt);
    return $categoryID;
}

function getAllAttributesFromItemViaID($ItemID, $conn)
{
    $sql = "SELECT * FROM product WHERE id=? AND active = 1;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../category.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $ItemID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($resultData) > 0) {
        while ($row = mysqli_fetch_assoc($resultData)) {
            $item[] = $row["parent_category_id"];
        }
    }
    mysqli_stmt_close($stmt);
    return $item;

}

function getItemIdsFromCategory($conn, $CategoryID, $amount)
{
    #returns $amount many ProductIds in an array from a categoryID

    $sql = "SELECT id FROM product WHERE active = 1 AND product_category_id = ? ORDER BY rand() LIMIT  ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../category.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $CategoryID, $amount);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($resultData) > 0) {
        while ($row = mysqli_fetch_assoc($resultData)) {
            $itemIDs[] = $row["id"];
        }
    } else {
        $itemIDs = null;
    }
    mysqli_stmt_close($stmt);
    return $itemIDs;


}

function getImage($conn, $productID)
{
    $sql = "SELECT product_image FROM product WHERE id=$productID;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        $img = $row["product_image"];
    }

    return $img;
}

function getRandomItems($conn, $amount)
{
    $sql = "SELECT * FROM product WHERE active = 1 ORDER BY rand() LIMIT ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $amount);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        $array[] = $row["id"];
        $array[] = $row["product_name"];
        $array[] = $row["description"];
        $array[] = $row["product_image"];
        $array[] = $row["price"];


        $allItems[] = $array;
        unset($array);
    }

    return $allItems;

}

//Username wird in UserId umgewandelt
function getUserIdFromUserName($conn, $userName)
{

    $sql = "SELECT * FROM site_user WHERE user_uid = ? AND active = 1;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $userName,);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($resultData)["id"];
}

function createCategory($conn, $title)
{
    $sql = "INSERT INTO product_category (category_name) VALUES (?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../category_admin.php?error=stmtfailed");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "s", $title);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}

function createProduct($conn, $categoryID, $name, $productImage, $description, $price, $inStock)
{

    $sql = "INSERT INTO product (product_name,product_category_id,product_image,qty_in_stock,price,description) VALUES (?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../product_admin.php?error=stmtfailed");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "ssssss", $name, $categoryID, $productImage, $inStock, $price, $description);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

}

function createShippingMethod($conn, $name, $price)
{
    $sql = "INSERT INTO shipping_method (shipping_name, shipping_price) VALUES (?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../shippingmethod_admin.php?error=stmtfailed");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "ss", $name, $price);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

}

function invalidDate($startDate, $endDate)
{
    if ($endDate <= date("Y-m-d") || $startDate > $endDate) {
        return true;
    }
    return false;
}

function updateCategory($conn, $parentID, $title, $id)
{
    #create promotion, create promotion category
    $sql = "UPDATE product_category SET category_name=? WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "ss", $title, $id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../category_admin.php?error=none");
    exit();
}

function updateProduct($conn, $categoryID, $name, $description, $productImage, $price, $inStock, $productID)
{
    #create promotion, create promotion category
    $sql = "UPDATE product SET product_name=?, product_category_id=?, product_image=?, qty_in_stock=?, price=?, description=? WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../product_admin.php?error=stmtfailed");
        exit();
    }


    mysqli_stmt_bind_param($stmt, "sssssss", $name, $categoryID, $productImage, $inStock, $price, $description, $productID);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../product_admin.php?error=none");
    exit();
}

function getaccountData($conn)
{
    $userid = $_SESSION['userid'];

    $sql = "SELECT user_uid, firstname, lastname, email, user_password FROM site_user WHERE id = ? AND active = 1;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return mysqli_fetch_assoc($resultData);
}

function getDefUserAddressData($conn)
{
    $userid = $_SESSION['userid'];

    $sql = "SELECT * FROM address INNER JOIN user_address ON address.id = user_address.address_id WHERE user_id = ? AND user_address.is_default_address = 1";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return mysqli_fetch_assoc($resultData);
}

function getUserAddressDataWODef($conn)
{
    $userid = $_SESSION['userid'];

    $sql = "SELECT * FROM address INNER JOIN user_address ON address.id = user_address.address_id WHERE user_id = ? AND user_address.is_default_address = 0";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $resultData;
}

function changeAccount($conn, $username, $name, $surname, $email, $newPassword)
{
    $sql = "UPDATE site_user SET user_uid = ?, firstname = ?, lastname = ?, email = ? WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }
    $userid = $_SESSION['userid'];
    mysqli_stmt_bind_param($stmt, "sssss", $username, $name, $surname, $email, $userid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    $_SESSION['useruid'] = $username;
    if ($newPassword != null) {
        changePassword($conn, $newPassword);
    }
}

function changePassword($conn, $password)
{
    $sql = " UPDATE site_user SET user_password = ? WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $userid = $_SESSION['userid'];

    mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $userid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

}

function rightPassword($conn, $password)
{
    $username = $_SESSION['useruid'];
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header("location: ../account.php?error=wronginput");
        exit();
    }

    $pwdHashed = $uidExists["user_password"];
    $checkPwd = password_verify($password, $pwdHashed);
    return $checkPwd;

}

function rightEmail($conn, $email)
{
    $username = $_SESSION['useruid'];
    $uidExists = uidExists($conn, $username, $username);
    if ($uidExists === false) {
        header("location: ../account.php?error=wronginput");
        exit();
    }
    $checkEmail = $uidExists["email"];
    return $checkEmail == $email;
}

function addAddress($conn, $street, $houseno, $city, $postalCode, $site)
{
    $sql = " INSERT INTO address (street_number, address_line1, city, postal_code) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $houseno, $street, $city, $postalCode);
    mysqli_stmt_execute($stmt);
    bindAddressToUser($conn, $street, $houseno, $city, $postalCode);


    mysqli_stmt_close($stmt);

    if ($site == 1) {
        header("location: ../checkout.php?error=none");
        exit();
    } else {
        header("location: ../account.php?error=none");
        exit();
    }
}

function bindAddressToUser($conn, $street, $houseno, $city, $postalCode)
{
    $userid = $_SESSION['userid'];
    $address = getAddressIDByData($conn, $street, $houseno, $city, $postalCode)->fetch_assoc();
    $addressid = $address['id'];
    if (alreadyBindAddress($conn, $addressid, $userid)) {
        $easteregg = 2;
    } else {
        $sql = "INSERT INTO user_address (user_id, address_id) VALUES (?,?);";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../account.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $userid, $addressid);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
    }
}

function setDefaultAddress($conn, $addressid)
{
    $userid = $_SESSION['userid'];

    $sql = "UPDATE user_address SET is_default_address = 0 WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    $sql = "UPDATE user_address SET is_default_address = 1 WHERE user_id = ? AND address_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $userid, $addressid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}

function unbindAddress($conn, $addressid)
{
    $userid = $_SESSION['userid'];

    $sql = "DELETE FROM user_address WHERE user_id = ? AND address_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $userid, $addressid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    $newAddressDEF = getUserAddressDataWODef($conn);
    if ($newAddressDEF != null) {
        $row = $newAddressDEF->fetch_assoc();
        setDefaultAddress($conn, $row['id']);
    }
}

function alreadyBindAddress($conn, $addressid, $userid)
{
    $sql = "SELECT * FROM user_address WHERE address_id = ? AND user_id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $addressid, $userid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        mysqli_stmt_close($stmt);
        return true;
    } else {
        mysqli_stmt_close($stmt);
        return false;
    }
}

function getAddressIDByData($conn, $street, $houseno, $city, $postalCode)
{
    $sql = "SELECT * FROM address WHERE street_number = ? AND address_line1 = ? AND city = ? AND postal_code = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $houseno, $street, $city, $postalCode);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $resultData;
}

function getPersonalOrderIDsDescending($conn)
{
    $userid = $_SESSION['userid'];

    $sql = "SELECT id FROM shop_order WHERE siteuser_id = ? ORDER BY id DESC";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $resultData;
}

function getPersonalOrderDataByID($conn, $orderID)
{
    $sql = "SELECT * FROM shop_order INNER JOIN site_user ON shop_order.siteuser_id = site_user.id INNER JOIN user_payment_method ON shop_order.payment_method_id = user_payment_method.id INNER JOIN address ON shop_order.shipping_address_id = address.id INNER JOIN shipping_method ON shop_order.shipping_method_id = shipping_method.id INNER JOIN order_status ON shop_order.order_status_id = order_status.id WHERE shop_order.id = ?";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $orderID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $resultData;
}

function getObjectOrderDataByID($conn, $orderID)
{
    $sql = "SELECT product.product_name, product.product_image, product_item_id, order_line.qty, product.price FROM order_line INNER JOIN product ON order_line.product_item_id = product.id WHERE order_line.order_id=?";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $orderID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $resultData;
}

function getPaymentTypeValueFromID($conn, $paymentID)
{
    $sql = "SELECT payment_type.value FROM payment_type WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $paymentID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $resultData;
}

function deactivateUser($conn)
{
    $userid = $_SESSION['userid'];
    $sql = "UPDATE site_user SET active = 0 WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    session_start();
    session_unset();
    session_destroy();
    header("location: ../index.php");
    exit();
}

function getShippingMethodData($conn)
{

    $sql = "SELECT * FROM shipping_method";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt);

    return $resultData;
}


function bindPaymentToUser($conn, $payment_type_id, $provider, $account_number, $expiry_date)
{
    $user_id = $_SESSION['userid'];
    $expiry_date .= "-01";
    $payID = getPaymentIDByData($conn, $user_id, $payment_type_id, $provider, $account_number, $expiry_date);
    if ($payID != null) {
        $userid = $_SESSION['userid'];

        $sql = "UPDATE user_payment_method SET active = 0 WHERE user_id = ? AND id = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../account.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $userid, $payID);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
    } else {
        $sql = "INSERT INTO user_payment_method (user_id,payment_type_id, provider, account_number, expiry_date,active) VALUES (?,?,?,?,?,1);";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../account.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sssss", $_SESSION['userid'], $payment_type_id, $provider, $account_number, $expiry_date);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
    }
}

function setDefaultPayment($conn, $paymentId)
{
    $userid = $_SESSION['userid'];

    $sql = "UPDATE user_payment_method SET is_default_pay_method = 0 WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    $sql = "UPDATE user_payment_method SET is_default_pay_method = 1 WHERE user_id = ? AND id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $userid, $paymentId);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}

function unbindPayment($conn, $paymentid)
{
    $userid = $_SESSION['userid'];

    $sql = "UPDATE user_payment_method SET active = 0 WHERE user_id = ? AND id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $userid, $paymentid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    $newPaymentDEF = getUserPaymentDataWODef($conn);
    if ($newPaymentDEF != null) {
        $row = $newPaymentDEF->fetch_assoc();
        setDefaultPayment($conn, $row['id']);
    }
}

function getPaymentIDByData($conn, $user_id, $payment_type_id, $provider, $account_number, $expiry_date)
{
    $sql = "SELECT * FROM user_payment_method WHERE user_id = ? AND payment_type_id = ? AND provider = ? AND account_number = ? AND expiry_date = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $user_id, $payment_type_id, $provider, $account_number, $expiry_date);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $resultData->fetch_assoc();
}

function getPaymentMethods($conn)
{
    $sql = "SELECT * FROM payment_type WHERE active = 1;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt);

    return $resultData;
}

function getDefUserPaymentData($conn)
{
    $userid = $_SESSION['userid'];

    $sql = "SELECT * FROM user_payment_method WHERE is_default_pay_method = 1 AND user_id = ? AND active = 1";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return mysqli_fetch_assoc($resultData);
}

function getUserPaymentDataWODef($conn)
{
    $userid = $_SESSION['userid'];

    $sql = "SELECT * FROM user_payment_method WHERE is_default_pay_method = 0 AND user_id = ? AND active = 1";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $resultData;
}

function getCategorieValueFromID($conn, $id)
{
    $sql = "SELECT category_name FROM product_category WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $resultData;
}

function getFullQTYofOrder($conn, $orderID)
{
    $sql = "SELECT * FROM order_line WHERE order_id=?";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $orderID);
    mysqli_stmt_execute($stmt);

    $orderedProducts = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $fullQTY = 0;

    while ($row = $orderedProducts->fetch_assoc()) {
        $fullQTY = $fullQTY + $row['qty'];
    }
    return $fullQTY;
}
