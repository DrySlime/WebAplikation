<!DOCTYPE html>
<html lang="de">

<?php
include_once 'header.php';
include_once 'hero.php';
session_start();
$_SESSION['useruid'] = 1234;
?>

<head>
    <link rel="stylesheet" href="CSS/index.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
    <title>The Confectioner</title>
</head>

<body">
<div class="newitems">
    <div class="newitems_header">
            <h1>Neuheiten</h1>
            <h4>Schau was beim Confectioner neu eingetroffen ist!</h4>
        </div>
        <div class="bestsellers_scroller">

        </div>
    </div>

<div class="bestsellers">
    <div class="bestsellers_header">
            <h1>Bestseller</h1>
            <h4>Hol Dir die beliebtesten Schokoladen unserer Kunden!</h4>
    </div>
    <div class="newitems_scroller">
        </div>
    </div>
</body>

</html>

<?php
include_once 'footer.php';
?>