<?php
    require_once "admin_header.php";
    require_once "includes/admin_functions_inc.php";
    global $conn;
    $categories=getAllCategories($conn);
?>
<head>
    <link rel="stylesheet" href="CSS/sale_admin.css">
    <title></title>
</head>
    <div><br><br><br><br></div>
<h1>Create a PRODUCT</h1>
<form action="../includes/createProduct_inc.php" method="post">
    <label for="category">Choose a category:</label>
    <label for="cars"></label><select id="cars" name="category_id" size="4" required>
        <?php
            for ($i=0;$i<count($categories);$i++){
        ?>
                    <option value="<?php echo $categories[$i]["id"]?>"><?php echo $categories[$i]["category_name"]?></option>
        <?php
            }
        ?>

    </select><br>
    Name: <label>
        <input type="text" name="name"  placeholder="Product Name" required>
    </label><br>
    Product Image: <label>
        <input type="text" name="pImage" required>
    </label>
    Description: <label>
        <textarea name="description" placeholder="Description" rows="1" cols="60" required></textarea>
    </label><br>
    Price: <label>
        <input type="text" name="price" placeholder="Price" required>
    </label><br>
    Amount in Stock: <label>
        <input type="number" name="inStock"  required>
    </label><br>

    <input type="submit" name="send_form">

</form>





<?php
$productArr=getAllProducts($conn);

if($productArr!=null){
?>
        <div class='all'>
        <div class='table'>
        <table>
        <h1>Alle Products</h1>
            <tr>
                <th>Category </th>
                <th>Name </th>
                <th>Product Image</th>
                <th>Description </th>
                <th>Price</th>
                <th>Amount in Stock</th>
                
                <th>CHANGE</th>
                <th>DELETE</th>
            </tr>
        
<?php
    for($i=0;$i<count($productArr);$i++) {

?>
    <tr>
        <td > <?php echo getCategoryNameViaID($conn,$productArr[$i]["product_category_id"])?></td >
        <td > <?php echo $productArr[$i]["product_name"]?> </td >
        <td > <?php $productArr[$i]["product_image"]?> </td >
        <td > <?php $productArr[$i]["description"]?> </td >
        <td > <?php  $productArr[$i]["price"] ?></td >
        <td > <?php $productArr[$i]["qty_in_stock"]?> </td >
        
        <td > <a href='admin_products.php?change=1&productID=<?php echo $productArr[$i]["id"]?>&productName=<?php echo $productArr[$i]["product_name"] ?>&productImage=<?php $productArr[$i]["product_image"] ?>&description=<?php echo $productArr[$i]["description"]?>&price=<?php echo $productArr[$i]["price"] ?>&qtyInStock=<?php echo $productArr[$i]["qty_in_stock"]?>'><button>CHANGE</button></a> </td >
        <td > <form action='../includes/deleteProduct_inc.php' method='post'><input type='submit' name='delButton' value='DELETE'><input name='productID' value="<?php echo$productArr[$i]["id"]?>" hidden> </form></td >
    </tr >
    
    
    <?php } ?>
    </table></div>
    <?php
    }
if (isset($_GET["change"])){
    ?>
    <div class="changeForm">
    <h1>UPDATE FORM: </h1>
        <form action="../includes/updateProduct_inc.php" method="post">
            <label for="category">Choose a category:</label>
            <select  name="category_id" size="4"  required>
            <?php
            for ($i=0;$i<count($categories);$i++){
            ?>
                            <option value=<?php echo $categories[$i]["id"]?>><?php echo $categories[$i]["category_name"]?></option>
            <?php
            }
            ?>
            </select><br>
            Name: <input type="text" name="product_name"  value="<?php echo $_GET["productName"]?>" required><br>
            Description: <textarea name="description"  rows="1" cols="60" required><?php echo $_GET["description"]?></textarea><br>
            Product Image :<input type="text" name="productImage" value="<?php echo $_GET["productImage"]?>" required><br>
            Price : <input type="text" name="price" value="<?php echo $_GET["price"]?>" required><br>
            Amount in Stock : <input type="number" name="qty_in_stock" value="<?php echo $_GET["qtyInStock"]?>"required><br>
            
            <input name="productID" value="<?php echo $_GET["productID"]?>" hidden>
            <input type="submit" name="send_form" value="UPDATE">
            <a href="sale_admin.php" ><button formnovalidate>Cancel</button></a>
    
        </form>
    </div>
<?php
}
if (isset($_GET["error"])){
    if($_GET["error"]=="invalidDiscount"){
        ?>
        <br><h1 style='color: red'>Error in your Discountrate. Please enter a value between 1-99! For Example 20</h1><br>
    <?php
    }if($_GET["error"]=="invalidDate") {
    ?>
        <br><h1 style='color: red'>Error in your Date. Please check your Dates. End Date cant be in the past and or before the start Date!</h1><br>
    <?php
    }
    if($_GET["error"]=="titleExists") {
    ?>
        <br><h1 style='color: red'>This Promotion allready exists! Please chose another name!</h1><br>
    <?php
    }
}

?>

