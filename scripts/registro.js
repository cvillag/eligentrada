$(document).ready(function(){
	$("#registro").click(function(e){
		e.preventDefault();
		nombre=$("[name=nombre]").val();
		apellidos=$("[name=apellidos]").val();
		dni=$("[name=dni]").val();
		correo=$("[name=correoReg]").val();
		direccion=$("[name=direccion]").val();
		telefono=$("[name=telefono]").val();
		password=$("[name=password]").val();
		passwordCheck=$("[name=passwordCheck]").val();

		if($("[name=password]").val() != $("[name=passwordCheck]").val()){
			$("#passwd_error").css('display', 'inline', 'important');
			$("#passwd_error").html("<img src='img/error.png'/> Las contraseñas no coinciden ");
			return null;
		}
		var regex = /^([a-zA-Z ]+)$/i;
		if(!regex.exec($("[name=nombre").val())) {
			$("#passwd_error").css('display', 'inline', 'important');
			$("#passwd_error").html("<img src='img/error.png'/> El nombre solo puede contener letras y espacios y no puede estar vacío.");
			return null;
		}
		var regex = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([a-zA-Z0-9.-]+).([a-zA-Z]{2,4})$/i;
		if(!regex.exec($("[name=correoReg").val())) {
			$("#passwd_error").css('display', 'inline', 'important');
			$("#passwd_error").html("<img src='img/error.png'/> Los apellidos solo puede contener letras y espacios.");
			return null;
		}
		if($("[name=apellidos").val() != ""){
			if(!regex.exec($("[name=apellidos").val())) {
				$("#passwd_error").css('display', 'inline', 'important');
				$("#passwd_error").html("<img src='img/error.png'/> Los apellidos solo puede contener letras y espacios.");
				return null;
			}
		}
		if($("[name=telefono").val() != ""){
			var regex = /^[+]?([0-9]{9,12})$/i;
			if(!regex.exec($("[name=telefono").val())) {
				$("#passwd_error").css('display', 'inline', 'important');
				$("#passwd_error").html("<img src='img/error.png'/> El teléfono solo puede contener números (o empezar por + en formato internacional).");
				return null;
			}
		}
		var regex = /^[ABXYZ]?([0-9]{7,8})([A-Z])$/i;
		if($("[name=dni").val() != ""){
			if(!regex.exec($("[name=dni").val())) {
				$("#passwd_error").css('display', 'inline', 'important');
				$("#passwd_error").html("<img src='img/error.png'/> El DNI debe tener el formato correcto.");
				return null;
			}
		}

		var postData = {
		'nombre': nombre,
		'apellidos': apellidos,
		'dni': dni,
		'correo': correo,
		'direccion': direccion,
		'telefono': telefono,
		'password': password,
		'passwordCheck': passwordCheck
		}
		$.ajax({
			type: "POST",
			url: "control.php",
			data: "do=registroUsuario&postData="+JSON.stringify(postData),
			dataType: "JSON",
			success: function(data){
				if(data.err == 0){
					$("#formReg").css('color', 'green', 'important');
					$("#formReg").html('<div class="row">Usuario Registrado con éxito</div>');
				} else if(data.err == 'userExists'){
					$("#passwd_error").css('display', 'inline', 'important');
					$("#passwd_error").html("<img src='img/error.png'/> La direccion de correo ya existe ");
				} else{
					$("#passwd_error").css('display', 'inline', 'important');
					$("#passwd_error").html("<img src='img/error.png'/> Error en la solicitud ");
				}
			},
			beforeSend:function(){
				$("#passwd_error").css('display', 'inline', 'important');
				$("#passwd_error").html("<img src='img/ajax-loader.gif' /> Cargando...");
			}
		})
	})
});