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

		var dataString = 'username=' + username + '&password=' + password + '&email=' + email + '&name=' + name + '&birthday=' + birthday;
		console.log(dataString);

		if ($.trim(username).length > 0 && $.trim(password).length > 0 && password == password2) {
			$.post("processRegister.php",
				{
					'username': username,
					'password': password,
					'email': email,
					'name': name,
					'birthday': birthday
				},
				function (data) {
					console.log(data);
					if (data) {
						alert("0");
					}
					else {
						alert("1");
						//Shake animation effect.
						/*$('.register-block').effect("shake");
						console.log("error");
						$("#error").html("<span style='color:#cc0000'>Error:</span> Invalid username and password. ");*/
					}
				})
				.fail(function (error) {
					console.log("erro!!!");
				});

		} else {
			$('.register-block').effect("shake");
			console.log("entra");
			return false;
		}

	});

});

$(document).ready(function () {

	$('#login-form').submit(function (e) {
		e.preventDefault();
		var username = $("#username").val();
		var password = $("#password").val();
		if ($.trim(username).length > 0 && $.trim(password).length > 0) {
			$.post("processLogin.php",
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
					Console.log("error!!")
				});
			

		}
		return false;
	});

});