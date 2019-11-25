$(document).ready(function(){

	// Envia como parametro el nombre introducido en el cuadro de texto a control.php
	// para crear el nuevo tipo de entrada
	$("#crear").click(function(e){
		e.preventDefault();
		nombreTipo=$("[name=nombrTipo]").val();

		var postData = {
		'nombreTipo': nombreTipo
		}

		$.ajax({
			type: "POST",
			url: "control.php",
			data: "do=crearTipoEntrada&postData="+JSON.stringify(postData),
			dataType: "JSON",
			success: function(data){
                location.reload();
			},
			beforeSend:function(){
				$(".celdaCrear").html("<img src='img/ajax-loader.gif' /> Guardando...");
			}
		})
	})
    
    // El cuadro de texto de editar toma el valor que se haya pulsado en los radio buttons
    $("#tipo").click(function(e){

    	var i 
	   	for (i=0;i<document.form_en.tipo.length;i++){ 
	      	if (document.form_en.tipo[i].checked) 
	         	break; 
	   	} 
	   	tipo = document.form_en.tipo[i].value

	   	$("#nombreTipoEntrada").val(tipo);
		
	})

    // Envia el valor del cuadro de texto de editar para cambiar el nombre de una determinada entrada
	$("#editar").click(function(e){

    	var i 
	   	for (i=0;i<document.form_en.tipo.length;i++){ 
	      	if (document.form_en.tipo[i].checked) 
	         	break; 
	   	} 
	   	tipoOrig = document.form_en.tipo[i].value

	   	tipo = $("#nombreTipoEntrada").val();

	   	var postData = {
	   	'tipoOrig': tipoOrig,
		'tipo': tipo
		}
		console.log(tipo);
		$.ajax({
			type: "POST",
			url: "control.php",
			data: "do=editarTipoEntrada&postData="+JSON.stringify(postData),
			dataType: "JSON",
			success: function(data){
                location.reload();
			},
			beforeSend:function(){
				$(".celdaEditar").html("<img src='img/ajax-loader.gif' /> Guardando...");
			}
		})
		
	})
});