









<?php	
//class which interacts with facebook API
require_once( './my_twitter.php' );

// getting user name from form
$user = $_POST['name'];
$pass = $_POST['pass'];




// setting new twitter obj
$twitter =  new MyTwitter($user, $pass);



$status = $twitter->directMessages();

$total = count($status);

// display the feeds
	
for ( $i=0; $i < $total ; $i++ )
		{ 
		
		echo "<p>". $status[$i]['text'] ."</p>";
		
		}
		

?>































