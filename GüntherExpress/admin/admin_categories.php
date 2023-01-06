<?php
include_once "includes/admin_functions_inc.php";
include_once "../includes/dbh_include.php";
include_once "admin_header.php";

global $conn;
?>
<br><br><br>
<?php
if (isset($_GET["error"])){
    if($_GET["error"]=="IllegalDelete"){
        ?>
        <br><h1 style='color: red'>You are not allowed to delete this category</h1><br>
        <?php 
    }
}

?>
<head>
    <link rel="stylesheet" href="CSS/category_admin.css">
    <title></title>
</head>
<body>
<h1>Erstelle eine neue Kategorie:</h1>
    <form action="../includes/createCategory_inc.php" method="post">
        Category Name: <label>
            <input type="text" name="title"  placeholder="Category Title" required>
        </label><br>
        Parent Category: <label for="cars"></label><select id="cars" name="parentID" size="4" required>
            <?php
            $cateArr=getAllCategories($conn);
            var_dump($cateArr);
            for ($i=0;$i<count($cateArr);$i++){
            ?>
                    <option value=".$cateArr[$i]["id"].">".$cateArr[$i]["category_name"]."</option>
            <?php
            }

            ?>

        </select><br>
        <input type="submit" name="send_form">

    </form>
    <?php


if($cateArr!=null){
    ?>
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
                    
                <?php
                for($i=0;$i<count($cateArr);$i++) {

                ?>
                <tr>
                    <td > "<?php echo $cateArr[$i]["id"]?>" </td >
                    <td > "<?php echo $cateArr[$i]["parent_category_id"]?>" </td >
                    <td > "<?php echo $cateArr[$i]["category_name"]?>" </td >
                    <td > <a href='admin_categories.php?change=1&id=<?php echo $cateArr[$i]["id"]?>&parentID=<?php echo $cateArr[$i]["parent_category_id"]?>&categoryName=<?php echo$cateArr[$i]["category_name"]?>'><button>CHANGE</button></a> </td >
                    <td > <form action='../includes/deleteCategory_inc.php' method='post'><input type='submit' name='delButton' value='DELETE'><input name='categoryID' value="<?php echo $cateArr[$i]["id"]?>" hidden> </form></td >
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
        <div class="changeFormBox">
            <h1>UPDATE FORM ID-<?php echo $_GET["id"]?>: </h1>
            <hr style="height: 5px;background-color: #101010"><br>
                <form action="../includes/updateCategory_inc.php" method="post">
                     New Category Name: <input type="text" name="category_name"  value="<?php echo $_GET["categoryName"]?>" required><br>
        
                    <label for="category">Choose a new Parent Category:</label>
                    <select  name="parent_category_id" size="4" required>
            <?php
            for ($i=0;$i<count($cateArr);$i++){
            ?>
                                    <option value="<?php echo $cateArr[$i]["id"]?>"><?php echo $cateArr[$i]["category_name"]?></option>
            <?php 
            }
            ?>
                    </select><br>
                    <input type="text" name="id"  value='<?php echo $_GET["id"]?>' hidden>
          
                    <input type="submit" name="send_form" value="UPDATE">
                    <a href="admin_categories.php"><button formnovalidate>CANCEL</button></a>

                </form>
        </div>
        
    </div>
<?php
}
?>
</body>

<?php
include_once "admin_footer.php";
?>
