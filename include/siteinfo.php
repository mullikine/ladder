<?php

@session_start();

$maintenance = false;

if (isset($_SERVER['HTTP_USER_AGENT'])) {
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'Windows') !== false) {
		$os = 'Win';
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) {
			$browser = 'Explorer';
		} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false) {
			$browser = 'Firefox';
		} else {
			// default
			$browser = 'Firefox';
		}
	} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Macintosh') !== false) {
		$os = 'Mac';
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false) {
			$browser = 'Firefox';
		} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false) {
			$browser = 'Safari';
		} else {
			// default
			$browser = 'Safari';
		}
	}
} else {
	// default values
	$os = 'Mac';
	$browser = 'Firefox';
}

include_once('connect_db.php');
include_once('accessors.php');

?>
