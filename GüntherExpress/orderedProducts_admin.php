<?php
    require_once "header.php";

    require_once "includes/admin_functions_inc.php";
?>
<head>
    <link rel="stylesheet" href="CSS/orderedProducts.css">

</head>
<body>
<div><br><br><br><br></div>

<div class="orderedProductList">
    <form action="orderedProducts_admin.php" method="post">
        <input type="text" name="search" placeholder="UserID/Username" required>
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
        $productArray=getAllOrderedProductsFromUserID($conn,$userid);
        if($productArray!=null){
            echo"<h1>Alle Besttelungen von ".getUsername($conn,$productArray[0]["siteuser_id"])."</h1>
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
            
                    ";
                    for($i=0;$i<count($productArray);$i++) {
                        $order=getOrderLine($conn,$productArray[$i]["order_id"]);
                        echo "
                        <tr>
                                <td > ".$productArray[$i]["order_id"]." </td >
                                <td > ".getUsername($conn,$productArray[$i]["siteuser_id"])." </td >
                                <td > ".$productArray[$i]["order_date"]." </td >
                                <td > ".getPaymentMethod($conn,$productArray[$i]["payment_method_id"])." </td >
                                <td > ".getShippingAdress($conn,$productArray[$i]["shipping_address_id"])." </td >
                                <td > ".getShippingMethod($conn,$productArray[$i]["shipping_method_id"])." </td >
                                <td > ".$productArray[$i]["order_total"]."Euro </td >
                                <td > ".getOrderStatus($conn,$productArray[$i]["order_status_id"])." </td >   
                                <td > ".orderlineToTEXT($conn,$order)." </td > 
                                <td><a href='orderedProducts_admin.php?change=1&orderid=".$productArray[$i]['order_id']."&username=".getUsername($conn,$productArray[$i]['siteuser_id'])."&date=".$productArray[$i]['order_date']."&payMethod=".getPaymentMethod($conn,$productArray[$i]["payment_method_id"])."&adress=".getShippingAdress($conn,$productArray[$i]["shipping_address_id"])." &shipMethod=".getShippingMethod($conn,$productArray[$i]["shipping_method_id"])."&total=".$productArray[$i]["order_total"]."&orderStatus=".getOrderStatus($conn,$productArray[$i]["order_status_id"])."&orderContent=".orderlineToTEXT($conn,$order)."'><button>CHANGE</button></a></td>  
                            </tr >";
            }
        }else{

            echo "<h1>No Order under this ID</h1>";
        }


    }else{
        $productArray=getAllOrderedProducts($conn);

        echo"
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
            
                    ";
        if($productArray!=null){
            for($i=0;$i<count($productArray);$i++) {
                $order=getOrderLine($conn,$productArray[$i]["order_id"]);
                echo "
                        <tr>
                                <td > ".$productArray[$i]["order_id"]." </td >
                                <td > ".getUsername($conn,$productArray[$i]["siteuser_id"])." </td >
                                <td > ".$productArray[$i]["order_date"]." </td >
                                <td > ".getPaymentMethod($conn,$productArray[$i]["payment_method_id"])." </td >
                                <td > ".getShippingAdress($conn,$productArray[$i]["shipping_address_id"])." </td >
                                <td > ".getShippingMethod($conn,$productArray[$i]["shipping_method_id"])." </td >
                                <td > ".$productArray[$i]["order_total"]."Euro </td >
                                <td > ".getOrderStatus($conn,$productArray[$i]["order_status_id"])." </td >   
                                <td > ".orderlineToTEXT($conn,$order)." </td >   
                                <td><a href='orderedProducts_admin.php?change=1&orderid=".$productArray[$i]['order_id']."&username=".getUsername($conn,$productArray[$i]['siteuser_id'])."&date=".$productArray[$i]['order_date']."&payMethod=".getPaymentMethod($conn,$productArray[$i]["payment_method_id"])."&adress=".getShippingAdress($conn,$productArray[$i]["shipping_address_id"])." &shipMethod=".getShippingMethod($conn,$productArray[$i]["shipping_method_id"])."&total=".$productArray[$i]["order_total"]."&orderStatus=".getOrderStatus($conn,$productArray[$i]["order_status_id"])."&orderContent=".orderlineToTEXT($conn,$order)."'><button>CHANGE</button></a></td>  
               
                            </tr >";
            }
        }

    }
    
    ?>
</table>
<?php
$status=getAllOrderStatus($conn);

if (isset($_GET["change"])){
    echo'
    <div class="changeForm">
    <h1>UPDATE FORM: </h1>
        <form action="includes/updateOrderedProduct_inc.php" method="post">           
            OrderID: '.$_GET["orderid"].'<br>
            Username: '.$_GET["username"].'<br>
            <select  name="statusID" size="4"  required>            
            ';
    for ($i=0;$i<count($status);$i++){
        echo "
                            <option value=".$status[$i]["id"].">".$status[$i]["status"]."</option>
                        ";
    };
    echo '
            </select><br>
            <input type="text" name="orderID" value='.$_GET["orderid"].' hidden>
            <input type="submit" name="send_form" value="UPDATE">
            
            <button formnovalidate><a href="orderedProducts_admin.php" >Cancel</a></button>
    
        </form>
    </div>
    ';
}

?>
</body>

