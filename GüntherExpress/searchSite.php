<?php
    include_once 'header.php';
    require_once 'includes/dbh_include.php';
    require_once 'includes/functions_include.php';
?>
<?php
    $searchbarValue = $_POST['searchbar'];

    $searchArr=searchbar($searchbarValue,$conn);

    var_dump($searchArr);
?>
    
<?php
    include_once 'footer.php';
?>