<?php
include_once "includes/admin_functions_inc.php";
include_once "includes/dbh_include.php";
include_once "header.php";
?>
<br><br><br>
<?php
if (isset($_GET["error"])){
    if($_GET["error"]=="IllegalDelete"){
        echo "<br><h1 style='color: red'>You are not allowed to delete this category</h1><br>";
    }
}

?>
<head>
    <link rel="stylesheet" href="CSS/category_admin.css">
</head>
<body>
<h1>Erstelle eine neue Kategorie:</h1>
    <form action="includes/createCategory_inc.php" method="post">
        Category Name: <input type="text" name="title"  placeholder="Category Title" required><br>
        Parent Category: <select id="cars" name="parentID" size="4" required>
            <?php
            $cateArr=getAllCategories($conn);
            var_dump($cateArr);
            for ($i=0;$i<count($cateArr);$i++){
                echo "
                    <option value=".$cateArr[$i]["id"].">".$cateArr[$i]["category_name"]."</option>
                ";
            }

            ?>

        </select><br>
        <input type="submit" name="send_form">

    </form>
</body>

<?php


if($cateArr!=null){
    echo"
        <div class='all'>
            <div class='table'>
                <table>
                    <h1>Alle Kategorien</h1>
                        <tr>
                            <th>ID </th>
                            <th>Parent Category ID</th>
                            <th>Category Name</th>
                            <th>CHANGE</th>
                            <th>DELETE</th>
                        </tr>
                    
                        ";
                for($i=0;$i<count($cateArr);$i++) {

                    echo "
                <tr>
                    <td > ".$cateArr[$i]["id"]." </td >
                    <td > ".$cateArr[$i]["parent_category_id"]." </td >
                    <td > ".$cateArr[$i]["category_name"]." </td >
                    <td > <a href='category_admin.php?change=1&id=".$cateArr[$i]["id"]."&parentID=".$cateArr[$i]["parent_category_id"]."&categoryName=".$cateArr[$i]["category_name"]."'><button>CHANGE</button></a> </td >
                    <td > <form action='includes/deleteCategory_inc.php' method='post'><input type='submit' name='delButton' value='DELETE'><input name='categoryID' value=".$cateArr[$i]["id"]." hidden> </form></td >
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
        <div class="changeFormBox">
            <h1>UPDATE FORM ID-'.$_GET["id"].': </h1>
            <hr style="height: 5px;background-color: #101010"><br>
                <form action="includes/updateCategory_inc.php" method="post">
                     New Category Name: <input type="text" name="category_name"  value="'.$_GET["categoryName"].'" required><br>
        
                    <label for="category">Choose a new Parent Category:</label>
                    <select  name="parent_category_id" size="4" required>
                    ';
            for ($i=0;$i<count($cateArr);$i++){
                echo "
                                    <option value=".$cateArr[$i]["id"].">".$cateArr[$i]["category_name"]."</option>
                                ";
            };
            echo '
                    </select><br>
                    <input type="text" name="id"  value='.$_GET["id"].' hidden>
          
                    <input type="submit" name="send_form" value="UPDATE">
                    <a href="category_admin.php"><button formnovalidate>CANCEL</button></a>

                </form>
        </div>
        
    </div>
    ';
}

?>
</div>