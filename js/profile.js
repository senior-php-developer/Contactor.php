$(init);

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
			$("#operations").load('inc/profile.php?do=show'+mod,function(){
				$("#operations").slideDown();
			});
		}
	});
}

function saveProfile() {
	var data = {};
	$("#operations input").each(function(){
		data[$(this).attr('name')] = $(this).val();
	});
	$.post('inc/profile.php?do=saveProfile',data,function(r){
		alert(r);
		$("#operations").slideUp();
		$(".toggle").removeClass("toggle-act");
	});
	
}

function changePwd() {
	var data = {};
	$("#operations input").each(function(){
		data[$(this).attr('name')] = $(this).val();
	});
	$.post('inc/profile.php?do=changePwd',data,function(r){
		alert(r);
		$("#operations").slideUp();
		$(".toggle").removeClass("toggle-act");
	});
}
