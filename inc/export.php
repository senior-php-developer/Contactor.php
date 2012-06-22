<?php
require("db.php");
if (!$CURUSER) header('Location: index.php');

function csv() {
	header('Content-type: text/csv');
	header('Content-Disposition: attachment; filename="contacts.csv"');
	$in = "IN (";
	foreach($_GET['data'] as $k=>$v)
		$in .= "'$v',";
	$in .= ")";
	$in = str_replace(",)", ")", $in);
	$query = "SELECT * FROM contact WHERE id $in";
	$res = mysql_query($query);
	while ($tmp = mysql_fetch_assoc($res)) {
		foreach($tmp as $k => $v) 
			print($v.',');
		print(";\r\n");
	}		
}

function pdf() {
	$user = $_COOKIE[user];
	$in = "IN (";
	foreach($_GET['data'] as $k=>$v)
		$in .= "'$v',";
	$in .= ")";
	$in = str_replace(",)", ")", $in);
	$res = mysql_query("SELECT c.*, g.name as grp FROM contact c, `group` g WHERE g.id = c.group_id AND c.id $in");
	require('../plg/pdf/html2fpdf.php');
	$pdf=new HTML2FPDF();
	while ($tmp = mysql_fetch_assoc($res)) {
		$html = "<h3>$tmp[title] $tmp[first_name] $tmp[last_name]</h3>
		<table border='0' cellpadding='7'>
		<tr><td>Group</td><td>$tmp[grp]</td></tr>
		<tr><td>Type</td><td>$tmp[type]</td></tr>
		<tr><td>Sub Type</td><td>$tmp[sub_type]</td></tr>
		<tr><td>Subject</td><td>$tmp[subject]</td></tr>
		<tr><td>Position</td><td>$tmp[position]</td></tr>
		<tr><td>Organization</td><td>$tmp[organization]</td></tr>
		<tr><td>Phone (Mobile)</td><td>$tmp[phone_mobile]</td></tr>
		<tr><td>Email (Work)</td><td>$tmp[email_work]</td></tr>
		<tr><td>Email (Personal)</td><td>$tmp[email_pers]</td></tr>
		<tr><td>Web</td><td>$tmp[web]</td></tr>
		<tr><td>Extra Info</td><td>$tmp[extra_info]</td></tr></table>";
		$res2 = mysql_query("SELECT * FROM address WHERE contact_id = '$tmp[id]'");
		$i = 1;
		while ($a = mysql_fetch_assoc($res2)) {
			$html .= "<h4>Location #$i</h4>";
			$html .= "<table border='0' cellpadding='7'>
			<tr><td>Address</td><td>$a[address]</td></tr>
			<tr><td>City</td><td>$a[city]</td></tr>
			<tr><td>Postcode</td><td>$a[postcode]</td></tr>
			<tr><td>County</td><td>$a[county]</td></tr>
			<tr><td>Region</td><td>$a[region]</td></tr>
			<tr><td>Phone</td><td>$a[phone]</td></tr>
			<tr><td>Fax/td><td>$a[fax]</td></tr></table>";		
			$i++;	
		}
		$pdf->AddPage();
		$pdf->WriteHTML($html);
	}

	$pdf->Output("files/$user.pdf");
	header('Content-type: application/pdf');
	header("Content-Disposition: attachment; filename=Contacts.pdf");
	readfile("files/$user.pdf");
}

function sendMail() {
	$user = mysql_real_escape_string($_COOKIE[user]);
	$userinfo = mysql_fetch_assoc(mysql_query("SELECT * FROM user WHERE id = '$user'"));
	$rep = array();	
	$in = "IN (";
	foreach($_POST as $k=>$v) {
		if ($k == 'text') continue;
		$in .= "'$v',";
	}
	$in .= ")";
	$in = str_replace(",)", ")", $in);
	$res = mysql_query("SELECT email_work FROM contact WHERE id $in");
	while ($tmp = mysql_fetch_assoc($res)) {
		array_push($rep, $tmp[email_work]);
	}
	include "libmail.php";
	$m = new Mail();
	$m->From($userinfo[email]);
	$m->To($rep);
	$m->Subject("Contactor Email System");
	$m->Body($_POST[text]);
	$m->Priority(3);
	$m->Send();
	print("Mail was sent successfully");
}


if (!empty($_GET['do'])) call_user_func($_GET['do']);
?>