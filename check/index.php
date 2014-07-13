<?php
$settings = parse_ini_file('settings.ini');
if(!empty($_SERVER['QUERY_STRING'])) {
	$QUERY_STRING = '&'.$_SERVER['QUERY_STRING'];
} else {
	$QUERY_STRING = '';
}

// Display online users
include('dependencies/api.php');