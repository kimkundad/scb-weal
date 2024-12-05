	$(".show-pass1").click(function (e) {
		e.preventDefault();
		var type = $("#form-password1").attr('type');
		switch (type) {
			case 'password':
			{
				$("#form-password1").attr('type', 'text');
				return;
			}
			case 'text':
			{
				$("#form-password1").attr('type', 'password');
				return;
			}
		}
	});
	
	
	$(".show-pass2").click(function (e) {
		e.preventDefault();
		var type = $("#form-password2").attr('type');
		switch (type) {
			case 'password':
			{
				$("#form-password2").attr('type', 'text');
				return;
			}
			case 'text':
			{
				$("#form-password2").attr('type', 'password');
				return;
			}
		}
	});