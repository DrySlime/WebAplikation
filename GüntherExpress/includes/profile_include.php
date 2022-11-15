<?php
require_once 'dbh_include.php';
require_once 'functions_include.php';


    if (isset($_POST['change_password_btn'])){
        session_start();

        $oldPassword = $_POST['password_old'];
        $newPassword = $_POST['password_new'];
        $repeatPassword = $_POST['password_repeat'];
    
        if ( rightPassword($conn,$oldPassword) ) {
            if (passwordMatch($newPassword, $repeatPassword)!==false) {
                header("location: ../profile.php?error=passwordsdontmatch");
                exit();
            }
            else {
                changePassword($conn,$newPassword);
                exit();
            }
            
        }
        else{
            header("location: ../profile.php?error=wonginput");
            exit();
            
        }
    
    }
    
    
    if (isset($_POST['change_profile_btn'])) {
        session_start();
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
        else if($usernameChange !== $_SESSION['useruid']){
            if(uidExists($conn, $usernameChange,$usernameChange)!==false){
                header("location: ../profile.php?error=uidexists");
                exit();
            }
            else {
                changeProfile($conn, $usernameChange, $nameChange, $surnameChange, $emailChange);
                exit();
            }
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
            header("location: ../profile.php?error=invalidaddress");
            exit();
        }
        else{
            if (getAddressIDByData($conn,$streetChange,$housenoChange,$cityChange,$postalCodeChange) !== null) {
                bindAddressToUser($conn,$streetChange,$housenoChange,$cityChange,$postalCodeChange);
            }
            else{
                changeAddress($conn,$addressID,$streetChange,$housenoChange,$cityChange,$postalCodeChange);
                exit();
            }
            unbindAddress($conn,$addressID);
            
        }
    
    }
    
    
    if (isset($_POST['change_address_action'])) {
        session_start();
        $changeAddressID = $_POST['address_ID'];
    
        if (invalidUserAddress($conn,$changeAddressID) == false) {
            $_SESSION['change_address_id'] = $changeAddressID;
            exit();
        }
        else{
            header("location: ../profile.php?error=invalidchangeaddress");
            exit();
            
        }
    
    }

    if (isset($_POST['delete_address'])) {
        session_start();
        $deleteAddressID = $_POST['address_ID'];
    
        unbindAddress($conn, $deleteAddressID);
        header("location: ../profile.php?error=none");
        exit();
    
    }
    
    
    if (isset($_POST['add_address_btn'])) {
        session_start();
        $streetChange = $_POST['street_change'];
        $housenoChange = $_POST['houseno_change'];
        $cityChange = $_POST['city_change'];
        $postalCodeChange = $_POST['postal_code_change'];
        $addressHope = getAddressIDByData($conn,$streetChange,$housenoChange,$cityChange,$postalCodeChange);
        echo $addressHope['id'];
        if ( $addressHope['id'] == null) {
            echo 'i want to live';
            addAddress($conn,$streetChange,$housenoChange,$cityChange,$postalCodeChange);
            exit();
        }
        else{
            echo 'i want to die';
            bindAddressToUser($conn,$streetChange,$housenoChange,$cityChange,$postalCodeChange);
        }
    
    }
    


    




