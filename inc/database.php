<?php
require("db.php");
if (!$GLOBALS['CURUSER']) header('Location: index.php');

function showSearch() {
	$group = "<select name='group_id'><option value=''></option>";
	$res = mysql_query("SELECT id, name FROM `group` ORDER BY name ASC");
	while ($tmp = mysql_fetch_assoc($res)) {
		$group .= "<option value='$tmp[id]'>$tmp[name]</option>";
	}
	$group .= "</option>";
	
	$type = "<select name='type'>";
	$res = mysql_query("SELECT DISTINCT type FROM contact ORDER BY type ASC");
	while ($tmp = mysql_fetch_assoc($res)) {
		$type .= "<option value='$tmp[type]'>$tmp[type]</option>";
	}
	$type .= "</option>";
	
	$subject = "<select name='subject'>";
	$res = mysql_query("SELECT DISTINCT subject FROM contact ORDER BY subject ASC");
	while ($tmp = mysql_fetch_assoc($res)) {
		$subject .= "<option value='$tmp[subject]'>$tmp[subject]</option>";
	}
	$subject .= "</option>";
	
	$position = "<select name='position'>";
	$res = mysql_query("SELECT DISTINCT position FROM contact ORDER BY position ASC");
	while ($tmp = mysql_fetch_assoc($res)) {
		$position .= "<option value='$tmp[position]'>$tmp[position]</option>";
	}
	$position .= "</option>";
	
	print("<table><tr><th>Group</th><th>Type</th><th>Subject</th><th>Position</th></tr>
	<tr><td>$group</td><td>$type</td><td>$subject</td><td>$position</td><td><a href='javascript:;' onclick=''>more..</a></td></tr> <tr><td colspan='6'><input type='text' class='search' name='str'> <button class='btn' onclick='doSearch();'>Search</button></td></tr></table>");
}

function showAddContact() {
	$group = "<select style='width: 100%' name='group'>";
	$res = mysql_query("SELECT id, name FROM `group` ORDER BY name");
	while ($tmp = mysql_fetch_assoc($res)) {
		$group .= "<option value='$tmp[id]'>$tmp[name]</option>";
	}
	$group .= "</select>";
	$title = "<select style='font-size: 12px;' name='title'><option value='Mr'>Mr</option><option value='Mrs'>Mrs</option><option value='Ms'>Ms</option><option value='Miss'>Miss</option><option value='Dr'>Dr</option><option value='Lord'>Lord</option></select>";
	
	print("<div class='clr'><table>
	<tr><th>Group</th><th>Type</th><th>Sub-Type</th><th>Subject</th></tr>
	<tr><td>$group</td><td><input type='text' name='type' class='inp'></td><td><input type='text' name='sub_type' class='inp'></td><td><input type='text' name='subject' class='inp'></td>
	<tr><th>First Name</th><th>Last Name</th><th>Organization</th><th>Position</th></tr>
	<td>$title <input type='text' name='first_name' style='width: 100px;'></td><td><input type='text' name='last_name' class='inp'></td><td><input type='text' name='organization' class='inp'></td><td><input type='text' name='position' class='inp'></td></tr>
	<tr><th>Phone (mobile)</th><th>Email (work)</th><th>Email (personal)</th><th>Web Page</th></tr>
	<tr><td><input type='text' name='phone' class='inp'></td><td><input type='text' name='email_work' class='inp'></td><td><input type='text' name='email_per' class='inp'></td><td><input type='text' name='web' class='inp'></td></tr>			 
	</table>");
	print("<br/><div id='addr-input'><h4>Address #1</h4>
	<table><tr><th colspan='2'>Address Details</th><th>City</th><th>Postal Code</th></tr>
	<tr><td colspan='2'><input type='text' style='width: 330px;' name='addr1'></td><td><input type='text' class='inp' name='city1'></td><td><input type='text' class='inp' name='postcode1'></td></tr>
	<tr><th>County</th><th>Region</th><th>Phone</th><th>Fax</th></tr><tr><td><input type='text' class='inp' name='county1'></td><td><input type='text' class='inp' name='region1'></td><td><input type='text' class='inp' name='phone1'></td><td><input type='text' class='inp' name='fax1'></td></tr></table></div>");
	print("<a href='javascript:;' onclick='addAddress();'>Add address</a><br/>");
	print("<button class='btn rt' onclick='addContact();'>Add contact</button></div>");
}

function addContact() {
	foreach ($_POST as $k => $v) 
		$$k = mysql_real_escape_string($v);
	$date = date("Y-m-d H:i:s");
	$code = generator();
	mysql_query("INSERT INTO contact VALUES(null, '$group', '$date', '$type', '$sub_type', '$subject', '$title', '$first_name', '$last_name', '$position', '$organization', '$phone', '$email_work', '$email_per', '$web', '$code', '')");
	$id = mysql_insert_id();
	for ($i = 1; $i<$count+1; $i++) {
		mysql_query("INSERT INTO address VALUES(null, '$id', '0', '${addr.$i}', '${phone.$i}', '${fax.$i}', '${city.$i}', '${postcode.$i}', '${county.$i}', '${region.$i}')");
	}
	$user = $_REQUEST['user'];
	mysql_query("INSERT INTO access VALUES(null, '$user', '$id', '2')");
	print("Contact added successfully");	
}

function saveContact() {
	foreach($_POST as $k => $v)
		$$k = mysql_real_escape_string($v);
	$date = date("Y-m-d H:i:s");
	mysql_query("UPDATE contact SET `group_id` = '$group', `updated` = '$date', `type` = '$type', sub_type = '$sub_type', subject = '$subject', title = '$title', first_name = '$first_name', last_name = '$last_name', position = '$position', organization = '$organization', phone_mobile = '$phone', email_work = '$email_work', email_pers = '$email_per', web = '$web' WHERE id = '$cont_id'") or die(mysql_error());
	for ($i = 1; $i<$count+1; $i++) {
		if (!empty(${addr_id.$i})) 
			mysql_query("UPDATE address SET address = '${addr.$i}', phone = '${phone.$i}', fax = '${fax.$i}', postcode = '${postcode.$i}', city = '${city.$i}', county = '${county.$i}', region = '${region.$i}' WHERE id = '${addr_id.$i}'");
		else
			mysql_query("INSERT INTO address VALUES(null, '$cont_id', '0', '${addr.$i}', '${phone.$i}', '${fax.$i}', '${city.$i}', '${postcode.$i}', '${county.$i}', '${region.$i}')");
	}
	print("Contact changes have been saved");
}

function editContact() {
	$id = mysql_real_escape_string($_POST['id']);
	$tmp = mysql_fetch_assoc(mysql_query("SELECT * FROM contact WHERE id = '$id'"));
	$group = "<select style='width: 100%' name='group'>";
	$res = mysql_query("SELECT id, name FROM `group` ORDER BY name");
	while ($tmp2 = mysql_fetch_assoc($res)) {
		if ($tmp2[id] == $tmp[group_id]) $cur = "selected = 'selected'"; else $cur = "";
		$group .= "<option $cur value='$tmp2[id]'>$tmp2[name]</option>";
	}
	$group .= "</select>";
	$title = "<select style='font-size: 12px;' name='title'><option value='Mr'>Mr</option><option value='Mrs'>Mrs</option><option value='Ms'>Ms</option><option value='Miss'>Miss</option><option value='Dr'>Dr</option><option value='Lord'>Lord</option></select>";
	print("<div class='clr'><table>
	<tr><th>Group</th><th>Type</th><th>Sub-Type</th><th>Subject</th></tr>
	<tr><td>$group</td><td><input type='text' name='type' class='inp' value='$tmp[type]'></td><td><input type='text' name='sub_type' class='inp' value='$tmp[sub_type]'></td><td><input type='text' name='subject' class='inp' value='$tmp[subject]'></td>
	<tr><th>First Name</th><th>Last Name</th><th>Organization</th><th>Position</th></tr>
	<td>$title <input type='text' name='first_name' style='width: 100px;' value='$tmp[first_name]'></td></td><td><input type='text' name='last_name' class='inp' value='$tmp[last_name]'></td><td><input type='text' name='organization' class='inp' value='$tmp[organization]'></td><td><input type='text' name='position' class='inp' value='$tmp[position]'></td></tr>
	<tr><th>Phone (mobile)</th><th>Email (work)</th><th>Email (personal)</th><th>Web Page</th></tr>
	<tr><td><input type='text' name='phone' class='inp' value='$tmp[phone_mobile]'></td><td><input type='text' name='email_work' class='inp' value='$tmp[email_work]'></td><td><input type='text' name='email_per' class='inp' value='$tmp[email_pers]'></td><td><input type='text' name='web' class='inp' value='$tmp[web]'></td></tr></table>");
	$res2 = mysql_query("SELECT * FROM address WHERE contact_id = '$id'");
	print("<div id='addr-input'>");
	$i = 0;
	while ($tmp2 = mysql_fetch_assoc($res2)) {
		$i++;
		print("<br/><h4>Address #$i</h4>
	<input type='hidden' name='addr_id$i' value='$tmp2[id]'>
	<table><tr><th colspan='2'>Address Details</th><th>City</th><th>Postal Code</th></tr>
	<tr><td colspan='2'><input type='text' style='width: 330px;' name='addr$i' value='$tmp2[address]'></td><td><input type='text' class='inp' name='city$i' value='$tmp2[city]'></td><td><input type='text' class='inp' name='postcode$i' value='$tmp2[postcode]'></td></tr>
	<tr><th>County</th><th>Region</th><th>Phone</th><th>Fax</th></tr> <tr><td><input type='text' class='inp' name='county$i' value='$tmp2[county]'></td><td><input type='text' class='inp' name='region$i' value='$tmp2[region]'></td> <td><input type='text' class='inp' name='phone$i' value='$tmp2[phone]'></td><td><input type='text' class='inp' name='fax$i' value='$tmp2[fax]'></td></tr></table>");
	}
	print("</div><input type='hidden' id='addr-count' value='$i'>");
	print("<a href='javascript:;' onclick='addAddress();'>Add address</a><br/>");
	print("<button class='btn rt' onclick='saveContact(\"$tmp[id]\");'>Save contact</button></div>");
}

function delContact() {
	$con = mysql_real_escape_string($_POST[id]);
	$user = mysql_real_escape_string($_COOKIE[user]);
	$res = mysql_query("SELECT id FROM access WHERE contact_id = '$con' AND user_id = '$user'");
	if (mysql_num_rows($res) > 0) {
		mysql_query("DELETE FROM access WHERE contact_id = '$con'");
		mysql_query("DELETE FROM contact WHERE id = '$con'");
		mysql_query("DELETE FROM address WHERE contact_id = '$con'");
	}
	print("Contact has been deleted");
}

function showContacts() {
	$user = $_COOKIE[user];
	$res = mysql_query("SELECT c.id, g.name as grp, c.type, c.sub_type, c.subject, c.first_name, c.last_name, c.organization, c.position FROM contact c, `group` g, access a WHERE a.user_id = '$user' AND a.contact_id = c.id AND g.id = c.group_id ORDER BY id ASC");
	print("<table><thead><tr class='head-row'><th>&nbsp;</th><th>Group</th><th>Type</th><th>Subject</th><th>Full Name</th><th>Organization</th><th>Position</th><th>&nbsp;</th><th>&nbsp;</th></tr></thead><tbody>");
	while ($tmp = mysql_fetch_assoc($res)) {
		print("<tr gid='$tmp[id]' onclick='loadContact(\"$tmp[id]\")'><td><input type='checkbox' checked='checked'></td><td>$tmp[grp]</td><td>$tmp[type]</td><td>$tmp[subject]</td><td>$tmp[first_name] $tmp[last_name]</td><td>$tmp[organization]</td> <td>$tmp[position]</td><td><div class='cont-btns'><img title='edit contact' src='img/edit.png' onclick='editContact(\"$tmp[id]\");'> </div></td><td><div class='cont-btns'> <img title='delete contact' src='img/delete.png' onclick='delContact(\"$tmp[id]\");'></div></td></tr>");
	}
	print("</tbody></table>");
}

function loadContact() {
	$id = mysql_real_escape_string($_REQUEST[id]);
	$user = mysql_real_escape_string($_COOKIE[user]);
	$res = mysql_query("SELECT c.*, g.name as grp FROM contact c, `access` a, `group` g WHERE a.user_id = '$user' AND a.contact_id = c.id AND c.id = '$id' AND c.group_id = g.id");
	if (mysql_num_rows($res) > 0) {
		$tmp = mysql_fetch_assoc($res);
		print("<div class='cont'><table><tr><td class='title'>Type</td><td style='min-width: 140px;'>$tmp[type]</td><td class='title'>Sub Type</td><td>$tmp[sub_type]</td></tr>
			<tr><td class='title'>Group</td><td>$tmp[grp]</td><td class='title'>Subject</td><td>$tmp[subject]</td></tr>
			<tr><td class='title'>Full Name</td><td colspan='3'>$tmp[title] $tmp[first_name] $tmp[last_name]</td></tr>
			<tr><td class='title'>Organization</td><td>$tmp[organization]</td><td class='title'>Position</td><td>$tmp[position]</td></tr>
			<tr><td class='title'>Phone (mobile)</td><td>$tmp[phone_mobile]</td></tr><tr><td class='title'>Web</td><td colspan='3'>$tmp[web]</td></tr> <tr><td class='title'>E-mail (work)</td><td colspan='3'>$tmp[email_work]</td></tr> <tr><td class='title'>E-mail (pers)</td><td colspan='3'>$tmp[email_pers]</td></tr></table></div>");
		$res = mysql_query("SELECT * FROM address WHERE contact_id = '$id'");
		print("<br/><b style='margin: 30px;'>Locations</b>");
		if (mysql_num_rows($res) > 0)
			print("<select id='addr-sel' onchange='loadAddress();'><option>Select location</option>");
		else
			print("&nbsp; No locations presented");
		$out = "";
		while ($tmp = mysql_fetch_assoc($res)) {
			$out .= "<div class='addr' gid='$tmp[id]'><table><tr><td class='title' width='90'>Address</td><td class='address' colspan='3' width='300'>$tmp[address]</td></tr> <tr><td class='title'>City</td><td class='city'>$tmp[city]</td><td class='title'>Postcode</td><td class='postcode'>$tmp[postcode]</td></tr> <td class='title'>County</td><td>$tmp[county]</td><td class='title'>Region</td><td>$tmp[region]</td></tr> <tr><td class='title'>Phone</td><td>$tmp[phone]</td><td class='title'>Fax</td><td>$tmp[fax]</td></tr></table></div>";
			print("<option value='$tmp[id]'>$tmp[postcode], $tmp[city]</option>");
		}
		print("</select>");
		print($out);
	} else {
		print("<div class='error'>You don't have access to this record</div>");
	}
}

function doSearch() {
	foreach ($_POST as $k => $v)
	 $$k = mysql_real_escape_string($v);
	$where = "WHERE (first_name LIKE '%$str%' OR last_name LIKE '%$str%' OR organization LIKE '%$str%')";
	
	if (!empty($group_id))
		$where .= " AND group_id = '$group_id'";
	if (!empty($type))
		$where .= " AND type = '$type'";
	if (!empty($subject))
		$where .= " AND subject = '$subject'";
	if (!empty($position))
		$where .= " AND position = '$position'";
	
	$res = mysql_query("SELECT id, (SELECT name FROM `group` WHERE id = group_id) as grp, `type`, sub_type, subject, first_name, last_name, organization, position FROM contact $where ORDER BY id ASC");
	print("<table><thead><tr class='head-row'><th>&nbsp;</th><th>Group</th><th>Type</th><th>Subject</th><th>Full Name</th><th>Organization</th><th>Position</th><th>&nbsp;</th><th>&nbsp;</th></tr></thead><tbody>");
	while ($tmp = mysql_fetch_assoc($res)) {
		print("<tr gid='$tmp[id]' onclick='loadContact(\"$tmp[id]\")'><td><input type='checkbox' checked='checked'></td><td>$tmp[grp]</td><td>$tmp[type]</td><td>$tmp[subject]</td><td>$tmp[first_name] $tmp[last_name]</td><td>$tmp[organization]</td> <td>$tmp[position]</td><td><div class='cont-btns'><img title='edit contact' src='img/edit.png' onclick='editContact(\"$tmp[id]\");'> </div></td><td><div class='cont-btns'> <img title='delete contact' src='img/delete.png' onclick='delContact(\"$tmp[id]\");'></div></td></tr>");
	}
	print("</tbody></table>");
}

if (!empty($_GET['do'])) call_user_func($_GET['do']);
?>