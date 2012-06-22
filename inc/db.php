<?php
mysql_connect('localhost','kolor_kolor','dbpass') or die(mysql_error());
mysql_select_db('kolor_contactor') or die(mysql_error());
$GLOBALS['CURUSER'] = array(
	'id' => $_COOKIE['id'],
	'class' => $_COOKIE['classw']
);
?>