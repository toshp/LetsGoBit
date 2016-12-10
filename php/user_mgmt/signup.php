<?php
ob_start();
session_start();

require('../static_vars/vars.php');
require('authenticate.php');
require('../string_mgmt/str_process.php');

// Sanitize
$phone_number = incomingSanitize($con, $_POST['phone']);
$email = incomingSanitize($con, $_POST['email']);
$password = incomingSanitize($con, $_POST['password']);

if (isEmpty($phone_number) || isEmpty($email) || isEmpty($password)) {
    echo "Error: empty values";
    $path = "/411/";

    header("Location: ".$path);
    ob_end_flush();
    exit();
}

$phone_number = processPhone($phone_number);

if (!$phone_number) {
    echo "Error: invalid phone";
    $path = "/411/?msg=invalid_phone";
    
    header("Location: ".$path);
    ob_end_flush();
    exit();
}

$password = hash($hash, $password);

function addNewUser($con, $first, $last, $email, $phone, $password, $external_id) {
    // Build
    $sql = "INSERT INTO users (email, phone_number, password)
            VALUES ('$email', $phone, '$password')";

    // Execute
    mysqli_query($con, $sql);
}

addNewUser($con, $first_name, $last_name, $email, $phone_number, $password, $external_id);

$user = verifyUser($con, $email, $password);

if ( !$user ) {
    echo "Error creating account.";
    $path = "/411/?msg=error_creating_acct";

    header("Location: ".$path);
} else {

    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['phone_number'] = $user['phone_number'];

    $path = "/411/";

    header("Location: ".$path);
}


function processPhone($phone) {
    // First get rid of plus, parens, and dashes
    $phone = str_replace("+", "", $phone);
    $phone = str_replace("-", "", $phone);
    $phone = str_replace("(", "", $phone);
    $phone = str_replace(")", "", $phone);

    if (strlen($phone) < 10) {
        // Cannot be a valid number
        return false;
    } else if (strlen($phone) == 10) {
        return "1".$phone;
    } else if (strlen($phone) == 11) {
        // Ok may be just that the country code was 
        // already added
        $loc = strpos($phone, "1");
        if ($loc == 0) {
            // Ok the country code is already in
            return $phone;
        }
    }

    return false;
}

ob_end_flush();

?>
