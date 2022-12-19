<head>
    <link rel="stylesheet" href="../CSS/shopping_cart_insert.css">
</head>

<?php
include_once 'header.php';
include 'includes/dbh_include.php';
include_once 'includes/functions_include.php';
include_once "includes/item_function.php";


$userName;

if(isset($_SESSION['useruid'])){
    $userName = $_SESSION['useruid'];
}else{
    header('Location: login.php');
    exit();
}


$product=getAllFromProductID($conn, $_GET['pID']);


$userId = getUserIdFromUserName($conn, $userName);
insert_into_cart($conn, $userId, $_GET['pID'], $_GET['quantaty']);


// Item wird in den Einkaufswagen gelegt
function insert_into_cart($conn, $userId, $productId, $quantaty){


    
    $sql = "SELECT qty FROM shopping_cart WHERE user_id = ? AND product_id = ?";
    $stmt = mysqli_stmt_init($conn);
    
    
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"ss",$userId,$productId,);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $data =  mysqli_fetch_assoc($resultData);
    mysqli_stmt_close($stmt);

    if($data == null){

        $sql = "INSERT INTO shopping_cart (user_id, product_id, qty) VALUES (?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        
        
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"sss",$userId,$productId,$quantaty);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }else{
        $sql = "UPDATE shopping_cart SET qty = ? WHERE user_id = ? AND product_id = ? ";
        $stmt = mysqli_stmt_init($conn);
        
        $newQuantaty = ($quantaty+$data["qty"]);
        
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"sss",$newQuantaty , $userId, $productId,);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    
}





?>



<body>
    <div class="background">
        <div class="container">
            <div class="product-container">
                <h2 class="confirmation">Folgender Gegenstand wurde <?php echo $_GET["quantaty"];?> mal in den Warenkorb gelegt:</h2>

                <h2 class="product-name"> <?php echo $product[0]["product_name"] ?> </h2>
                <img class="product-img" src=<?php echo $product[0]["product_image"];?>> <br>


                
                
            </div>
            
            <div class="buttons">
                    <form action="index.php">
                        <input class="button" type="submit" value="Weiter einkaufen">
                    </form>

                    <form action="shopping_cart.php">
                        <input class="button" type="submit" value="Zum Einkaufswagen">
                    </form>
            </div>
        </div>
    </div>
    
</body>
