<?php
if (isset($_GET['edit'])) {
    $AddressID = $_GET['edit'];

    setDefaultAddress($conn, $AddressID);
    header("location: ../checkout.php?error=none");
    exit();

}

if (isset($_GET['delete'])) {
    $deleteAddressID = $_GET['delete'];

    unbindAddress($conn, $deleteAddressID);
    header("location: ../checkout.php?error=none");
    exit();

}


if (isset($_POST['add_address_button'])) {
    $streetAdd = $_POST['addStreet'];
    $housenoAdd = $_POST['addHausnummer'];
    $cityAdd = $_POST['addStadt'];
    $postalCodeAdd = $_POST['postal-code'];
    $addressExists =  getAddressIDByData($conn, $streetAdd, $housenoAdd, $cityAdd, $postalCodeAdd)-> fetch_assoc();
    if ($addressExists == null) {
        addAddress($conn, $streetAdd, $housenoAdd, $cityAdd, $postalCodeAdd);
        exit();
    } else {
        bindAddressToUser($conn, $streetAdd, $housenoAdd, $cityAdd, $postalCodeAdd);
    }
    header("location: ../checkout.php?error=none");
    exit();

}



if (isset($_GET['editP'])) {
    $PaymentID = $_GET['editP'];

    setDefaultPayment($conn, $PaymentID);
    header("location: ../checkout.php?error=none");
    exit();

}

if (isset($_GET['deleteP'])) {
    $deletePaymentID = $_GET['deleteP'];

    unbindPayment($conn, $deletePaymentID);
    header("location: ../checkout.php?error=none");
    exit();

}


if (isset($_POST['add_payment_button'])) {
    $payment_type_id = $_POST['paymentMethod'];
    $provider = $_POST['addProvider'];
    $checkout_number = $_POST['addNumber'];
    $expiry_date = $_POST['expiry_date'];

    bindPaymentToUser($conn, $payment_type_id, $provider, $checkout_number, $expiry_date);
    header("location: ../checkout.php?error=none");
    exit();
}