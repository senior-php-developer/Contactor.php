$(init);

function init() {
	$("#login-box input").focus(function(){
		if ($(this).attr('name') == 'user') {
			if ($(this).val() == 'E-mail')
				$(this).val('');
		} 
		if ($(this).attr('id') == 'pass') {
			$(this).hide();
			$("#real-pass").focus();
		}
	});
	$("#login-box input").blur(function(){
		if ($(this).val() == '') {
			if ($(this).attr('name') == 'user')
				$(this).val('Username');
			else {
				$("#pass").show();
			}
		}
	});
}

function doLogin() {
	var data = {};
	$("#login-box input").each(function(){
		data[$(this).attr('name')] = $(this).val();
	});
	$.post('inc/login.php?do=doLogin',data,function(r){
		if (r == "LOGIN_OK")
			location.reload();
		else
			alert(r);
	});
}