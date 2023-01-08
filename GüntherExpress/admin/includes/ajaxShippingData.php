<?php
include_once 'admin_functions_inc.php';
include_once '../../includes/dbh_include.php';

global $conn;

echo json_encode(getShippingMethodDataAdmin($conn, $_POST["id"]));
exit();