<?php
include_once 'header.php';
?>

<section>
    <h2>Log-In</h2>
    <form action="includes/login_include.php" method="post" id="login_form">
        <input type="text" name="username" id="email/username" placeholder="E-mail/Benutzername" required><br>
        <input type="password" name="password" id="password" placeholder="Passwort" required><br>

        <div class="recaptcha-holder"></div>

        <button type="submit" name="login_button" onclick="return check_form()">Log In</button><br>
    </form>

</section>
<?php
$errorMSG;
if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
        $errorMSG = "Manche Felder sind leer!";
        echo "<p>$errorMSG</p>";
    } else  if ($_GET["error"] == "wronginput") {
        $errorMSG = "Username/Email und oder Passwort falsch!";
        echo "<p>$errorMSG</p>";
    }
}
?>


<?php
include_once 'footer.php';
?>

<script type="text/javascript">
    var renderGoogleInvisibleRecaptcha = function() {
        var form = document.forms[i];
        var holder = form.querySelector('.recaptcha-holder');
        if (null === holder) {
            continue;
        }

        (function(frm) {

            var holderId = grecaptcha.render(holder, {
                'sitekey': '6Le4uYwiAAAAAMMmF6x_tZnrXtVenZngSYOalfKB',
                'size': 'invisible',
                'badge': 'bottomright', // possible values: bottomright, bottomleft, inline
                'callback': function(recaptchaToken) {
                    HTMLFormElement.prototype.submit.call(frm);
                }
            });

            frm.onsubmit = function(evt) {
                evt.preventDefault();
                grecaptcha.execute(holderId);
            };

        })(form);
    };
</script>

<script src="https://www.google.com/recaptcha/api.js?onload=renderGoogleInvisibleRecaptcha&render=explicit" async defer></script>