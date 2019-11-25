/**
 * Esta función cambia la visibilidad de los elementos de la página, mostrando lo referente a la búsqueda y
 * ocultando el resto de elementos.  
 */

function searchMain(){
	$("#formRegAdmin").hide();
	$("#listaPromotores").hide();
	$("#listaClientes").hide();
	$("#formBusquedaUsuario").show();
	$("#control").hide();
	$("#cliPromSelect").val("cli");
	$("#promsMain").css(".boton2");
	$("#usersMain").css(".boton");
	$("#promsMain").css("text-decoration","none");
	$("#usersMain").css("text-decoration","none");
	$("#searchMain").css("text-decoration","underline");
	$("#tituloListaUsuarios").text("Búsqueda de usuarios");
}
/**
 * Como la anterior, cambia la visibilidad para mostrar lo relativo a la lista de clientes.
 */
function cliMain(){
	$("#formRegAdmin").hide();
	$("#listaBusqueda").hide();
	$("#listaPromotores").hide();
	$("#listaClientes").show();
	$("#formBusquedaUsuario").hide();
	$("#control").show();
	$("#cliPromSelect").val("cli");
	$("#promsMain").css(".boton2");
	$("#usersMain").css(".boton");
	$("#promsMain").css("text-decoration","none");
	$("#usersMain").css("text-decoration","underline");
	$("#searchMain").css("text-decoration","none");
	$("#tituloListaUsuarios").text("Clientes registrados");
}
/**
 * Igual  que las anteriores, muestra únicamente lo relativo a la lista de promotores.
 */
function promsMain(){
	$("#formRegAdmin").hide();
	$("#listaBusqueda").hide();
	$("#listaPromotores").show();
	$("#listaClientes").hide();
	$("#formBusquedaUsuario").hide();
	$("#control").show();
	$("#cliPromSelect").val("prom");
	$("#promsMain").css("text-decoration","underline");
	$("#usersMain").css("text-decoration","none");
	$("#searchMain").css("text-decoration","none");
	$("#tituloListaUsuarios").text("Promotores registrados");
}
/**
 * En este caso, hace visible el formulario de usuario desde la lista de promotores o clientes.
 * Rellena la información de cada usuario con cada selección desde los campos hidden que contiene la lista con cada
 * evento click.
 */
function  muestraUsuario(){
	$("#formRegAdmin").show();
	$("#listaPromotores").hide();
	$("#listaClientes").hide();
	$("#control").hide();
	cont=0;
	$(this).children('input').each(function(){
		switch (cont){
			case 0:{
				$("#idUsuario").val(this.value);
			}
			case 1:{
				$("#nombre").val(this.value);
				break;
			}
			case 2:{
				$("#apellidos").val(this.value);
				break;
			}
			case 3:{
				$("#correoReg").val(this.value);
				break;
			}
			case  4:{
				$("#dni").val(this.value);
				break;
			}
			case  5:{
				$("#cif").val(this.value);
				break;
			}
			case 6:{
				$("#direccion").val(this.value);
				break;
			}
			case 7:{
				$("#telefono").val(this.value);
				break;
			}
		}
		cont++;
	});
	if($("#cliPromSelect").val() == "cli"){
		$("#cifParticular").hide();
		$("#tipoUsuario").text("Cliente");
	}
	else if($("#cliPromSelect").val() == "prom"){
		$("#dniParticular").hide();
		$("#tipoUsuario").text("Promotor");
	}	
}

/*
 * Si se navega por las diferentes páginas de una lista, se modifican los campos de la lista
 * directamente sobre el formulario, tanto en nombre y apellidos, como en el resto de campos hidden.
 * Sirve para cualquier tipo de lista: cliente, promotor o búsqueda, mediante las etiquetas Prom, Cli o B.
 * Si la lista es menor que  el tamaño de página, oculta los últimos elementos que serían vacíos.
 */
