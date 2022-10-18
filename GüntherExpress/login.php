<?php
include_once 'header.php';
?>

<?php
if (isset($_POST['login_button'])) {
    // print_r($_POST);
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
        'secret' => "6Lcmco8iAAAAANGTI5fDqsmRWZhQrV5gBtHJMMvK",
        'response' => $_POST['token'],
        // 'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );


    $context  = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    $res = json_decode($response, true);
    if ($res['success'] == true) {
        // Perform you logic here for ex:- save you data to database
        echo '<div class="alert alert-success">
			  		<strong>Success!</strong> Your inquiry successfully submitted.
		 		  </div>';
    } else {
        echo '<div class="alert alert-warning">
					  <strong>Error!</strong> You are not a human.
				  </div>';
    }
}

?>

<html>

<head>
    <script src="https://www.google.com/recaptcha/api.js?render=6Lcmco8iAAAAAHr24hEwYoWG5PNRRFNWsgzT_TzR"></script>
    <script>
        function onSubmit(token) {
            document.getElementById("login_form").submit();
        }
    </script>
</head>

</html>

<section>
    <h2>Log-In</h2>
    <form action="#" method="post" id="login_form">
        <input type="text" name="username" id="email/username" placeholder="E-mail/Benutzername" required><br>
        <input type="password" name="password" id="password" placeholder="Passwort" required><br>

        <button type="submit" value="Post" name="login_button" class="btn btn-success btn-block">Log In</button><br>

        <input type="hidden" id="token" name="token">

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

<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6Lcmco8iAAAAAHr24hEwYoWG5PNRRFNWsgzT_TzR').then(function(token) {
            // console.log(token);
            document.getElementById("token").value = token;
        });
    });
</script>

<?php
include_once 'footer.php';
?>
