<?php
require_once 'dbh_include.php';
require_once 'functions_include.php';


    if (isset($_POST['change_password_btn'])){
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
    
    
    if (isset($_POST['change_profile_btn'])) {
        
        $usernameChange = $_POST['username_change'];
        $nameChange = $_POST['name_change'];
        $surnameChange = $_POST['surname_change'];
        $emailChange = $_POST['email_change'];

        if(invalidUid($usernameChange)!==false){
            header("location: ../profile.php?error=invaliduid");
            exit();
        }
        else if(invalidEmail($emailChange)!==false){
            header("location: ../profile.php?error=invalidemail");
            exit();
        }
        else if (emptyInputProfile($emailChange,$nameChange,$surnameChange,$usernameChange)!==false) {
            header("location: ../profile.php?error= emptyinput");
                exit();
        }
        else {
            changeProfile($conn, $usernameChange, $nameChange, $surnameChange, $emailChange);
            exit();
        }
    
    }
    
    
    if (isset($_POST['change_address_btn'])) {
        $streetChange = $_POST['street_change'];
        $housenoChange = $_POST['houseno_change'];
        $cityChange = $_POST['city_change'];
        $postalCodeChange = $_POST['postal_code_change'];
        $addressID = $_POST['address_ID'];
    
        if (invalidUserAddress($conn,$addressID)!==false) {
            header("location: ../profile.php?error= invalidaddress");
                exit();
        }
        else{
            changeAddress($conn,$addressID,$streetChange,$housenoChange,$cityChange,$postalCodeChange);
            exit();
        }
    
    }
    
    
    if (isset($_POST['change_address_action'])) {
        $changeAddressID = $_POST['address_ID'];
    
        if (invalidUserAddress($conn,$addressID)!==false) {
            header("location: ../profile.php?error= invalidaddress");
                exit();
        }
        else{
            $_SESSION['change_address_id'] = $changeAddressID;
            exit();
        }
    
    }
    
    
    if (isset($_POST['add_address_btn'])) {
        $streetChange = $_POST['street_change'];
        $housenoChange = $_POST['houseno_change'];
        $cityChange = $_POST['city_change'];
        $postalCodeChange = $_POST['postal_code_change'];
        if (getAddressIDByData($conn,$streetChange,$housenoChange,$cityChange,$postalCodeChange) === null) {
            bindAddressToUser($conn,$streetChange,$housenoChange,$cityChange,$postalCodeChange);
        }
        else{
            addAddress($conn,$streetChange,$housenoChange,$cityChange,$postalCodeChange);
            exit();
        }
    
    }
    


    




