<?php
    include_once "header.php";
    require_once "includes/admin_functions_inc.php";

    $categories=getAllCategories($conn);
?>
<head>
    <link rel="stylesheet" href="CSS/sale_admin.css">
</head>
    <div><br><br><br><br></div>
<h1>Create a PROMOTION</h1>
<form action="includes/sale_admins_inc.php" method="post">
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
    Title: <input type="text" name="title"  placeholder="Sale Title" required><br>
    Description: <textarea name="description" placeholder="Description" rows="1" cols="60" required></textarea><br>
    Discount<input type="text" name="discount" placeholder="Discount 1-99" required><br>
    Start Date: <input type="date" name="start-date" placeholder="StartDate" required><br>
    End Date: <input type="date" name="end-date" required>
    <input type="submit" name="send_form">

</form>



<?php
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
$saleArr=getAllSales($conn);
if($saleArr!=null){
    echo"
        <div class='all'>
        <div class='table'>
        <table>
        <h1>Alle Sales</h1>
            <tr>
                <th>Category </th>
                <th>Sale Title </th>
                <th>Discount Rate </th>
                <th>Description </th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>CHANGE</th>
                <th>DELETE</th>
            </tr>
        
            ";
    for($i=0;$i<count($saleArr);$i++) {

    echo "
    <tr>
        <td > ".getCategoryNameViaPromotionID($conn,$saleArr[$i]["id"])." </td >
        <td > ".$saleArr[$i]["promotion_name"]." </td >
        <td > ".$saleArr[$i]["discount_rate"]." </td >
        <td > ".$saleArr[$i]["description"]." </td >
        <td > ".$saleArr[$i]["start_date"]." </td >
        <td > ".$saleArr[$i]["end_date"]." </td >
        <td > <a href='sale_admin.php?change=1&promotionID=".$saleArr[$i]["id"]."&promotionName=".$saleArr[$i]["promotion_name"]."&discountRate=".$saleArr[$i]["discount_rate"]." &description=".$saleArr[$i]["description"]."&startDate=".$saleArr[$i]["start_date"]."&endDate=".$saleArr[$i]["end_date"]."'><button>CHANGE</button></a> </td >
        <td > <form action='includes/deleteSale_inc.php' method='post'><input type='submit' name='delButton' value='DELETE'><input name='promotionID' value=".$saleArr[$i]["id"]." hidden> </form></td >
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
        <form action="includes/updateSale_inc.php" method="post">
            <label for="category">Choose a category:</label>
            <select  name="category_id" size="4" required>
            ';
            for ($i=0;$i<count($categories);$i++){
                echo "
                            <option value=".$categories[$i]["id"].">".$categories[$i]["category_name"]."</option>
                        ";
            };
            echo '
            </select><br>
            Title: <input type="text" name="title"  placeholder="Title: '.$_GET["promotionName"].'" required><br>
            Description: <textarea name="description" placeholder="Description: '.$_GET["description"].'" rows="1" cols="60" required></textarea><br>
            Discount <input type="text" name="discount" placeholder="Discount: '.$_GET["discountRate"].'%" required><br>
            Start Date before '.$_GET["startDate"].': <input type="date" name="start-date" placeholder="StartDate" required><br>
            End Date before '.$_GET["endDate"].': <input type="date" name="end-date" required><br>
            <input name="promoID" value='.$_GET["promotionID"].' hidden>
            <input type="submit" name="send_form" value="UPDATE">
    
        </form>
    </div>
    ';
}
?>
</div>
