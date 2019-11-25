function compute_total(){
	var sum = 0;
	$('#total').val(0);
	var inputs = $('.entrada'); //.children[0].value
	for(i=0; i< inputs.length; i++){
		if(!isNaN(parseFloat(inputs[i].children[0].value))&&!isNaN(parseInt(inputs[i].children[2].value)))
			sum += parseFloat(inputs[i].children[0].value) * parseInt(inputs[i].children[2].value);
	}
	$('#total').val(sum);
}

$(document).ready(function(){
	$("#bt_buy").click(function(e){
		e.stopPropagation();
		e.preventDefault();
		var entradas = {};

		var eventId = $('input[name=idEvento]').val();
		var inputs = $('.entrada');
		for(i=0; i< inputs.length; i++){
			if(!isNaN(parseInt(inputs[i].children[0].value))&&!isNaN(parseFloat(inputs[i].children[2].value))){
				var cantidad = parseInt(inputs[i].children[2].value);
				var id = parseInt(inputs[i].children[1].value);

				var postTipo = {
                	'tipoEn': id,
                	'cantidad': cantidad,
                	'idEvento': eventId
            	}
            	entradas['entrada'+i] = postTipo;
			}
		}
		$.ajax({
			type: "POST",
			url: "confirmaCompra.php",
			data: "postData="+JSON.stringify(entradas),
			dataType: "html",
			success: function(data){
				$('#formEvento').html(data);
			}
		});
		return false;
	});
});

$('#formEvento').on('click', '#bt_confirmar', function confirmaCompra(e){
	e.stopPropagation();
	e.preventDefault();

	var postData = $('input[name="postData"]').val();
	
	$.ajax({
		type: "POST",
		url: "control.php",
		data: "do=buyTickets&postData="+postData,
		dataType: "JSON",
		success: function(data){
			if(data.err == 0){
				$("#infoEvento").css('color', 'green', 'important');
				$("#infoEvento").html('<div class="row">Compra realizada con éxito</div>');
			} else if(data.err == "notEnough"){
				alert('No quedan suficientes entradas disponibles');
			};
		}
	});
	return false;
});
