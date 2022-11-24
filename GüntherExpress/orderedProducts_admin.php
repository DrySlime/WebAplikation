<?php
    require_once "header.php";

    require_once "includes/admin_functions_inc.php";
?>
<head>
    <link rel="stylesheet" href="../CSS/header.css">

</head>
<body>
<div><br><br><br><br></div>

<div class="orderedProductList">
    <form action="orderedProducts_admin.php" method="post">
        <input type="text" name="search" placeholder="UserID eingeben">
        <button type="submit">Suche</button>
    </form>
</div>
<?php
$amount = 3;
    if(isset($_POST["search"])){
        echo "ssss";
    }else{
        $productArray=getAllOrderedProducts($conn);

    echo"
        <table>
            <tr>
                <th>order_id </th>
                <th>siteuser_id </th>
                <th>order_date </th>
                <th>payment_method_id </th>
                <th>shipping_address_id </th>
                <th>shipping_method_id </th>
                <th>order_total </th>
                <th>order_status_id </th>
        
            </tr>
    
            ";
            for($i=0;$i<count($productArray);$i++) {
                echo "
                <tr>
                        <td > ".$productArray[$i]["order_id"]." </td >
                        <td > ".$productArray[$i]["siteuser_id"]." </td >
                        <td > ".$productArray[$i]["order_date"]." </td >
                        <td > ".$productArray[$i]["payment_method_id"]." </td >
                        <td > ".$productArray[$i]["shipping_address_id"]." </td >
                        <td > ".$productArray[$i]["shipping_method_id"]." </td >
                        <td > ".$productArray[$i]["order_total"]." </td >
                        <td > ".$productArray[$i]["order_status_id"]." </td >                    
                    </tr >";
            };
        }
    
    ?>



</table>
</body>

