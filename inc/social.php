<?php
require("db.php");
if (!$CURUSER) header('Location: index.php');

include("twitter.class.php");

function showTwits($tw) {
	$tw = new twitter();
	$tabs = "";
	$user = mysql_real_escape_string($_COOKIE['user']);
	$res = mysql_query("SELECT id, username, pass FROM twitter WHERE active = '1' AND userid = '$user'");
	while ($tmp = mysql_fetch_assoc($res)) {
		$tabs .= "<a href='javascript:;' onclick='openTwit(\"$tmp[id]\");' class='tab2 brd5'>$tmp[username]</a> ";
		print("<div class='twt-box' gid='$tmp[id]'>");
		$tw->username = $tmp['username'];
		$tw->password = base64_decode($tmp['pass']);
		$timeline = $tw->friendsTimeline();
		$style = "background: #{$timeline->status->user->profile_background_color}; border: 1px solid #{$timeline->status->user->profile_sidebar_border_color}; color: #{$timeline->status->user->profile_text_color};";	
		foreach($timeline->status as $k => $v) {
			print("<div class='tweet clr' style='$style'><div class='lt img'><img src='{$v->user->profile_image_url}'></div><div class='text rt'>{$v->text}</div></div>");
		}
		print("</div>");
	}
	print("<div id='tabs2'>$tabs</div>");
}

function showAddAccount() {
	print("Username: <input type='text' id='tw-user'> Password: <input type='password' id='tw-pass'> <button class='btn' onclick='addAccount();'>Add</button><br/>");
	print("<div class='acc-table'><table><tr><th>Username</th><th>Active</th><th>Options</th></tr>");
	$user = mysql_real_escape_string($_COOKIE[user]);
	$res = mysql_query("SELECT * FROM twitter WHERE userid = '$user'");
	while ($tmp = mysql_fetch_assoc($res)) {
		if ($tmp[active]) {
			$a = "<button class='btn' onclick='disable(\"$tmp[id]\");'>disable</button>";
			$b = "Yes";
		}  else {
			$a = "<button class='btn' onclick='enable(\"$tmp[id]\");'>enable</button>";
			$b = "No";
		}
		print("<tr><td>$tmp[username]</td><td>$b</td><td>$a <button class='btn' onclick='deleteAcc(\"$tmp[id]\");'>delete</button></td></tr>");
	}
	print("</table>");

}

function addAccount() {
	foreach($_POST as $k => $v)
		$$k = mysql_real_escape_string($v);
	$userid = mysql_real_escape_string($_COOKIE[user]);
	$password = base64_encode($pass);
	mysql_query("INSERT INTO twitter VALUES(null, '$userid', '$user', '$password', '1')") or die(mysql_error());
	print("Account has been added");
}

function showUpdateStatus() {
	print("<input type='text' size='66' length='140' id='twtstatus'> <button class='btn' onclick='updateStatus();'>Tweet</button>");
}

function updateStatus() {
	$tw = new twitter();
	$st = substr($_POST['st'], 0, 140);
	$res = mysql_query("SELECT id, username, pass FROM twitter WHERE active = '1'");
	while ($tmp = mysql_fetch_assoc($res)) {
		$tw->username = $tmp['username'];
		$tw->password = base64_decode($tmp['pass']);
		$tw->update($st);
	}
}

function disable() {
	$id = mysql_real_escape_string($_POST['id']);
	mysql_query("UPDATE twitter SET active = '0' WHERE id = '$id'");
}

function enable() {
	$id = mysql_real_escape_string($_POST['id']);
	mysql_query("UPDATE twitter SET active = '1' WHERE id = '$id'");
}


if (!empty($_GET['do'])) call_user_func($_GET['do']);
?>