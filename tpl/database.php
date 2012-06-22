<link rel="stylesheet" type="text/css" href="css/database.css">
<script type="text/javascript" src="js/tablesorter.js"></script>
<script type="text/javascript" src="js/pager.js"></script>
<script type="text/javascript" src="js/database.js"></script>
<div id="content" class="canvas">
<div id="sub-nav" class="clr2">
	<div class="toggle brd5" gid="Search">Search</div> <div class="toggle brd5" gid="AddContact">Add Contact</div>
</div><br/>
<div id="operations">
	
</div><br/>
<div id="contacts" class="brd10">
<div id="pager" class="pager">
	<form>
		<img src="img/first.png" class="first"/>
		<img src="img/prev.png" class="prev"/>
		<input type="text" class="pagedisplay"/>
		<img src="img/next.png" class="next"/>
		<img src="img/last.png" class="last"/>
		<select class="pagesize">
			<option selected="selected" value="15">15</option>
			<option value="30">30</option>
			<option value="60">60</option>
			<option  value="100">100</option>
		</select>
	</form>
</div>

	<div id="contact-table"></div><br/>
	<a href="javascript:;" onclick="checkBoxes();">Check All</a> | <a href="javascript:;" onclick="uncheckBoxes();">Uncheck All</a> | <a href="javascript:;" onclick="changeBoxes();">Change Selection</a> 
	<button class="btn">Share</button> <button onclick="export();" class="btn">Export</button><select id="format"><option value='pdf'>PDF</option><option value='csv'>CSV</option></select>  <button onclick="showSendMail();" class="btn">Send E-mail</button>
</div>
<br/><br/>
<div id="details" class="clr">
	<div id="information" class="brd10">
		<div class="error">Select record from the table above by clicking on it.</div>
	</div>
	<div id="map" class="brd10">
		<img class="map-logo" src="img/gmaps.gif">
	</div>
</div><br/>
</div>

<div class="hid clr" id="sendMail"><h3>Text to send:</h3><textarea id="text"></textarea><button class='btn rt' onclick='sendMail();'>Send</button></div>
