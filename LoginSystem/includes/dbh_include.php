<?php
$serverName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "marktplatz2";

$conn = mysqli_connect($serverName,$dbUsername,$dbPassword,$dbName);
    if(!$conn){
        die('Connection failed :'.mysgli_connect_error());
        
    }
    