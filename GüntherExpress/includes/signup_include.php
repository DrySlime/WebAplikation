<?php

if(isset($_POST["register_button"])){

    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['passwordrepeat'];
    $firstname = $_POST['name'];
    $lastname = $_POST['surname'];
    $username = $_POST['username'];
    

    //Error-Handling
    require_once 'dbh_include.php';
    require_once 'functions_include.php';

    if(emptyInputSignup($email,$password,$passwordRepeat,$firstname,$lastname,$username)!==false){
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if(invalidUid($username)!==false){
        header("location: ../signup.php?error=invaliduid");
        exit();
    }
    if(invalidEmail($email)!==false){
        header("location: ../signup.php?error=invalidemail");
        exit();
    }
    if(passwordMatch($password,$passwordRepeat)!==false){
        header("location: ../signup.php?error=passwordsdontmatch");
        exit();
    }
    if(uidExists($conn, $username,$email)!==false){
        header("location: ../signup.php?error=uidexists");
        exit();
    }

    createUser($conn,$email,$password,$firstname,$lastname,$username );


}else{
    header("location: ../signup.php");
    exit(  );
}