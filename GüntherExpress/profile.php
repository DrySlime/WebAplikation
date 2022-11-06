<!DOCTYPE html>
<html>
<link rel="stylesheet" href="CSS/profile.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

<head>
    <script type="application/javascript" src="JS\profile.js"></script>
</head>



<body>
    <div class="container">
        <div class="icon" >
            <div class="profile" onclick="showProfile()">
                <div class="cover"><img src=".\img\icons\profile_icon.png" alt=""></div>
                <div class="icon_text profile_text">Profil</div>
            </div>
            <div class="profile_info">
                <div class="headline">Deine Daten</div>
                
                <div class="tags username_tag">Nutzername:</div>
                <div class="tags username_info_tag">
                #TODO<?php echo " $DB_USERNAME" ; ?>
                </div>

                <div class="tags name_tag">Name:</div>
                <div class="tags name_info_tag">
                #TODO <?php echo  $DB_NAME; ?>
                </div>

                <div class="tags surname_tag">Nachame:</div>
                <div class="tags surname_info_tag">
                #TODO<?php echo  $DB_SURNAME; ?>
                </div>

                <div class="tags email_tag">Email-Adresse:</div>
                <div class="tags email_info_tag">
                #TODO<?php echo  $DB_EMAIL; ?>
                </div>

                <button class="btn" name="to_edit_profile_btn" onclick="function showProfileEdit()">Profildaten
                    ändern</button>
            </div>
            <div class="change_profile">
                <div class="headline">Deine Daten verändern</div>
                <form action="profile_include.php" method="post">
                <div class="tags name_tag">Name:</div>
                    <input type="text" name="username_change" class="username_change" value="#TODO <?php  echo $DB_USERNAME ?> "><br>
                    <div class="tags name_tag">Name:</div>
                    <input type="text" name="name_change" class="name_change" value="#TODO <?php  echo $DB_NAME ?> "><br>
                    <div class="tags surname_tag">Nachame:</div>
                    <input type="text" name="surname_change" class="surname_change" value="#TODO <?php echo $DB_SURNAME ?>"><br>
                    <div class="tags email_tag">Email-Adresse:</div>
                    <input type="email" name="email_change" class="email_change" value="#TODO <?php echo $DB_EMAIL ?>" required><br>
                    <button class="btn" type="submit" name="change_profile_btn" >Profildaten abschicken</button>
                </form>
            </div>
        </div>
        <div class="icon passwort_icon">
            <div class="password">
                <div class="cover"><img src="https://img.icons8.com/material/452/user-lock.png" alt=""></div>
                <div class="icon_text password_text">Passwort <br> ändern</div>
            </div>
            <div class="manage_password">
                <div class="headline">Passwort Verwalten</div>
                <div class="change_password">Passwort ändern</div>
                <form action="includes/proflie_includes.php" method="post">
                    <input type="password" name="password_old" class="password_old" placeholder="Altes Passwort" required><br>
                    <input type="password" name="password_new" class="password_new" placeholder="Neues Passwort"
                        required><br>
                    <input type="password" name="password_repeat" class="password_repeat"
                        placeholder="Passwort wiederholen" required><br>
                    <button class="btn" type="submit" name="change_password_btn" onclick="#TODO">Passwort
                        ändern</button>
                </form>

                <div>Passwort vergessen #TODO</div>
            </div>
        </div>
        <div class="icon ">
            <div class="address">
                <div class="cover"><img src=".\img\icons\address_icon.png" alt=""></div>
                <div class="icon_text address_text">Adresse</div>
            </div>
            <div class="address_info">
                <div class="headline">Deine Adresse(n)</div>
                #TODO
                <div class="tags address_tag">Adresse:</div>
                <div class="tags street_info_tag">#TODO DB_STREET</div>
                <div class="tags houseno_info_tag">#TODO DB_HOUSENO</div>
                <div class="tags city_tag">Stadt:</div>
                <div class="tags city_info_tag">#TODO DB_CITY</div>
                <div class="tags postal_code_tag">PLZ:</div>
                <div class="tags postal_code_info_tag">#TODO DB_POSTAL_CODE</div>
            </div>
            <div class="change_address">
                <div class="headline">Adresse ändern</div>
                <form>
                    <div class="tags address_tag">Adresse:</div>
                    <input type="text" name="street_change" class="street_info_tag" value="#TODO DB_STREET">
                    <input type="text" name="houseno_change" class="houseno_info_tag" value="#TODO DB_HOUSENO"><br>
                    <div class="tags city_tag">Stadt:</div>
                    <input type="text" name="city_change" class="city_change" value="#TODO DB_CITY"><br>
                    <div class="tags postal_code_tag">PLZ:</div>
                    <input type="text" name="postal_code_change" class="postal_code_change"
                        value="#TODO DB_POSTAL_CODE"><br>
                    <button class="btn" type="submit" name="change_address_btn" onclick="#TODO">Adresse ändern</button>
                </form>
            </div>
        </div>

    </div>
    <div class="icon ">
        <div class="cart">
            <div class="cover"><img src="https://img.icons8.com/material/344/shopping-cart.png" alt=""></div>
            <div class="icon_text cart_text">Warenkorb</div>
        </div>
        <div class="cart_info">
            <div class="headline">Dein Einkaufswagen</div>
        </div>
    </div>

    </div>

</body>


</html>

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
            }else  if($_GET["error"]=="wronginput"){
                $errorMSG = "Altes Passwort stimmt nicht!";
                echo "<p>$errorMSG</p>";
            }
        }
    ?>