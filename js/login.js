$(document).ready(function () {

	$("#password2").keyup(function () {
		var password = $("#password").val();
		var password2 = $("#password2").val();
		if (password == password2) {
			$("#password").css("border", "1px solid green");
			$("#password2").css("border", "1px solid green");
		} else {
			$("#password").css("border", "1px solid red");
			$("#password2").css("border", "1px solid red");
		}

	})


		$('#register-form').submit(function (e) {
		e.preventDefault();
		var username = $("#username").val();
		var password = $("#password").val();
		var password2 = $("#password2").val();
		var email = $("#email").val();
		var birthday = $("#birthday").val();
		var name = $("#name").val();

		if (password != password2) {
			swal("Password does not match!");
		} else {
			$.post("process/register.php",
				{
					'username': username,
					'password': password,
					'email': email,
					'name': name,
					'birthday': birthday
				},
				function (data) {
					console.log(data);
					data=JSON.parse(data);
					switch(data["register"]){
						case "username taken":
							swal("Username Taken");
							$("#username").css("border", "1px solid red");
						break;
						
						case "email taken":
							swal("Email Taken");
							$("#email").css("border", "1px solid red");
						break;
						
						case "success":
							window.location.href="login.php";
						break;
					}
					
				})
				.fail(function (error) {
					console.log("erro!!!");
				});
		}

	});
});

$(document).ready(function () {

	$('#login-form').submit(function (e) {
		e.preventDefault();
		var username = $("#username").val();
		var password = $("#password").val();
		if ($.trim(username).length > 0 && $.trim(password).length > 0) {
			$.post("process/login.php",
			{"username":username,
			"password":password
			},function (data) {
				var result=JSON.parse(data);
						switch(result["login"]){
							case "error":
							//Shake animation effect.
							$('.login-block').effect("shake");
							$("#username").css("border", "1px solid red");
							$("#password").val('');
							$("#password").css("border", "1px solid red");

							$("#error").html("<span style='color:#cc0000'>Error:</span> Invalid username and password. ");
							break;
							default:
						
						window.location.href = "/Project";
						break;
						}
					
				}).fail(function(e){
					console.log("error!!")
				});
			

		}
		return false;
	});

});