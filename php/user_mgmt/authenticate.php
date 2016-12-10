<?php

// Return a user exists matching email and password
function verifyUser($con, $email, $password) {
        
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password' ";
    $result = mysqli_query($con, $sql) or die(mysqli_error());

    $numrows = mysqli_num_rows($result);

    if ($numrows == 1) {
        return mysqli_fetch_array($result);
    } else {
        return false;
    }

}

?> 