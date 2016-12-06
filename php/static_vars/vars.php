<?php

date_default_timezone_set('America/New_York');

$con = mysqli_connect("localhost", "root", "root", "letsgobit");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>