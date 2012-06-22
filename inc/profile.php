<?php
require("db.php");
if (!$CURUSER) header('Location: index.php');

function showUpdateProfile() {
	$user = mysql_real_escape_string($_COOKIE['user']);
	$tmp = mysql_fetch_assoc(mysql_query("SELECT * FROM user WHERE id = '$user'"));
	print("<table><tr><th>Full Name</th><th>Date of Birth</th><th>City</th><th>Position</th><th>Phone</th></tr>
	<tr><td><input type='text' name='full_name' size='14' value='$tmp[full_name]'></td> <td><input type='text' name='dob' size='8' value='$tmp[dob]'></td> <td><input type='text' name='city' size='10' value='$tmp[city]'></td> <td><input type='text' name='position' size='15' value='$tmp[position]'></td> <td><input type='text' name='phone' size='11' value='$tmp[phone]'></td> </tr><tr><td colspan='7'><center><button class='btn' onclick='saveProfile();'>Save</button></center></td></tr></table>");
	
}


function saveProfile() {
	$user = mysql_real_escape_string($_COOKIE['user']);
	foreach($_POST as $k => $v)
		$$k = mysql_real_escape_string($v);
	mysql_query("UPDATE user SET dob = '$dob', full_name = '$full_name', position = '$position', phone = '$phone', city = '$city' WHERE id = '$user'") or die(mysql_error());
	print("Profile has been saved");
}

function showUpdatePassword() {
	print("<table><tr><td>Old Password</td><td><input type='password' name='oldpass' size='15'></td><td>New Password</td><td><input type='password' name='newpass' size='15'></td><td><button class='btn' onclick='changePwd();'>Change</button></td></table>");
}

function changePwd() {
	$user = mysql_real_escape_string($_COOKIE['user']);
	foreach($_POST as $k => $v)
		$$k = mysql_real_escape_string($v);
	$tmp = mysql_fetch_assoc(mysql_query("SELECT email, password FROM user WHERE id = '$user'"));
	$oldp = md5(md5($tmp[email]).md5($oldpass));
	$newp = md5(md5($tmp[email]).md5($newpass));
	if ($oldp = $tmp[password]) {
			mysql_query("UPDATE user SET password = '$newp' WHERE id = '$user'") or die(mysql_error());
		print("Password has been changed");
	}	else
		print("Incorrect password entered");
}

if (!empty($_GET['do'])) call_user_func($_GET['do']);
?>