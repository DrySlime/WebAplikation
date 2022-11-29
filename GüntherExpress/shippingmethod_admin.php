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
<form action="includes/createShippingMethod_inc.php" method="post">

    Shipping Name: <input type="text" name="name"  placeholder="Product Name" required><br>
    Shipping Price: <input type="text" name="price" placeholder="Price" required><br>
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
$SMethodArr=getAllShippingMethods($conn);

if($SMethodArr!=null){
    echo"
        <div class='all'>
        <div class='table'>
        <table>
        <h1>All Shipping Methods</h1>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Shipping Costs</th>
                <th>CHANGE</th>
                <th>DELETE</th>
            </tr>
        
            ";
    for($i=0;$i<count($SMethodArr);$i++) {

    echo "
    <tr>
        <td > ".$SMethodArr[$i]["id"]."</td>
        <td > ".$SMethodArr[$i]["shipping_name"]." </td >
        <td > ".$SMethodArr[$i]["shipping_price"]." </td >
        <td > <a href='shippingmethod_admin.php?change=1&methodID=".$SMethodArr[$i]["id"]."&methodName=".$SMethodArr[$i]["shipping_name"]."&shippingPrice=".$SMethodArr[$i]["shipping_price"]."'><button>CHANGE</button></a> </td >
        <td > <form action='includes/deleteShippingMethod_inc.php' method='post'><input type='submit' name='delButton' value='DELETE'><input name='shippingMethodID' value=".$SMethodArr[$i]["id"]." hidden> </form></td >
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
            </select><br>
            Shipping Name: <input type="text" name="name"  value="'.$_GET["methodName"].'" required><br>
            Shipping Price : <input type="text" name="price" value='.$_GET["shippingPrice"].' required><br>
            <input name="methodID" value='.$_GET["methodID"].' hidden>
            <input type="submit" name="send_form" value="UPDATE">
            <a href="sale_admin.php" ><button formnovalidate>Cancel</button></a>
    
        </form>
    </div>
    ';
}

?>
</div>
