<!DOCTYPE html>
<html lang="ger">

    <head>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

        <link rel="stylesheet" href="CSS/category.css">
        <?php
        include_once 'header.php';
        require_once 'includes/dbh_include.php';
        require_once 'includes/functions_include.php';
        ?>
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


