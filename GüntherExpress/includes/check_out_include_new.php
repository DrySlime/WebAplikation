<?php 
require_once 'dbh_include.php';
require_once 'functions_include.php';
global $conn;

if (isset($_POST['add_address_button'])) {
    $streetAdd = $_POST['addStreet'];
    $housenoAdd = $_POST['addHausnummer'];
    $cityAdd = $_POST['addStadt'];
    $postalCodeAdd = $_POST['postal-code'];
    $addressExists = getAddressIDByData($conn, $streetAdd, $housenoAdd, $cityAdd, $postalCodeAdd);
    if ($addressExists['id'] == null) {
        addAddress($conn, $streetAdd, $housenoAdd, $cityAdd, $postalCodeAdd);
        header("location: ../checkout.php?error=none");
        exit();
    } else {
        bindAddressToUser($conn, $streetAdd, $housenoAdd, $cityAdd, $postalCodeAdd);
        header("location: ../checkout.php?error=none");
    }

}

if (isset($_POST['delivery_buttons'])) {
    $_SESSION['paymentMethod'] = $_GET['value'];
}
