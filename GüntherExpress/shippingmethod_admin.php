<?php
    include_once "header.php";
    require_once "includes/admin_functions_inc.php";
    global $conn;
    $categories=getAllCategories($conn);
?>
<head>
    <link rel="stylesheet" href="CSS/sale_admin.css">
    <title></title>
</head>
    <div><br><br><br><br></div>
<h1>Create a Shipping Method</h1>
<form action="includes/createShippingMethod_inc.php" method="post">

    Shipping Name: <label>
        <input type="text" name="name"  placeholder="Shipping Method" required>
    </label><br>
    Shipping Price: <label>
        <input type="text" name="price" placeholder="Price" required>
    </label><br>
    <input type="submit" name="send_form">

</form>





<?php
$SMethodArr=getAllShippingMethods($conn);

if($SMethodArr!=null){
?>
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
        
<?php
    for($i=0;$i<count($SMethodArr);$i++) {

?>
    <tr>
        <td > <?php echo $SMethodArr[$i]["id"]?></td>
        <td > <?php echo $SMethodArr[$i]["shipping_name"]?> </td >
        <td > <?php echo $SMethodArr[$i]["shipping_price"]?> </td >
        <td > <a href='shippingmethod_admin.php?change=1&methodID=<?php echo $SMethodArr[$i]["id"]?>&methodName=<?php echo $SMethodArr[$i]["shipping_name"]?>&shippingPrice=<?php echo $SMethodArr[$i]["shipping_price"]?>'><button>CHANGE</button></a> </td >
        <td > <form action='includes/deleteShippingMethod_inc.php' method='post'><input type='submit' name='delButton' value='DELETE'><input name='shippingMethodID' value="<?php echo $SMethodArr[$i]["id"]?>" hidden> </form></td >
    </tr >
    
    <?php
    }
    ?>
    </table></div>
    <?php
    }

if (isset($_GET["change"])){
?>
    <div class="changeForm">
    <h1>UPDATE FORM: </h1>
        <form action="includes/updateShippingMethod_inc.php" method="post">
            </select><br>
            Shipping Name: <input type="text" name="name"  value="<?php echo $_GET["methodName"]?>" required><br>
            Shipping Price : <input type="text" name="price" value=<?php echo $_GET["shippingPrice"]?>' required><br>
            <input name="methodID" value='<?php echo $_GET["methodID"]?>' hidden>
            <input type="submit" name="send_form" value="UPDATE">
            <a href="sale_admin.php" ><button formnovalidate>Cancel</button></a>
    
        </form>
    </div>
<?php
}

?>
