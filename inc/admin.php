<?php
require("db.php");
if ($CURUSER['class'] != 1) die;

function showAddUser() {
	global $CURUSER;
	print('<table><tr><td>User E-mail:</td><td><input type="text" size="30" name="email"></td></tr>
							<tr><td>Notes:</td><td><textarea name="notes" cols="50" rows="4"></textarea></td></tr>
							<tr><td>Your Name:</td><td><input type="text" size="30" name="admin" value="'.$CURUSER[full_name].'"></td></tr>
							<tr><td>You Email:</td><td><input type="text" size="30" name="admin_email" value="'.$CURUSER[email].'"></td></tr>
							<tr><td>Message:</td><td><textarea name="msg" cols="50" rows="3">Hello, the account for you has been created at <a href=\'http://contactor.org.uk\'>Contactor</a></textarea></td></tr>
							<tr><td>Rights:</td><td><input type="radio" name="class" value="1">Administrator <input type="radio" name="class" value="2" checked="checked">User <button class="btn rt" onclick="doAddUser();">Create</button></td></tr></table>
');
}

function doAddUser() {
	foreach($_POST as $k => $v)
		$$k = mysql_real_escape_string($v);
	$password = generator();
	$pass = md5(md5($email).md5($password));
	mysql_query("INSERT INTO user (email, password, notes) VALUES('$email', '$pass','$notes')");
  $subject = "Contactor Registration";
  $headers = "From: $admin_email\r\n"."MIME-Version: 1.0\r\n"."Content-type: text/html; charset=iso-8859-1\r\n";
  $body = "$msg <br/>Your registered email is $email and temporary password is $password. You can change it in the profile section.<br/>$admin";
  if (mail($email,$subject,$body,$headers))
		print("User has been added");
}

function showUsers() {
	$res = mysql_query("SELECT * FROM user ORDER BY id ASC");
	if ($tmp['class']=='1') $class = 'Administrator'; else $class = 'User';
	print("<table id='userlist-table'><thead><tr><th>ID</th><th>E-mail</th><th>Username</th><th>Full name</th><th>Class</th><th>City</th><th>&nbsp;</th></tr></thead><tbody>");
	while ($tmp = mysql_fetch_assoc($res)) {
		print("<tr><td>$tmp[id]</td><td>$tmp[email]</td><td>$tmp[username]</td><td>$tmp[full_name]</td><td>$class</td><td>$tmp[city]</td><td width='37'><div class='cont-btns'><img title='edit user' src='img/edit.png' onclick='editUser(\"$tmp[id]\");'> <img title='delete user' src='img/delete.png' onclick='delUser(\"$tmp[id]\");'></div></td></tr>");
	}
	print("</tbody></table>");
}

function delUser() {
	$id = mysql_real_escape_string($_POST[id]);
	mysql_query("DELETE FROM user WHERE id = '$id'") or die(mysql_error());
	print("User has been deleted");
	
}

function editUser() {
	$id = mysql_real_escape_string($_POST[id]);
	$tmp = mysql_fetch_assoc(mysql_query("SELECT * FROM user WHERE id = '$id'"));
	print("<table><tr><td>Username:</td><td><input type='text' size='30' name='username' value='$tmp[username]'></td></tr>
				<tr><td>Full name:</td><td><input type='text' size='30' name='full_name' value='$tmp[full_name]'></td></tr>
				<tr><td>City:</td><td><input type='text' size='30' name='city' value='$tmp[city]'></td></tr>
				
							<tr><td>Notes:</td><td><textarea name='notes' cols='50' rows='4'>$tmp[notes]</textarea></td></tr>
							<tr><td>Rights:</td><td><input type='radio' name='class' value='1'>Administrator <input type='radio' name='class' value='2' checked='checked'>User <button class='btn rt' onclick='doEditUser(\"$id\");'>Save</button></td></tr> </table>");
}

function doEditUser() {
	foreach($_POST as $k=>$v)
		$$k = mysql_real_escape_string($v);
	mysql_query("UPDATE user SET username = '$username', full_name = '$full_name', notes = '$notes', city = '$city' WHERE id = '$id'") or die(mysql_error());
	print("User has been edited");
}

if (!empty($_GET['do'])) call_user_func($_GET['do']);
?>