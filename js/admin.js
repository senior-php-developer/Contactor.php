$(init);

function init() {
	initLinks();
	showUsers();
}

function showUsers() {
	$("#user-list").load('inc/admin.php?do=showUsers',function(){
		$("#user-list tr").hover(function(){
			$(this).find(".cont-btns").show();
		},function(){
			$(this).find(".cont-btns").hide();
		});
		$("#user-list table").tablesorter({sortList: [[0,0]], widthFixed: true, widgets: ['zebra']}).tablesorterPager({container: $("#pager")});
	});
}

function initLinks() {
	$(".toggle").click(function(){
	if ($(this).hasClass("toggle-act")) {
		$(this).removeClass("toggle-act");
		$("#operations").slideUp();
	} else {
		$(".toggle").removeClass("toggle-act");
		$("#operations").slideUp();	
		$(this).addClass("toggle-act");
		var mod = $(this).attr("gid");
		$("#operations").load('inc/admin.php?do=show'+mod,function(){
			$("#operations").slideDown();
		});
	}
});
}

function doAddUser() {
	var data = {};
	$("#operations :input").each(function(){
		data[$(this).attr('name')] = $(this).val();
	});
	$.post('inc/admin.php?do=doAddUser',data,function(r){
		showUsers();
		alert(r);
	});
}

function editUser(id) {
	$(".toggle").removeClass("toggle-act");
	$("#operations").slideUp();	
	$("#operations").load('inc/admin.php?do=editUser',{id:id},function(){
		$("#operations").slideDown();
	});
}

function doEditUser(id) {
	var data = {};
	$("#operations :input").each(function(){
		data[$(this).attr('name')] = $(this).val();
	});
	data['id'] = id;
	$.post('inc/admin.php?do=doEditUser',data,function(r){
		showUsers();
		alert(r);
		$("#operations").slideUp();
	});
}

function delUser(id) {
	if (confirm("Are you sure want to delete this user?"))
		$.post('inc/admin.php?do=delUser',{id:id},function(r){
			showUsers();
			alert(r);
		});
}