function actualizaListaUsuarios(tipo,data){
	var tip;
	if(tipo == 5){
		tip = "Prom";
	}
	else{
		if(tipo == 6){
			tip = "Cli";
		}
		else{
			tip = "B";
		}
	}
	$.each(data.users, function(i, item) {
		$("#nameUs" + tip + "Box" + i).show();
		$("#nameUs" + tip + i).text(item.nombre + " " + item.apellidos);
		$("#idUs" + tip + i).val(item.idUsuario);
		$("#nombre" + tip + i).val(item.nombre);
		$("#apellidos" + tip + i).val(item.apellidos);
		$("#correo" + tip + i).val(item.correo);
		$("#dni" + tip + i).val(item.dni);
		$("#cif" + tip + i).val(item.cif);
		$("#direccion" + tip + i).val(item.direccion);
		$("#telefono" + tip + i).val(item.telefono);
		num= parseInt(i) + parseInt(1);
	});
	for(i = num; i < tamPag; i++){
		$("#nameUs"+ tip + i).html(" ");
		$("#nameUs" + tip + "Box" + i).hide();
	}
	
}

/*
 * Actualiza los datos de un usuario de la lista si  se han guardado cambios en los datos en la BD a través del
 * formulario de usuario, en vez de  navegación por páginas.
 * Similar a la función anterior pero para un usuario concreto.
 */
function actualizaUsuarioConcreto(tipo){
	tamPag  = $("#tamPagUsers").val();
	idBuscado = $("#idUsuario").val();
	if(tipo == 5){
		tip = "Prom";
	}
	else{
		if(tipo == 6){
			tip = "Cli";
		}
		else{
			tip = "B";
		}
	}
	i=-1;
	do{
		i++;
		idlocal = $("#idUs" + tip + i).val();
	}while(i<tamPag && idlocal != idBuscado);
	$("#nameUs" + tip + i).text($("#nombre").val() + " " + $("#apellidos").val());
	$("#idUs" + tip + i).val($("#idUsuario").val());
	$("#nombre" + tip + i).val($("#nombre").val());
	$("#apellidos" + tip + i).val($("#apellidos").val());
	$("#correo" + tip + i).val($("#correoReg").val());
	$("#dni" + tip + i).val($("#dni").val());
	$("#cif" + tip + i).val($("#cif").val());
	$("#direccion" + tip + i).val($("#direccion").val());
	$("#telefono" + tip + i).val($("#telefono").val());
}

/*
 * Tras el evento click del botón buscar del formulario de búsqueda, se cargan los campos visibles y los hidden para
 * realizar una búsqueda. Se implementa pidiendo directamente  una página de la búsqueda. Todos los campos se envían
 * de nuevo, en  vez de almacenarse en session.
 * Se recibe la nueva página de resultados.
 */
