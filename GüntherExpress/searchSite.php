<head>
    <link rel="stylesheet" href="CSS/index.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
</head>


<?php
    include_once 'header.php';
    require_once 'includes/dbh_include.php';
    require_once 'includes/functions_include.php';
    require_once 'includes/product_include.php';
?>
<?php
    $searchbarValue = $_POST['searchbar'];

    $searchArr=searchbar($searchbarValue,$conn);
    
    if($searchArr!=null){
        for($i=0;$i<count($searchArr);$i++){
            $productData = getProductData($conn,$searchArr[$i]);

            $name = $productData["product_name"];
            $description = $productData["description"];
            $price = $productData["price"];
            $image = $productData["product_image"];
            $parentID = $productData["product_category_id"];
        
            echo"<div name='product_box'>
                        <p>".$name."</p>
                        <img name='product_image' src='".$image."'>
                        <p>Verkaufspreis: ".$price."€</p>
                </div>";
        }
        $temp=0;
        //var_dump($parentID);
        $categoryArr=searchItemInCategory($searchbarValue,$conn);
        if($categoryArr!=null){
            
            $categoryName = convertIdToCategoryName($conn,$categoryArr[0]);
            for($i=0;$i<count($categoryArr);$i++){
                $temp++;
                echo '<div class="item_border" id="item_border_'.$temp.'">';
                echo '<a href="javascript:void(0);"><div class="scroll_left_button" id="scroll_left_button_'.$temp.'">
                        <div class="arrow_left"><img src="img/arrow_left.png"></div>
                    </div></a>';
                echo '<a href="javascript:void(0);"><div class="scroll_right_button" id="scroll_right_button_'.$temp.'">
                <div class="arrow_right"><img src="img/arrow_right.png"></div>
                </div></a>';
                echo '<div class="category_item_line category_item_line_'.$temp.'" id="category_item_line_'.$temp.'"><h1>Mehr von '.$categoryName.'</h1>';
                echo '<ul>';
                showItems($conn,30,$categoryName);
                echo '</ul></div></div>';
                
            }
        }
        
        //you might also like these products.css:
        if($parentID!==null && $categoryArr==null){
            $categoryName = convertIdToCategoryName($conn,$parentID);
            $temp++;
            echo '<div class="item_border" id="item_border_'.$temp.'">';
            echo '<a href="javascript:void(0);"><div class="scroll_left_button" id="scroll_left_button_'.$temp.'">
                    <div class="arrow_left"><img src="img/arrow_left.png"></div>
                </div></a>';
            echo '<a href="javascript:void(0);"><div class="scroll_right_button" id="scroll_right_button_'.$temp.'">
            <div class="arrow_right"><img src="img/arrow_right.png"></div>
            </div></a>';
            echo '<div class="category_item_line category_item_line_'.$temp.'" id="category_item_line_'.$temp.'"><h1>Könnte dir auch gefallen</h1>';
            echo '<ul>';
            showItems($conn,30,$categoryName);
            echo '</ul></div></div>';
            
        }
        
        
        
        
    }else{
        echo"<p>Produkt nicht vorhanden, überprüfen sie ihre eingabe</p>";
    }
    
    //showRandomCategoriesAndItems($conn,$categoryAmount=4,$productAmount=10);

    




?>
<script src="JS/index.js"></script>
<?php
    include_once 'footer.php';
?>