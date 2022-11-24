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
    </form>
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
                                        
               
                            </tr >";
            }
        }else{

            echo "<h1>Unbekannte ID</h1>";
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
                                        
               
                            </tr >";
            }
    }
    
    ?>



</table>
</body>

