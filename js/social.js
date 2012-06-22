$(init);

function init() {
	initLinks();
	showTwits();
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
		$("#operations").load('inc/social.php?do=show'+mod,function(){
			$("#operations").slideDown();
		});
	}
});
}

function showTwits() {
	$("#twitters").load('inc/social.php?do=showTwits');
}

function addAccount() {
	var data = {};
	data['user'] = $("#tw-user").val();
	data['pass'] = $("#tw-pass").val();
	$.post('inc/social.php?do=addAccount',data,function(r){
		$("#operations").load('inc/social.php?do=showAddAccount');
		showTwits();
		alert(r);
	});
}

function openTwit(id) {
	$("#twitters .twt-box").hide();
	$("#twitters .twt-box[gid='"+id+"']").show();
}

function updateStatus() {
	var st = $("#twtstatus").val();
	$.post('inc/social.php?do=updateStatus',{st:st},function(r){
		alert("Tweet has been added");
		$("#twitters").load('inc/social.php?do=showTwits');
	});
}

function disable(id) {
	$.post('inc/social.php?do=disable',{id:id},function(r){
		$("#operations").load('inc/social.php?do=showAddAccount');
		$("#twitters").load('inc/social.php?do=showTwits');
	});
}


function enable(id) {
	$.post('inc/social.php?do=enable',{id:id},function(r){
		$("#operations").load('inc/social.php?do=showAddAccount');
		$("#twitters").load('inc/social.php?do=showTwits');
	});
}