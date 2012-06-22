<?php
require("db.php");

function doLogin() {
	$email = mysql_real_escape_string($_POST[user]);
  $pass = mysql_real_escape_string($_POST[pass]);
  $password = md5(md5($email).md5($pass));
  $res = mysql_query("SELECT id, class FROM user WHERE email = '$email' OR username = '$email' AND password = '$password' LIMIT 1");  
  if (mysql_num_rows($res) > 0) {
  	$tmp = mysql_fetch_assoc($res);
    setcookie("user", $tmp[id], 0x7fffffff, "/");
    setcookie("pass", $password, 0x7fffffff, "/");
    setcookie("class",$tmp['class'], 0x7fffffff, "/");
    print("LOGIN_OK");
  } else 
			print("Username or Password is incorrect. ");
}

function doLogout() {
	setcookie("user", "", 0x7fffffff, "/");
  setcookie("pass", "", 0x7fffffff, "/");
  setcookie("class","", 0x7fffffff, "/");
}

if (!empty($_GET['do'])) call_user_func($_GET['do']);
?>