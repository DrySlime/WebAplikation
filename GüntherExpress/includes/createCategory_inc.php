<?php
if(isset($_POST["send_form"])){
    require_once 'dbh_include.php';
    require_once 'functions_include.php';
    global $conn;
    $title = $_POST['title'];
    $parentID = $_POST['parentID'];

    createCategory($conn,$title,$parentID );

    header("location: ../category_admin.php");
    exit(  );
}