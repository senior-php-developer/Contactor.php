<?php if ($CURUSER['class'] != 1) die; ?>
<link rel="stylesheet" type="text/css" href="css/admin.css">
<script type="text/javascript" src="js/tablesorter.js"></script>
<script type="text/javascript" src="js/pager.js"></script>
<script type="text/javascript" src="js/admin.js"></script>
<div id="content" class="canvas">
	<div id="sub-nav" class="clr2"><div class="toggle brd5" gid="AddUser">Add User</div></div><br/>
<div id="operations"></div><br/>
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
</div><br/>
<div id="user-list"></div><br/>
</div>