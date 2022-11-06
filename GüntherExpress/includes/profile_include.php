<?php
require_once 'dbh_include.php';
require_once 'functions_include.php';

if (isset($_POST['change_password_btn']) {
    $oldPassword = $_POST['password_old'];
    $newPassword = $_POST['password_new'];
    $repeatPassword = $_POST['password_repeat'];

    if ( rightPassword($conn,$oldPassword) !== false) {
        header("location: ../profile.php?error=wronginput");
        exit();
        
    }
    else{
        
        if (passwordMatch($newPassword, $repeatPassword)!==false) {
            header("location: ../profile.php?error=passwordsdontmatch");
            exit();
        }
        else {
            changePassword($conn,$oldPassword);
            exit();
        }
    }

}
else{
    header("location: ../profile.php");
    exit();
}

if (isset($_POST['change_profile_btn']) {
    $usernameChange = $_POST['username_change'];
    $nameChange = $_POST['name_change'];
    $surnameChange = $_POST['surname_change'];
    $emailChange = $_POST['email_change'];

    if(invalidUid($username)!==false){
        header("location: ../profile.php?error=invaliduid");
        exit();
    }
    if(invalidEmail($email)!==false){
        header("location: ../profile.php?error=invalidemail");
        exit();
    }
    if(passwordMatch($password,$passwordRepeat)!==false){
        header("location: ../profile.php?error=passwordsdontmatch");
        exit();
    }
    if(uidExists($conn, $username,$email)!==false){
        header("location: ../profile.php?error=uidexists");
        exit();
    }

    if (emptyInputProfile()!==false) {
        header("location: ../profile.php?error= emptyinput");
            exit();
    }
    else {
        changeProfile($conn, $usernameChange, $nameChange, $surnameChange, $emailChange);
        exit();
    }

}
else{
    header("location: ../profile.php");
    exit();
}

if (isset($_POST['change_address_btn']) {
    $streetChange = $_POST['street_change'];
    $housenoChange = $_POST['houseno_change'];
    $cityChange = $_POST['city_change'];
    $postalCodeChange = $_POST['postal_code_change'];
    $addressID = #TODO

    else{
        changeAddress();
        exit();
    }

}
else{
    header("location: ../profile.php");
    exit();
}
    