function buscarUsuarios(pag){
	nombre=$("#nombreBus").val();
	apellidos=$("#apellidosBus").val();
	dni=$("#dniBus").val();
	cif=$("#cifBus").val();
	direccion=$("#direccionBus").val();
	telefono=$("#telefonoBus").val();
	correo=$("#correoRegBus").val();
	tipo=$("[name=tipoUser]:checked").val();
	if(nombre == "" && apellidos == "" && dni == "" && cif == "" && direccion == "" && telefono == "" && correo == ""){
		$("#mensaje_busq").css('color', 'red', 'important');
		$("#mensaje_busq").html("Introduzca al menos un criterio de búsqueda textual.");
	}
	else{
		
		tamPag=$("#tamPagUsers").val();
		var postData = {
				'nombre' : nombre,
				'apellidos' : apellidos,
				'dni' : dni,
				'cif' : cif,
				'direccion' : direccion,
				'telefono' : telefono,
				'correo' : correo,
				'tipo' : tipo,
				'pag' : pag,
				'tamPag' : tamPag 
		}
		$.ajax({
			type: "POST",
			url: "control.php",
			data: "do=buscarUsuario&postData="+JSON.stringify(postData),
			dataType: "JSON",
			success: function(data){
				if(data.numUsers < 1){
					$("#mensaje_busq").css('color', 'red', 'important');
					$("#mensaje_busq").html("Ningún usuario con los criterios indicados.");	
				}
				else{
					$("#numTot_b").text(data.numUsers);
					numPagsBus = Math.floor(data.numUsers/tamPag);
					$("#maxPagB").val(numPagsBus);
					$("#pag_b").val(data.newPag);
					
					$("#numRel_b").text(parseInt(data.newPag)*parseInt(tamPag)+parseInt(1));
					limSup = parseInt(data.newPag)*parseInt(tamPag)+parseInt(tamPag);
					if(limSup <data.numUsers){
						$("#numRelFin_b").text(limSup);
					}
					else{
						$("#numRelFin_b").text(data.numUsers);
					}
					
					$("#mensaje_busq").css('color', 'green', 'important');
					$("#mensaje_busq").html("Se ha encontrado " + data.numUsers + " usuarios.");	
					actualizaListaUsuarios("B",data);
					$("#formBusquedaUsuario").hide();
					$("#control").show();
					$("#listaBusqueda").show();
					
					$("#mensaje_busq").css('color', 'green', 'important');
					$("#mensaje_busq").html("Datos actualizados con éxito");
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$("#mensaje_busq").css('color', 'red', 'important');
				$("#mensaje_busq").html("Error de conexión.");	
		    },
		    beforeSend:function(){
				$("#mensaje_busq").css('display', 'inline', 'important');
				$("#mensaje_busq").html("<img src='img/ajax-loader.gif' /> Cargando...");
			}
		});
	}
	
};

/*
 * El funcionamiento de esta función es ligeramente diferente a la anterior, pese a tener un resultado idéntico. En este
 * caso se indica el tipo de usuario, la página actual, el tamaño de la página y el sentido de la navegación: 1 hacia
 * delante y -1 hacia atrás.
 * El tratamiento es diferente dado que no  solo  se usan campos diferentes, sino que estos no permanecen al contrario
 * que en la búsqueda.
 */
function pagSigAnt(tipo,pag,tamPag,sentido){
	sigPag = parseInt(pag) + parseInt(sentido);
	var postData = {
		'tipo': tipo,
		'pagina': sigPag,
		'tamPagina': tamPag,
		'action': "sig"
	}
	maxpag=0;
	if(tipo == 5 ){
		maxpag=$("#maxPagProm").val();
	}
	else{
		if(tipo == 6 ){
			maxpag=$("#maxPagCli").val();
		}
	}
	maxpag=Math.floor(maxpag);
	if(sigPag <= maxpag && sigPag >= 0){
		$.ajax({
			type: "POST",
			url: "control.php",
			data: "do=userAdminSigPag&postData="+JSON.stringify(postData),
			dataType: "JSON",
			success: function(data){
				if(data.error === 0){
					$("#pag_cli").val(data.newPag);
					tamPag=$("#tamPagUsers").val();
					newPag=data.newPag;
					numUsers=data.numUsers;
					inicio=newPag * tamPag + parseInt(1);
					fin=parseInt(inicio) + parseInt(numUsers) - 1;
					$("#numRel_c").html(inicio);
					$("#numRelFin_c").html(fin);
					num =  0;
					actualizaListaUsuarios(tipo,data);
				
				}
				else{
					$("#mensaje_busq").css('color', 'red', 'important');
					$("#mensaje_busq").html("Ha habido un problema con la carga de datos.");
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$("#mensaje_busq").css('color', 'red', 'important');
				$("#mensaje_busq").html("Error de conexión.");	
		    },
		    beforeSend:function(){
				$("#passwd_error").css('display', 'inline', 'important');
				$("#passwd_error").html("<img src='img/ajax-loader.gif' /> Cargando...");
			}
			//TODO: Ver las funciones success y beforeEnd en crearEvento.js y en control.php para ver qué  devolver
		});
	}
}

$(document).ready(function(){
	
	/*
	 * Inicializa la vista predeterminada a  la lista de clientes y determina el comportamiento de cada botón. 
	 */
	$("#listaBusqueda").hide();
	$("#formRegAdmin").hide();
	$("#formBusquedaUsuario").hide();
	$("#dotProm").hide();
	$("#dotCli").show();
	$("#listaPromotores").hide();
	$("#listaClientes").show();
	$(".user_select").click(muestraUsuario);
	$("#searchMain").click(searchMain);
	$("#usersMain").click(cliMain);
	$("#promsMain").click(promsMain);
	$("#usersMain").css("text-decoration","underline");
	$("#findUsers").click(function(){
		buscarUsuarios(0);
	});
	$("#sigPagUsCli").click(function(){
		pagAct = $("#pag_cli").val();
		tamPag = $("#tamPagUsers").val();
		pagSigAnt(6,pagAct,tamPag,1);
	});
	$("#sigPagB").click(function(){
		pagAct = $("#pag_b").val();
		pagSig = parseInt(pagAct) + parseInt(1);
		buscarUsuarios(pagSig);
	});
	$("#ultPagUsCli").click(function(){
		pagAct = $("#pag_cli").val();
		tamPag = $("#tamPagUsers").val();
		pagSigAnt(6,$("#maxPagCli").val(),tamPag,0);
	});
	$("#ultPagB").click(function(){
		ultPag = $("#maxPagB").val();
		buscarUsuarios(ultPag);
	});
	$("#antPagUsCli").click(function(){
		pagAct = $("#pag_cli").val();
		tamPag = $("#tamPagUsers").val();
		pagSigAnt(6,pagAct,tamPag,-1);
	});
	$("#antPagB").click(function(){
		pagAct = $("#pag_b").val();
		if(pagAct > 0){
			pagSig = parseInt(pagAct) - parseInt(1);
			buscarUsuarios(pagSig);
		}
	});
	$("#primeraPagB").click(function(){
		pagAct = $("#pag_b").val();
		tamPag = $("#tamPagUsers").val();
		buscarUsuarios(0);
	});
	$("#primeraPagUsCli").click(function(){
		pagAct = $("#pag_cli").val();
		tamPag = $("#tamPagUsers").val();
		pagSigAnt(6,0,tamPag,0);
	});
	
	$("#antPagUsProm").click( function(){
		pagAct =  $("#pag_prom").val();
		tamPag  = $("#tamPagUsers").val();
		pagSigAnt(5,pagAct,tamPag,1);
	}
	);
	
	$("#primeraPagUsProm").click(function(){
		pagAct = $("#pag_prom").val();
		tamPag = $("#tamPagUsers").val();
		pagSigAnt(5,0,tamPag,0);
	});
	
	$("#sigPagUsProm").click( function(){
		pagAct =  $("#pag_prom").val();
		tamPag  = $("#tamPagUsers").val();
		pagSigAnt(5,pagAct,tamPag,-1);
	}
	);
	$("#ultPagUsProm").click(function(){
		pagAct = $("#pag_prom").val();
		tamPag = $("#tamPagUsers").val();
		pagSigAnt(5,$("#maxPagProm").val(),tamPag,0);
	});
	$("#updateDataAdmin").click(function(e){
		e.preventDefault();
		//Fuunción definida en actualizarDatosUsuario.js
		botonActualiza(true);
		if($("#cliPromSelect").val() == "cli"){
			
			actualizaUsuarioConcreto(6);
		}
		else if($("#cliPromSelect").val() == "prom"){
			actualizaUsuarioConcreto(5);
		}
	});
	$("#checkCli").click(function(){
		$("#radioCli").prop("checked",true);
	});
	$("#checkProm").click(function(){
		$("#radioProm").prop("checked",true);
	});
	$("#checkInd").click(function(){
		$("#radioInd").prop("checked",true);
	});
});