<?php
session_start();

echo $_POST["delivery"];
echo "/";
echo $_POST["price"];
echo "/";
echo $_SESSION["fullPrice"];
session_write_close();
exit();