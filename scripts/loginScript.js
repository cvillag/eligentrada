var loginActive = false;

function toggleLoginForm(){
	if(!loginActive) showLoginForm();
	else hideLoginForm();
}

function showLoginForm(){
	document.getElementById("login_form").style.display="block";
	loginActive = true;
}

function hideLoginForm(){
	document.getElementById('login_form').style.display='none';
	loginActive = false;
}

$(document).ready(function(){
	$("#login_error").css('display', 'none', 'important');
	$("#login_entrar").click(function(e){
		e.preventDefault();
		username=$("#correo").val();
		password=$("#pass").val();
		$.ajax({
			type: "POST",
			url: "validar_usuario.php",
			data: "correo="+username+"&pass="+password,
			dataType: "json",
			success: function(data){    
				if(data.login)    {
				//$("#login_error").html("right username or password");
				//window.location="dashboard.php";
				window.location="index.php";
				}else if(!data.login && data.intentos >= 3){
					$("#login_error").css('display', 'table-caption', 'important');
					$("#login_error").html("<img src='img/error.png'/> Ha alcanzado el máximo de intentos en 5 minutos.");
				} else{
					$("#login_error").css('display', 'table-caption', 'important');
					$("#login_error").html("<img src='img/error.png'/> Nombre de usuario o contraseña incorrectos");
				}
			},
			beforeSend:function(){
				$("#login_error").css('display', 'inline', 'important');
				$("#login_error").html("<img src='img/ajax-loader.gif' /> Cargando...")
			}
		});
		return false;
	});

	$("#logout").click(function(e){
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: "logout.php",
			success: function(html){    
				window.location="index.php";
			},
		});
		return false;
	});
});