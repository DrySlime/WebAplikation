<head>
    <link rel="stylesheet" href="CSS/index.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
</head>
<?php
    include_once 'header.php';
    require_once 'includes/dbh_include.php';
    require_once 'includes/functions_include.php';
require_once 'includes/review_functions.php';
?>

<?php
if (isset($_SESSION["useruid"])) {
    echo "<p>Moin " . $_SESSION["useruid"] . "</p>";
} else {
}
?>

<?php
    showRandomCategoriesAndItems($conn,$categoryAmount=4,$productAmount=10);
?>

<?php getBestRatedProducts($conn,5); ?>

<!-- TODO: PRODUKTKARUSSEL DAS SICH VON ALLEINE DREHT -->


    
<script src="JS/index.js"></script>
<?php
include_once 'footer.php';
?>