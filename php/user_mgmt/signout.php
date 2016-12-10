<?php
ob_start();
session_start();

require('../static_vars/vars.php');

unset($_SESSION["user_id"]);
unset($_SESSION["email"]);
unset($_SESSION["phone_number"]);

$path = "/411/";
header("Location: ".$path);

ob_end_flush(); //now the headers are sent

mysqli_close($con);

?>