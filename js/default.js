$(init);

function init() {
	$.ajaxSetup({
		beforeSend: function(){$("#loader").show();},
    success: function(){$("#loader").hide();},
    complete: function(){$("#loader").hide();}
  });
}

function alert(msg) {
  $("#alert-msg").html(msg);
	$("#overlay").show();
  var w = $(window).width()/2 - 170;
  var h = $(window).height()/2 - 75;
  $("#alert").css('left',w+'px').css('top',h+'px').fadeIn();
}

function loadMod(page) {
	location.href = 'index.php?mod='+page;
}

function doLogout() {
	$.post('inc/login.php?do=doLogout',function(){
		location.href = 'index.php';
	});
}
