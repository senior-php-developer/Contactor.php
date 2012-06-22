<?php
require("inc/db.php");
if (empty($_GET['mod']) or !$CURUSER) $_GET['mod'] = 'home';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/default.css">
<link rel="favicon" type="image/x-icon" href="css/i/favicon.ico">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/default.js"></script>
<title>Contactor 2.0 (BETA)</title>
</head>
<body>
	<div id="header">
		<div class="canvas">
			<img src="img/logo4.png">
		</div>
	</div>
	<div id="wrap">
	<? 
		if ($CURUSER['class'] == 1) $admin = '<div class="nav-tab" onclick="loadMod(\'admin\');">Admin</div>'; else $admin = '';
		if (!$CURUSER) print('<div id="nav"></div>');
		else print('<div id="nav"><div id="nav-list" class="clr"><div class="nav-tab" onclick="loadMod(\'home\');">Home</div><div class="nav-tab" onclick="loadMod(\'database\');">Database</div><div class="nav-tab" onclick="doLogout();">Logout</div></div></div>');
		include("tpl/".$_GET['mod'].".php"); 
	?>
	</div>
	<div id="footer">
		<div class="canvas">
			Copyright &copy Contactor.org.uk 2010<br>
			Designed and developed as part of Napier Group Project<br>
			<a href="tpl/terms.php">Terms & Conditions</a> | <a href="index.php?mod=database">Contacts Database</a> | <a href="index.php?mod=social">User Profile</a>
		</div>
	</div>
</body>
<!--[if IE]><link rel="stylesheet" type="text/css" href="css/ie.css"><![endif]-->
<!--[if lt IE 8]><link rel="stylesheet" type="text/css" href="css/ie7.css"><![endif]-->
<!-- alert message box -->
<div id="overlay"></div>
<div id="alert" class="brd5">
	<div class="title">Contactor 2.0</div>
	<div class="body">
		<div id="alert-msg"></div><br/>
		<center><button class="btn" onclick="$('#alert').fadeOut(function(){$('#overlay').hide();})">Close</button></center>
	</div>
</div>
<!-- ajax loader -->
<img id="loader" src="img/loader.gif">
<iframe class="hid" id="frame"></iframe>

</html>