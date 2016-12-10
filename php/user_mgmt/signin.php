<?php
ob_start();
session_start();

require('../static_vars/vars.php');
require('authenticate.php');
require('../string_mgmt/str_process.php');
 
// Sanitize
$email = incomingSanitize($con, $_POST['email']); 
$password = hash($hash, incomingSanitize($con, $_POST['password']) );

$user = verifyUser($con, $email, $password);

if ( !$user ) {
    echo "false";
    $path = "/411/?msg=failed";

    header("Location: ".$path);

} else {
    $path = "/411/";
    header("Location: ".$path);
	
	$_SESSION['user_id'] = $user['user_id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['phone_number'] = $user['phone_number'];
}

ob_end_flush(); //now the headers are sent

mysqli_close($con);

?>