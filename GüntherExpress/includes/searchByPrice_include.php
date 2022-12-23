<?php

$category=convertCategoryNameToID($conn, $_GET["name"]);
$min=$_POST["min"];
$max=$_POST["max"];

header("../products.php?catID=$category&min=$min&max=$max");