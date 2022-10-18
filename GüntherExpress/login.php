<?php
include_once 'header.php';
?>

    <section>
        <h2>Sign up</h2>
        <form action="includes/login_include.php" method="post">
            <input type="text" name="username" id="email/username" placeholder="E-mail/Benutzername"><br>
            <input type="password" name="password" id="password" placeholder="Passwort"><br>
            <button type="submit" name="login_button" onclick="return check_form()">Log In</button><br>
        </form>

    </section>
    <?php
        $errorMSG;
        if(isset($_GET["error"])){
            if($_GET["error"]=="emptyinput"){
                $errorMSG = "Manche Felder sind leer!";
                echo "<p>$errorMSG</p>";
            }else  if($_GET["error"]=="wronginput"){
                $errorMSG = "Username/Email und oder Passwort falsch!";
                echo "<p>$errorMSG</p>";
            }
        }
    ?>


<?php
include_once 'footer.php';
?>