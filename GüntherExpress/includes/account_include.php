<?php
require_once 'dbh_include.php';
require_once 'functions_include.php';


    
    #TODO : change password hakt
    if (isset($_POST['register_button'])) {
        session_start();
        $usernameChange = $_POST['username'];
        $nameChange = $_POST['name'];
        $surnameChange = $_POST['surname'];
        $emailChange = $_POST['email'];
        $newPassword = $_POST['newpassword'];
        $oldPassword = $_POST['oldpassword'];
        

        if(invalidUid($usernameChange)!==false){
            header("location: ../account.php?error=invaliduid");
            exit();
        }
        else if(invalidEmail($emailChange)!==false){
            header("location: ../account.php?error=invalidemail");
            exit();
        }
        if(rightPassword($conn,$oldPassword)){
            if($usernameChange !== $_SESSION['useruid']){
                if(uidExists($conn, $usernameChange,$usernameChange)!==false){
                header("location: ../account.php?error=uidexists");
                exit();
                }   
                else {
                    changeAccount($conn, $usernameChange, $nameChange, $surnameChange, $emailChange,$newPassword);
                        header("location: ../account.php?error=none");
                        exit();
                    
                }
            } else {
                changeAccount($conn, $usernameChange, $nameChange, $surnameChange, $emailChange,$newPassword);
                        header("location: ../account.php?error=none");
                        exit();
            }
            
        }
        else{
            header("location: ../account.php?error=wrongpassword");
        }
        
        exit();
    
    }
    
    
    #TODO
    if (isset($_POST['change_address_action'])) {
        session_start();
        $changeAddressID = $_POST['address_ID'];
    
        if (invalidUserAddress($conn,$changeAddressID) == false) {
            $_SESSION['change_address_id'] = $changeAddressID;
            header("location: ../account.php?error=none");
            exit();
        }
        else{
            header("location: ../account.php?error=invalidchangeaddress");
            exit();
            
        }
    
    }
    #TODO
    if (isset($_POST['delete_address'])) {
        session_start();
        $deleteAddressID = $_POST['address_ID'];
    
        unbindAddress($conn, $deleteAddressID);
        header("location: ../account.php?error=none");
        exit();
    
    }
    
    
    if (isset($_POST['add_address_button'])) {
        $streetAdd = $_POST['addStreet'];
        $housenoAdd = $_POST['addHausnummer'];
        $cityAdd = $_POST['addStadt'];
        $postalCodeAdd = $_POST['postal-code'];
        $addressExists = getAddressIDByData($conn,$streetAdd,$housenoAdd,$cityAdd,$postalCodeAdd);
        if ( $addressExists['id'] == null) {
            addAddress($conn,$streetAdd,$housenoAdd,$cityAdd,$postalCodeAdd);
            exit();
        }
        else{
            bindAddressToUser($conn,$streetAdd,$housenoAdd,$cityAdd,$postalCodeAdd);
        }
    
    }

    if (isset($_POST['delete_Account'])) {
        $password = $_POST['delpassword'];
        $email = $_POST['delemail'];

        if (rightPassword($conn,$password) && rightEmail($conn,$email)) {
            deactivateUser($conn);
            session_unset();
            session_destroy();
            header("location: ../index.php");
            exit();
        }
        else {
            header("location: ../account.php?error=deletionfailed");
        }
    }

    
    


    




