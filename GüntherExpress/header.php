<?php
    session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav>
        <div class="Wrapper">
            <a href="index.php">Back home</a>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php
                    if (isset($_SESSION["useruid"])){
                        echo "<li><a href='profile.php'>Profile</a></li>";
                        echo "<li><a href='includes/logout_include.php'>Login</a></li>";
                    }else{
                        echo '<li><a href="signup.php">Sign Up</a></li>';
                        echo '<li><a href="login.php">Login</a></li>';
                    }
                ?>
                
            </ul>
        </div>
    </nav>