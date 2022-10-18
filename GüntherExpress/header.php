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
            <a href="index.php"><img src="img/Logo.png" alt="Günther Express" width="400"></a>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href='category.php'>Kategorie</a></li>
                <?php
                    if (isset($_SESSION["useruid"])){
                        echo "<li><a href='profile.php'>Profile</a></li>";
                        echo "<li><a href='includes/logout_include.php'>Log-Out</a></li>";
                    }else{
                        echo '<li><a href="signup.php">Sign Up</a></li>';
                        echo '<li><a href="login.php">Login</a></li>';
                    }
                ?>
                <li><input type="text" name="searchbar" id="searchbar" placeholder="Warensuche..." ></li>
                
            </ul>
        </div>
    </nav>