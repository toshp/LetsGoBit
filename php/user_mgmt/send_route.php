<?php
ob_start();
session_start();
session_regenerate_id();

require('../static_vars/vars.php');
require('../string_mgmt/str_process.php');

$user_id = false;
$email = false;
$phone = false;
$route = incomingSanitize($con, $_POST['route']);

if (isset($_SESSION['user_id']) && isset($_SESSION['phone_number'])) {
    $user_id = $_SESSION['user_id'];
    $phone = $_SESSION['phone_number'];

	$url = 'https://heybotler.com/listener/php/functions/send_sms.php?';
	$url .= 'from=18056783942&phone='. $phone. '&message='. urlencode($route);
	$result = file_get_contents($url);
}

ob_end_flush(); //now the headers are sent

?>