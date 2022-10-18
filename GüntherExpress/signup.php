<?php
include_once 'header.php';
?>

    <section>
        <h2>Sign up</h2>
        <form action="includes/signup_include.php" method="post">
             <input type="text" name="firstname" id="firstname" placeholder="Vorname:"><br>
             <input type="text" name="lastname" id="lastname" placeholder="Nachname:"><br>
             <input type="text" name="username" id="username" placeholder="Username"><br>
             <input type="text" name="email" id="email" placeholder="E-mail:"><br>
             <input type="password" name="password" id="password" placeholder="Passwort:"><br>
             <input type="password" name="repeat_password" id="repeat_password" placeholder="Passwort wiederholen:"><br>
            <input type="submit" name="submit" onclick="return check_form()"><br>
        </form>

    </section>

    <?php
        $errorMSG;
        if(isset($_GET["error"])){
            if($_GET["error"]=="emptyinput"){
                $errorMSG = "Manche Felder sind leer!";
                echo "<p>$errorMSG</p>";
            }else  if($_GET["error"]=="invaliduid"){
                $errorMSG = "Username beinhaltete nicht unterstützte Zeichen!";
                echo "<p>$errorMSG</p>";
            }else  if($_GET["error"]=="invalidemail"){
                $errorMSG = "Email wird bereits verwendet";
                echo "<p>$errorMSG</p>";
            }else  if($_GET["error"]=="passwordsdontmatch"){
                $errorMSG = "Passwörter stimmen nicht überein!";
                echo "<p>$errorMSG</p>";
            }else  if($_GET["error"]=="uidexists"){
                $errorMSG = "Username wird bereits verwendet!";
                echo "<p>$errorMSG</p>";
            }
        }
    ?>


<?php
include_once 'footer.php';
?>