<?php

if (isset($_POST["register_button"])) {
    global $conn;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['passwordrepeat'];
    $firstname = $_POST['name'];
    $lastname = $_POST['surname'];
    $username = $_POST['username'];

    //Error-Handling
    require_once 'dbh_include.php';
    require_once 'functions_include.php';

    if (emptyInputSignup($email, $password, $passwordRepeat, $firstname, $lastname, $username) !== false) {
        header("location: ../signup.php?error=emptyinput&post&uid=" . $username . "&pre=" . $firstname . "&sur=" . $lastname . "&mail=" . $email);
        exit();
    }
    if (invalidUid($username) !== false) {
        header("location: ../signup.php?error=invaliduid&post&uid=" . $username . "&pre=" . $firstname . "&sur=" . $lastname . "&mail=" . $email);
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../signup.php?error=invalidemail&post&uid=" . $username . "&pre=" . $firstname . "&sur=" . $lastname . "&mail=" . $email);
        exit();
    }
    if (passwordMatch($password, $passwordRepeat) !== false) {
        header("location: ../signup.php?error=passwordsdontmatch&post&uid=" . $username . "&pre=" . $firstname . "&sur=" . $lastname . "&mail=" . $email);
        exit();
    }
    if (uidExists($conn, $username, $email) !== false) {
        header("location: ../signup.php?error=uidexists&post&uid=" . $username . "&pre=" . $firstname . "&sur=" . $lastname . "&mail=" . $email);
        exit();
    }
    createUser($conn, $email, $password, $firstname, $lastname, $username);
} else {
    header("location: ../login.php");
    exit();
}