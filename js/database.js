$(init);
addrNum = 1;

function init() {
	  initLinks();	
}

function initLinks() {
	$(".toggle").click(function(){
		if ($(this).hasClass("toggle-act")) {
			$(this).removeClass("toggle-act");
			$("#operations").slideUp();
		} else {
			$(".toggle").removeClass("toggle-act");
			$(this).addClass("toggle-act");
			var mod = $(this).attr("gid");
			$("#operations").load('inc/database.php?do=show'+mod,function(){
				$("#operations").slideDown();
				addrNum = 1;
			});
		}
	});
	redrawTable();
}

function redrawTable() {
	$("#contact-table").load('inc/database.php?do=showContacts',function(){ 
		$("#contact-table tr").hover(function(){
			$(this).find(".cont-btns").show();
		},function(){
			$(this).find(".cont-btns").hide();
		});
		$("#contact-table table").tablesorter({sortList: [[4,0]], widthFixed: true, widgets: ['zebra']}).tablesorterPager({container: $("#pager")});
	});
}

function addAddress() {
	addrNum++;
	$("#addr-input").append("<br/><h4>Address #"+addrNum+"</h4>	<table><tr><th>Address Details</th><th>Postal Code</th><th>City</th></tr>	<tr><td rowspan='5'><textarea name='addr"+addrNum+"'></textarea></td><td><input type='text' class='inp' name='postcode"+addrNum+"'></td><td><input type='text' class='inp' name='city"+addrNum+"'></td></tr><tr><th>County</th><th>Region</th></tr><tr><td><input type='text' class='inp' name='county"+addrNum+"'></td><td><input type='text' class='inp' name='region"+addrNum+"'></td></tr> <tr><th>Phone</th><th>Fax</th></tr><tr><td><input type='text' class='inp' name='phone"+addrNum+"'></td><td><input type='text' class='inp' name='fax"+addrNum+"'></td></tr></table></table>");
}

function addContact() {
	var data = {};
	data['count'] = addrNum;
	var empty = true;
	$("#operations :input").each(function(){
		if ( (this.tagName != 'SELECT') && ($(this).val().length > 0)) empty = false;
		data[$(this).attr('name')] = $(this).val();
	});
	if (empty) {
		alert("Put, at least, some information in the form");
		return 0;
	}
	$.post('inc/database.php?do=addContact',data,function(r){
		$("#operations").slideUp();
		redrawTable();
		alert(r);
	});
}

function checkBoxes() {
	$("#contact-table :checkbox").attr('checked','checked');
}

function uncheckBoxes() {
	$("#contact-table :checkbox").attr('checked','');
}

function changeBoxes() {
	var z = $("#contact-table input:checked");
	$("#contact-table :checkbox").attr('checked','checked');
	z.attr('checked','');
}

function loadContact(id) {
	$("#contact-table tr").removeClass("active");
	$("#contact-table tr[gid='"+id+"']").addClass("active");
	$("#information").load('inc/database.php?do=loadContact',{id:id},function(){
		$("#map").html('<img class="map-logo" src="img/gmaps.gif">');
	});
}

function loadAddress() {
	var addr = $("#addr-sel").val();
	$("#information .addr").hide();
	$("#information .addr[gid='"+addr+"']").fadeIn();
	var space = / /gi;
	var address = $("#information .addr[gid='"+addr+"'] .address").text().replace(space,"+");
	var city = $("#information .addr[gid='"+addr+"'] .city").text().replace(space,"+");
	var postcode = $("#information .addr[gid='"+addr+"'] .postcode").text().replace(space,"+");
	var loc = address +'+'+ city +'+'+ postcode + '+United+Kingdom';
	$("#map").html("<a target='_blank' href='http://maps.google.com/maps?oe=UTF-8&ie=UTF8&q="+loc+"'><img src='http://maps.google.com/maps/api/staticmap?zoom=14&size=270x270&maptype=roadmap&sensor=false&center="+loc+"&markers=color:green|label:V|"+loc+"'></a>");
}

function editContact(id) {
	$("#operations").load('inc/database.php?do=editContact',{id:id},function(){
		$("#operations").slideDown();
		addrNum = $("#operations #addr-count").val();
	});
}

function delContact(id) {
	if (confirm("Are you sure want to delete this contact?"))
		$.post('inc/database.php?do=delContact',{id:id},function(r){
			$("#operations").slideUp();
			redrawTable();
			alert(r);
		});
}

function saveContact(id) {
	var data = {};
	data['count'] = addrNum;
	data['cont_id'] = id;
	$("#operations :input").each(function(){
		data[$(this).attr('name')] = $(this).val();
	});
	$.post('inc/database.php?do=saveContact',data,function(r){
		$("#operations").slideUp();
		redrawTable();
		alert(r);
	});
}

function doSearch() {
	var data = {};
	$("#operations :input").each(function(){
		data[$(this).attr('name')] = $(this).val();
	});
	$.post('inc/database.php?do=doSearch',data,function(r){
		$("#contact-table").html(r);
		$("#contact-table tr:even").addClass('even-row');
		$("#contact-table tr").hover(function(){
			$(this).find(".cont-btns").show();
		},function(){
			$(this).find(".cont-btns").hide();
		});
	});
}

function export() {
	var str = '?do='+$("#format").val();
	$("#contact-table :checked").each(function(){
		str += '&data[]='+$(this).parent().parent().attr("gid");
	});
	$("#frame").attr('src','inc/export.php'+str);
}

function showSendMail() {
	$("#sendMail textarea").val('');
	$("#overlay").show();
  var w = $(window).width()/2 - 170;
  var h = $(window).height()/2 - 200;
  $("#sendMail").css('left',w+'px').css('top',h+'px').fadeIn();
}

function sendMail() {
	var data = {};
	var i = 1;
	$("#contact-table :checked").each(function(){
		data[i] = $(this).parent().parent().attr("gid");
		i++;
	});
	data['text'] = $("#sendMail #text").val();
	$.post('inc/export.php?do=sendMail',data,function(r){
		alert(r);
		$("#sendMail").fadeOut();
	});
}


