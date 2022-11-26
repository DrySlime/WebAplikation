<?php
if(isset($_POST["send_form"])){


    $title = $_POST['title'];
    $parentID = $_POST['parentID'];



    //Error-Handling
    require_once 'dbh_include.php';
    require_once 'functions_include.php';





    createCategory($conn,$title,$parentID );

    header("location: ../category_admin.php");
    exit(  );
}else{

}