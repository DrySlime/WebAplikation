<?php

if(isset($_POST["submit"])){

    $password = $_POST['password'];
    $username = $_POST['username'];
    

    //Error-Handling
    require_once 'dbh_include.php';
    require_once 'functions_include.php';

    if(emptyInputLogin($password,$username)!==false){
        header("location: ../login.php?error=emptyinput");
        exit();
    }
   
    

    loginUser($conn,$password,$username );


}else{
    header("location: ../login.php");
    exit(  );
}