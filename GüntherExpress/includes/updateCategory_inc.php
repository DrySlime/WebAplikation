<?php
if(isset($_POST["send_form"])){

    $iD = $_POST['id'];
    $parentID = $_POST['parent_category_id'];
    $title = $_POST['category_name'];



    //Error-Handling
    require_once 'dbh_include.php';
    require_once 'functions_include.php';

    if($iD<=8&&$parentID!=$iD){
        header("location: ../category_admin.php?illegalChange");
        exit();
    }

    updateCategory($conn,$parentID,$title,$iD);
}else{
    header("location: ../admin/admin_categories.php");
    exit(  );
}