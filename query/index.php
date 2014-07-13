<?php
$version = '2.8-BA-API';
//Minecraft User list - Based off of xPaw's (Pavel's) Minecraft server status

	$settings = parse_ini_file('settings.ini');
	if(!empty($_SERVER['QUERY_STRING']))
	{
		$QUERY_STRING = '&'.$_SERVER['QUERY_STRING'];
	}
	else
	{
		$QUERY_STRING = '';
	}
	
//echo doctype and headers
echo '
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular&subset=Latin,Cyrillic">
<title>Who Is Online</title>
</head>
<body>
';
include('dependencies/api.php');
echo '
<script src="http://terminus-gaming.com/minecraft/wp-content/themes/minecraft/js/iframeResizer.contentWindow.min.js?ver=2.5.1"></script>
</body>

</html>
';
?>
