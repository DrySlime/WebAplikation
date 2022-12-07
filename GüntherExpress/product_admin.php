<?php
    include_once "header.php";
    require_once "includes/admin_functions_inc.php";

    $categories=getAllCategories($conn);
?>
<head>
    <link rel="stylesheet" href="CSS/sale_admin.css">
</head>
    <div><br><br><br><br></div>
<h1>Create a PRODUCT</h1>
<form action="includes/createProduct_inc.php" method="post">
    <label for="category">Choose a category:</label>
    <select id="cars" name="category_id" size="4" required>
        <?php
            for ($i=0;$i<count($categories);$i++){
                echo "
                    <option value=".$categories[$i]["id"].">".$categories[$i]["category_name"]."</option>
                ";
            }
        ?>

    </select><br>
    Name: <input type="text" name="name"  placeholder="Product Name" required><br>
    Product Image: <input type="text" name="pImage" required>
    Description: <textarea name="description" placeholder="Description" rows="1" cols="60" required></textarea><br>
    Price: <input type="text" name="price" placeholder="Price" required><br>
    Amount in Stock: <input type="number" name="inStock"  required><br>

    <input type="submit" name="send_form">

</form>



<?php #TODO
if (isset($_GET["error"])){
    if($_GET["error"]=="invalidDiscount"){
        echo "<br><h1 style='color: red'>Error in your Discountrate. Please enter a value between 1-99! For Example 20</h1><br>";
    }if($_GET["error"]=="invalidDate") {
        echo "<br><h1 style='color: red'>Error in your Date. Please check your Dates. End Date cant be in the past and or before the start Date!</h1><br>";
    }
    if($_GET["error"]=="titleExists") {
        echo "<br><h1 style='color: red'>This Promotion allready exists! Please chose another name!</h1><br>";
    }
}

?>

<?php
$productArr=getAllProducts($conn);

if($productArr!=null){
    echo"
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
        
            ";
    for($i=0;$i<count($productArr);$i++) {

    echo "
    <tr>
        <td > ".getCategoryNameViaID($conn,$productArr[$i]["product_category_id"])." </td >
        <td > ".$productArr[$i]["product_name"]." </td >
        <td > ".$productArr[$i]["product_image"]." </td >
        <td > ".$productArr[$i]["description"]." </td >
        <td > ".$productArr[$i]["price"]." </td >
        <td > ".$productArr[$i]["qty_in_stock"]." </td >
        
        <td > <a href='product_admin.php?change=1&productID=".$productArr[$i]["id"]."&productName=".$productArr[$i]["product_name"]."&productImage=".$productArr[$i]["product_image"]." &description=".$productArr[$i]["description"]."&price=".$productArr[$i]["price"]."&qtyInStock=".$productArr[$i]["qty_in_stock"]."'><button>CHANGE</button></a> </td >
        <td > <form action='includes/deleteProduct_inc.php' method='post'><input type='submit' name='delButton' value='DELETE'><input name='productID' value=".$productArr[$i]["id"]." hidden> </form></td >
    </tr >
    
    ";
    }
    echo "</table></div>";
    }
?>
<?php
if (isset($_GET["change"])){
    echo'
    <div class="changeForm">
    <h1>UPDATE FORM: </h1>
        <form action="includes/updateProduct_inc.php" method="post">
            <label for="category">Choose a category:</label>
            <select  name="category_id" size="4"  required>
            ';
            for ($i=0;$i<count($categories);$i++){
                echo "
                            <option value=".$categories[$i]["id"].">".$categories[$i]["category_name"]."</option>
                        ";
            };
            echo '
            </select><br>
            Name: <input type="text" name="product_name"  value="'.$_GET["productName"].'" required><br>
            Description: <textarea name="description"  rows="1" cols="60" required>'.$_GET["description"].'</textarea><br>
            Product Image :<input type="text" name="productImage" value="'.$_GET["productImage"].'" required><br>
            Price : <input type="text" name="price" value='.$_GET["price"].' required><br>
            Amount in Stock : <input type="number" name="qty_in_stock" value="'.$_GET["qtyInStock"].'"required><br>
            
            <input name="productID" value='.$_GET["productID"].' hidden>
            <input type="submit" name="send_form" value="UPDATE">
            <a href="sale_admin.php" ><button formnovalidate>Cancel</button></a>
    
        </form>
    </div>
    ';
}

?>
</div>
