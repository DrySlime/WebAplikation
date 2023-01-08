<?php
session_start();
echo $_SESSION["fullPrice"];
session_write_close();
exit();