<?php

// Sanitize any incoming input
function incomingSanitize($con, $str) {
	return mysqli_real_escape_string($con, trim($str));
}

// Check if the string is length 0
function isEmpty($str) {
	if ($str == "") {
		return true;
	} else if ( strlen($str) == 0) {
		return true;
	} else {
		return false;
	}
}

?>