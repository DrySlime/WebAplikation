<!DOCTYPE html>
<html lang="ger">

    <head>



        <?php
        include_once 'header.php';
        require_once 'includes/dbh_include.php';
        require_once 'includes/functions_include.php';
        ?>
        <link rel="stylesheet" href="CSS/category.css">
    </head>


    <body>

        <?php
        $parentCategory = $_GET["name"];

        echo $parentCategory;
        ?>
        <div class="kategoriepic">

        </div>
        <div id="tmp"></div>
        <?php
        include_once 'footer.php';
        ?>
        <script src="JS/category.js"></script>
    </body>

</html>


