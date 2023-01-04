<?php
require_once 'dbh_include.php';
require_once 'functions_include.php';
global $conn;


if (isset($_POST['register_button'])) {
    session_start();
    $usernameChange = $_POST['username'];
    $nameChange = $_POST['name'];
    $surnameChange = $_POST['surname'];
    $emailChange = $_POST['email'];
    $newPassword = $_POST['newpassword'];
    $oldPassword = $_POST['oldpassword'];


    if (invalidUid($usernameChange) !== false) {
        header("location: ../account.php?error=invaliduid");
        exit();
    } else if (invalidEmail($emailChange) !== false) {
        header("location: ../account.php?error=invalidemail");
        exit();
    }
    if (rightPassword($conn, $oldPassword)) {
        if ($usernameChange !== $_SESSION['useruid']) {
            if (uidExists($conn, $usernameChange, $usernameChange) !== false) {
                header("location: ../account.php?error=uidexists");
                exit();
            } else {
                changeAccount($conn, $usernameChange, $nameChange, $surnameChange, $emailChange, $newPassword);
                header("location: ../account.php?error=none");
                exit();
            }
        } else {
            changeAccount($conn, $usernameChange, $nameChange, $surnameChange, $emailChange, $newPassword);
            header("location: ../account.php?error=kms");
            exit();
        }
    } else {
        header("location: ../account.php?error=wrongpassword");
    }
    exit();
}


if (isset($_GET['edit'])) {
    $AddressID = $_GET['edit'];

    setDefaultAddress($conn, $AddressID);
    header("location: ../account.php?error=none");
    exit();

}

if (isset($_GET['delete'])) {
    $deleteAddressID = $_GET['delete'];

    unbindAddress($conn, $deleteAddressID);
    header("location: ../account.php?error=none");
    exit();

}


if (isset($_POST['add_address_button'])) {
    $streetAdd = $_POST['addStreet'];
    $housenoAdd = $_POST['addHausnummer'];
    $cityAdd = $_POST['addStadt'];
    $postalCodeAdd = $_POST['postal-code'];
    $addressExists =  mysqli_fetch_assoc(getAddressIDByData($conn, $streetAdd, $housenoAdd, $cityAdd, $postalCodeAdd));
    if ($addressExists == null) {
        addAddress($conn, $streetAdd, $housenoAdd, $cityAdd, $postalCodeAdd);
        exit();
    } else {
        bindAddressToUser($conn, $streetAdd, $housenoAdd, $cityAdd, $postalCodeAdd);
    }
    header("location: ../account.php?error=none");
    exit();

}



if (isset($_GET['editP'])) {
    $PaymentID = $_GET['editP'];

    setDefaultPayment($conn, $PaymentID);
    header("location: ../account.php?error=none");
    exit();

}

if (isset($_GET['deleteP'])) {
    $deletePaymentID = $_GET['deleteP'];

    unbindPayment($conn, $deletePaymentID);
    header("location: ../account.php?error=none");
    exit();

}


if (isset($_POST['add_payment_button'])) {
    $payment_type_id = $_POST['paymentMethod'];
    $provider = $_POST['addProvider'];
    $account_number = $_POST['addNumber'];
    $expiry_date = $_POST['expiry_date'];

    bindPaymentToUser($conn, $payment_type_id, $provider, $account_number, $expiry_date);
    header("location: ../account.php?error=none");
    exit();
}

if (isset($_POST['delete_Account'])) {
    $password = $_POST['delpassword'];
    $email = $_POST['delemail'];

    if (rightPassword($conn, $password) && rightEmail($conn, $email)) {
        deactivateUser($conn);
        session_unset();
        session_destroy();
        header("location: ../index.php");
        exit();
    } else {
        header("location: ../account.php?error=deletionfailed");
    }
}
    
    


    




