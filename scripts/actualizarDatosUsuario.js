function actualiza(oldPass, newPass){
	var postData = {
		'nombre': nombre,
		'apellidos': apellidos,
		'dni': dni,
		'cif': cif,
		'correo': correo,
		'direccion': direccion,
		'telefono': telefono,
		'oldPass': oldPass,
		'newPass': newPass,
		'id': id
	}
	$.ajax({
		type: "POST",
		url: "control.php",
		data: "do=actualizaDatosUsuario&postData="+JSON.stringify(postData),
		dataType: "JSON",
		success: function(){
			$("#passwd_error").css('color', 'green', 'important');
			$("#passwd_error").html("Datos actualizados con éxito");	
		},
		beforeSend:function(){
			$("#passwd_error").css('display', 'inline', 'important');
			$("#passwd_error").html("<img src='img/ajax-loader.gif' /> Cargando...");
		}
	})
}

function botonActualiza(isAdm){
	nombre=$("[name=nombre]").val();
	apellidos=$("[name=apellidos]").val();
	dni=$("[name=dni]").val();
	cif=$("[name=cif]").val();
	correo=$("[name=correoReg]").val();
	direccion=$("[name=direccion]").val();
	telefono=$("[name=telefono]").val();
	if(isAdm){
		//Si no es administrador no meterá ningún id. En todo  caso se comprueba en php que es administrador si mete otra id, por seguridad.
		id=$("#idUsuario").val();
	}
	else{
		id=0;
	}

	if($("[name=newPass]").val()){
		if($("[name=newPass]").val() != $("[name=newPassCheck]").val()){
			$("#passwd_error").css('display', 'inline', 'important');
			$("#passwd_error").html("<img src='img/error.png'/> Las contraseñas no coinciden ");
			return null;
		} else if(checkPassword($("[name=currPass").val())){
			console.log("setting pass");				
		} else return null;
	} else {
		var newPass;
		var oldPass;
		actualiza(oldPass, newPass,false);
	}
}

function checkPassword(currPass){
	var newPass;
	var oldPass;
	$.ajax({
		type: "POST",
		url: "control.php",
		data: "do=checkPassword&pass="+currPass,
		dataType: "json",
		success: function(data){
			if(!data.login && data.intentos < 3){
				$("#passwd_error").css('display', 'inline', 'important');
				$("#passwd_error").html("<img src='img/error.png'/> Contraseña incorrecta ");							
				return false;
			} else if(!data.login && data.intentos >= 3){
				$("#passwd_error").css('display', 'inline', 'important');
				$("#passwd_error").html("<img src='img/error.png'/> Máximo numero de intentos alcanzado. ");	
				return false;
			} else {
				console.log("pass correcta");
					newPass=$("[name=newPass]").val();
					oldPass=$("[name=currPass]").val();
					actualiza(oldPass, newPass);
				return true;
			}
		},
		beforeSend:function(){
			$("#passwd_error").css('display', 'inline', 'important');
			$("#passwd_error").html("<img src='img/ajax-loader.gif' /> Comprobando...");
		}
	});
}

$(document).ready(function(){
	$.ajax({
		type: "POST",
		url: "control.php",
		data: "do=getDatosPropios",
		dataType: "json",
		success: function(data){
			$("[name=nombre]").val(data.nombre);
			$("[name=apellidos]").val(data.apellidos);
			$("[name=dni]").val(data.dni);
			$("[name=cif]").val(data.cif);
			$("[name=direccion]").val(data.direccion);
			$("[name=telefono]").val(data.telefono);
			$("[name=correoReg]").val(data.correo);
		}
	})
});


$(document).ready(function(){
	$("#updateData").click(function(e){
		e.preventDefault();
		botonActualiza(false);
	});
});