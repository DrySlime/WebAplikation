<?php
    require_once "header.php";
    require_once "includes/admin_functions_inc.php";
    global $conn;
?>
<head>
    <link rel="stylesheet" href="CSS/orderedProducts.css">
    <title></title>

</head>
<body>
<div><br><br><br><br></div>

<div class="orderedProductList">
    <form action="orderedProducts_admin.php" method="post">
        <label>
            <input type="text" name="search" placeholder="Order ID" required>
        </label>
        <button type="submit">Suche</button>

    </form><a href="orderedProducts_admin.php"><button formnovalidate>Reset</button></a>
</div>
<?php
$amount = 3;
    if(isset($_POST["search"])){

        $userid=$_POST["search"];
        if(strlen($userid)>3){
            $userid=getUserID($conn,$userid);
        }
        $productArray=getAllOrderedProductsFromOrderID($conn,$userid);

        if($productArray!=null){
        ?>
            <h1>Alle Besttelungen von <?php echo getUsername($conn,$productArray[0]["siteuser_id"])?></h1>
                <table>
                    <tr>
                        <th>Order_id </th>
                        <th>Username </th>
                        <th>Order Date </th>
                        <th>Payment Method </th>
                        <th>Shipping Adress</th>
                        <th>Shipping Method</th>
                        <th>Order Total </th>
                        <th>Order Status </th>
                        <th>Order Content</th>
                        <th>Change Status</th>
                    </tr>
            
                    <?php
                    for($i=0;$i<count($productArray);$i++) {
                        $order=getOrderLine($conn,$productArray[$i]["order_id"]);
                    ?>
                        <tr>
                                <td > <?php echo $productArray[$i]["order_id"]?> </td >
                                <td > <?php echo getUsername($conn,$productArray[$i]["siteuser_id"])?> </td >
                                <td > <?php echo $productArray[$i]["order_date"]?> </td >
                                <td > <?php echo getPaymentMethod($conn,$productArray[$i]["payment_method_id"])?></td >
                                <td > <?php echo getShippingAdress($conn,$productArray[$i]["shipping_address_id"])?> </td >
                                <td > <?php echo getShippingMethod($conn,$productArray[$i]["shipping_method_id"])?> </td >
                                <td > <?php $productArray[$i]["order_total"]?>Euro </td >
                                <td > <?php getOrderStatus($conn,$productArray[$i]["order_status_id"])?> </td >   
                                <td > <?php orderlineToTEXT($conn,$order)?> </td > 
                                <td><a href='orderedProducts_admin.php?change=1&orderid=<?php $productArray[$i]['order_id']?>&username=<?php echo getUsername($conn,$productArray[$i]['siteuser_id'])?>&date=<?php echo $productArray[$i]['order_date']?>&payMethod=<?php echo getPaymentMethod($conn,$productArray[$i]["payment_method_id"])?>&adress=<?php echo getShippingAdress($conn,$productArray[$i]["shipping_address_id"])?>&shipMethod=<?php echo getShippingMethod($conn,$productArray[$i]["shipping_method_id"])?>&total=<?php echo $productArray[$i]["order_total"]?>&orderStatus=<?php echo getOrderStatus($conn,$productArray[$i]["order_status_id"])?>&orderContent=<?php echo orderlineToTEXT($conn,$order)?>'><button>CHANGE</button></a></td>  
                            </tr >
        <?php
            }
        }else{
        ?>
            <h1>No Order under this ID</h1>
        <?php
        }


    }else{
        $productArray=getAllOrderedProducts($conn);

    ?>
                <h1>Alle Besttelungen</h1>
                <table>
                    <tr>
                        <th>Order_id </th>
                        <th>Username </th>
                        <th>Order Date </th>
                        <th>Payment Method </th>
                        <th>Shipping Adress</th>
                        <th>Shipping Method</th>
                        <th>Order Total </th>
                        <th>Order Status </th>
                        <th>Order Content</th>
                        <th>Change Status</th>
                    </tr>
            
        <?php 
        if($productArray!=null){
            for($i=0;$i<count($productArray);$i++) {
                $order=getOrderLine($conn,$productArray[$i]["order_id"]);
                ?>
                        <tr>
                                <td > <?php echo $productArray[$i]["order_id"]?> </td >
                                <td > <?php echo getUsername($conn,$productArray[$i]["siteuser_id"])?> </td >
                                <td > <?php echo $productArray[$i]["order_date"]?> </td >
                                <td > <?php echo getPaymentMethod($conn,$productArray[$i]["payment_method_id"])?></td >
                                <td > <?php echo getShippingAdress($conn,$productArray[$i]["shipping_address_id"])?> </td >
                                <td > <?php echo getShippingMethod($conn,$productArray[$i]["shipping_method_id"])?> </td >
                                <td > <?php echo $productArray[$i]["order_total"]?> Euro </td >
                                <td > <?php echo getOrderStatus($conn,$productArray[$i]["order_status_id"])?> </td >   
                                <td > <?php echo orderlineToTEXT($conn,$order)?> </td >   
                                <td><a href='orderedProducts_admin.php?change=1&orderid=<?php echo $productArray[$i]['order_id']?>&username=<?php echo getUsername($conn,$productArray[$i]['siteuser_id'])?>&date=<?php echo $productArray[$i]['order_date']?>&payMethod=<?php echo getPaymentMethod($conn,$productArray[$i]["payment_method_id"])?>&adress=<?php echo getShippingAdress($conn,$productArray[$i]["shipping_address_id"])?>&shipMethod=<?php echo getShippingMethod($conn,$productArray[$i]["shipping_method_id"])?>&total=<?php echo $productArray[$i]["order_total"]?>&orderStatus=<?php echo getOrderStatus($conn,$productArray[$i]["order_status_id"])?>&orderContent=<?php echo orderlineToTEXT($conn,$order)?>'><button>CHANGE</button></a></td>  
               
                            </tr >
                            <?php
            }
        }

    }

$status=getAllOrderStatus($conn);

if (isset($_GET["change"])){
?>
    <div class="changeForm">
    <h1>UPDATE FORM: </h1>
        <form action="includes/updateOrderedProduct_inc.php" method="post">           
            OrderID: <?php echo $_GET["orderid"]?><br>
            Username: <?php echo $_GET["username"]?><br>
            <select  name="statusID" size="4"  required>            
    <?php
    for ($i=0;$i<count($status);$i++){
    ?>
                            <option value="<?php echo $status[$i]["id"]?>"><?php echo $status[$i]["status"]?></option>
    <?php 
    }
    ?>
            </select><br>
            <input type="text" name="orderID" value='<?php echo $_GET["orderid"]?>' hidden>
            <input type="submit" name="send_form" value="UPDATE">
            
            <button formnovalidate><a href="orderedProducts_admin.php" >Cancel</a></button>
    
        </form>
    </div>
    <?php
}

?>
</body>

