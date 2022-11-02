<?php
$serverName = "marktplatz.cosqj7qzoywl.eu-central-1.rds.amazonaws.com";
$dbUsername = "admin";
$dbPassword = "ihlegjihdgr";
$dbName = "marktplatz";

$conn = mysqli_connect($serverName,$dbUsername,$dbPassword,$dbName);
    if(!$conn){
        die('Connection failed :'.mysqli_connect_error());
        
    }
    