<?php

require "Twitter.class.php";

// getting user name from form
$user = $_POST['name'];
$pass = $_POST['pass'];

$tmessage = $_POST['tmessage'];






$tweet = new Twitter($user, $pass);

$success = $tweet->update($tmessage);
if ($success) echo "Tweet successful!";
else echo $tweet->error;

?>
