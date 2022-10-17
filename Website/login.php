<?php
include database.php

public function checkLogin($user, $password){

    //Datenbankabfrage ob User mit genannten Passwort existiert.
    //"SELECT password FROM account WHERE name="+$user+""

    $pw = command("SELECT password FROM account WHERE name="+$user+"");

    $pwHash = hash(
        string "sha512",
        string $password,
        bool $binary = false,
        array $options = []
    ): string

    if($password == $pw){

        return true;

    }

    return false;

}


?>