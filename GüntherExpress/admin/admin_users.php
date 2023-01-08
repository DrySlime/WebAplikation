<?php
include_once "admin_header.php";
include_once "includes/admin_functions_inc.php";
include_once "../includes/dbh_include.php";
global $conn;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="CSS/admin_shared_assets.css">
    <link rel="stylesheet" href="CSS/admin_small_assets.css">
    <link rel="stylesheet" href="CSS/admin_users.css">
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title></title>
</head>
<body>
<div class="admin_dashboard_header_wrapper">
    <div class="admin_dashboard_header_container">
        <h1>Account Übersicht</h1>
        <h4>Hier werden alle Accounts auf The Confectioner aufgelistet!</h4>
    </div>
    <div class="admin_dashboard_header_image">
        <img src="../img/gummies.png" alt="">
    </div>
</div>
<div class="admin_dashboard_wrapper">
    <div class="admin_dashboard_container">
        <div class="admin_data_wrapper">
            <div class="admin_data_container">
                <h4>Nutzer Suchen</h4>
                <div class="admin_data_search">
                    <?php
                    $name = null;
                    $id = null;
                    $email = null;
                    if (isset($_POST["usernameSearch"])) {
                        $name = $_POST["usernameSearch"];
                    }
                    if (isset($_POST["uidSearch"])) {
                        $id = $_POST["uidSearch"];
                    }
                    if (isset($_POST["emailSearch"])) {
                        $email = $_POST["emailSearch"];
                    }
                    ?>
                    <form class="admin_data_search_form" id="searchUserForm" action="admin_users.php" method="post">
                        <label for="usernameSearch">Nutzername:</label><input type="text" id="usernameSearch" name="usernameSearch" value="<?php echo $name ?>" placeholder="Nutzername">
                        <label for="uidSearch">Nutzer ID:</label><input type="text" id="uidSearch" name="uidSearch" value="<?php echo $id ?>" placeholder="Nutzer ID">
                        <label for="emailSearch">Email:</label><input type="text" id="emailSearch" name="emailSearch" value="<?php echo $email ?>" placeholder="Email">
                    </form>
                    <div class="admin_data_search_buttons">
                        <button class="reset_searchUserForm" id="resetForm" formnovalidate>Zurücksetzen</button>
                        <button type="submit" form="searchUserForm">Suchen</button>
                    </div>
                </div>
                <div class="admin_data_table">
                    <?php
                    $userArray = getUserData($conn, $name, $id, $email);
                    ?>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Vorname</th>
                            <th>Nachname</th>
                            <th>Email</th>
                            <th>Nutzername</th>
                            <th>Straße</th>
                            <th>Hausnummer</th>
                            <th>Stadt</th>
                            <th>Postleitzahl</th>
                        </tr>
                        <?php
                        if ($userArray != null) {
                            for ($i = 0; $i < count($userArray); $i++) {
                                ?>
                                <tr>
                                    <td> <?php echo $userArray[$i]["id"] ?> </td>
                                    <td> <?php echo $userArray[$i]["firstname"] ?> </td>
                                    <td> <?php echo $userArray[$i]["lastname"] ?> </td>
                                    <td> <?php echo $userArray[$i]["email"] ?></td>
                                    <td> <?php echo $userArray[$i]["username"] ?> </td>
                                    <?php
                                    $address = getAdressFromUserID($conn, $userArray[$i]["id"]);
                                    if ($address != null) {
                                        ?>
                                        <td> <?php echo $address[0]["address_line"] ?> </td>
                                        <td> <?php echo $address[0]["street_number"] ?> </td>
                                        <td> <?php echo $address[0]["city"] ?> </td>
                                        <td> <?php echo $address[0]["postal_code"] ?> </td>
                                        <?php
                                    } else {
                                        ?>
                                        <td>-/-</td>
                                        <td>-/-</td>
                                        <td>-/-</td>
                                        <td>-/-</td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <td>-/-</td>
                            <td>-/-</td>
                            <td>-/-</td>
                            <td>-/-</td>
                            <td>-/-</td>
                            <td>-/-</td>
                            <td>-/-</td>
                            <td>-/-</td>
                            <td>-/-</td>
                            <?php
                        } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="JS/adminForms.js"></script>

</body>
</html>
<?php require_once "admin_footer.php" ?>

