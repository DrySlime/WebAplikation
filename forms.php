<?php

//Data from Site
$artikelname = $_Post["artikelname"];
$preis = $_Post["preis"];
$menge = $_Post["menge"];
$beschreibung = $_Post["beschreibung"];
$kategorie = "1";

//Serverinfo
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "marktplatz";
$port = 3306;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname,$port);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
else{
    echo "Connected";
}

$sql = "INSERT INTO artikel (Name,Preis,Menge,Beschreibung,KategorieID)
VALUES ($artikelname, $preis, $menge, $beschreibung,$kategorie);";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>