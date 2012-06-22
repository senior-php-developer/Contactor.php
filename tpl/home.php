<link rel="stylesheet" type="text/css" href="css/home.css">
<script type="text/javascript" src="js/home.js"></script>
<script type="text/javascript" src="js/login.js"></script>

<? if (!$CURUSER) { // content for not authorized users ?>
<div id="content" class="canvas">
	<div id="login-box" class="brd10">
		<span class="title">Welcome to Contactor!</span><br/><br/>
		<input type='text' name='user' value="E-mail"><br/><br/>
		<input type='text' id='pass' value="Password">
		<input type='password' id='real-pass' name='pass'><br/><br/>
		<button class="btn3" onclick="doLogin()">Login</button> <a href="javascript:;" id="forgot">Forgot password?</a>
	</div>
</div>
<? } else { // content for logged in users ?>
<div id="content" class="canvas"><div class="welcome"><h2>Welcome to Contactor website!</h2><br><p>You are welcomed to the site to use this great application for managing your contacts in one place. To start, select the Database menu item above and start adding desired contacts to the application.</p><p>If you want to update information on Twitter or get the latest tweets from your timeline - go to the Social section, where you can set up your Twitter account and start immediately.</p><p>You can always change your profile information or password under Profile section.</p><p>To get used to using this application, watch tutorial videos under Tutorial section.</p></div></div>
<? } ?>
