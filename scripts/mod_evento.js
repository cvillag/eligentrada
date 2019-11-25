$(document).ready(function(){
	$("#guardar").click(function(e){
		e.preventDefault();
        idEvento=$("[name=idEvento]").val();
		nombre=$("[name=nombre]").val();
		lugar=$("[name=lugar]").val();
		fecha=$("[name=fecha]").val();
		hora=$("[name=hora]").val();
		descripcion=$("[name=descripcion]").val();
        imagen=$("[name=imagen]").val();
        ubicacionLatLong=$("[name=ubicacionLatLong]").val();
		//Para saber que radio esta selecionado
		var i 
	   	for (i=0;i<document.form_ev.tipo.length;i++){ 
	      	if (document.form_ev.tipo[i].checked) 
	         	break; 
	   	} 
	   	tipo = document.form_ev.tipo[i].value

		var postData = {
        'idEvento': idEvento,
		'nombre': nombre,
		'lugar': lugar,
		'fecha': fecha,
		'hora': hora,
		'descripcion': descripcion,
		'tipo': tipo,
        'imagen': imagen,
        'ubicacionLatLong': ubicacionLatLong
		}

        var entradas = {};

        for(i = 0; i < Nentradas; i++){

            tipoEn=$("[name=tipo" + (i+1) + "]").val();
            nombreEntrada=$("[name=nombreEntrada" + (i+1) + "]").val();
            precio=$("[name=precEn" + (i+1) + "]").val();
            cantidad=$("[name=cantEn" + (i+1) + "]").val();
            var postTipo = {
                'tipoEn': tipoEn,
                'nombreEntrada': nombreEntrada,
                'precio': precio,
                'cantidad': cantidad
            }
            entradas['entrada'+i] = postTipo;
        }
        postData['entradas'] = entradas;

		$.ajax({
			type: "POST",
			url: "control.php",
			data: "do=editarEvento&postData="+JSON.stringify(postData),
			dataType: "JSON",
			success: function(data){
				if(data.err == 0){
					$("#formEv").css('color', 'green', 'important');
					$("#formEv").html('<div class="row">Evento guardado con éxito</div>');
				} else{
					$("#passwd_error").css('display', 'inline', 'important');
					$("#passwd_error").html("<img src='img/error.png'/> Error en la solicitud ");
				};
			},
			beforeSend:function(){
				$("#passwd_error").css('display', 'inline', 'important');
				$("#passwd_error").html("<img src='img/ajax-loader.gif' /> Guardando...");
			}
		})
	})

    $("#plus").click(function(e){
        Nentradas++;
        $("#plus").before("<div class='row' id='row" + Nentradas + "'><div class='celdaDef' id='tipoEn'><select name='tipo" + Nentradas + "'>"+$('select[name=tipo1]').html()+"</select></div><div class='celdaMed'><input type='text' name='nombreEntrada" + Nentradas + "'/></div><div class='celdaVal peq'><input type='number' name='precEn" + Nentradas + "'  /></div><div class='celdaCan peq'><input type='number' name='cantEn" + Nentradas + "' /></div></div>");
    })

    
    $("#delete").click(function(e){
        if(Nentradas > 1){
            $("#row" + Nentradas).remove();
            Nentradas--;
        }
    })    
});

var Nentradas = 2;
// Variable to store your files
var files;

// Add events
$('input[type=file]').on('change', prepareUpload);

// Grab the files and set them to our variable
function prepareUpload(event)
{
  files = event.target.files;
}


$('form[id="fileUpload"]').on('submit', uploadFiles);

// Catch the form submit and upload the files
function uploadFiles(event)
{
  event.stopPropagation(); // Stop stuff happening
    event.preventDefault(); // Totally stop stuff happening

    // START A LOADING SPINNER HERE

    // Create a formdata object and add the files
    var data = new FormData();
    $.each(files, function(key, value)
    {
        data.append(key, value);
    });

    $.ajax({
        url: 'upload.php?files',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(data, textStatus, jqXHR)
        {
            if(typeof data.error === 'undefined')
            {
                // Success so call function to process the form
                //submitForm(event, data);
                $("#cartel_ev").attr("src", data.filename);
                $("[name=imagen]").attr("value",data.filename);
                $("#errorUpload").css('display', 'none', 'important');
                $("#errorUpload").html();
            }
            else
            {
                // Handle errors here
                $("#errorUpload").css('display', 'block', 'important');
                $("#errorUpload").html("<img src='img/error.png'/> Error: "+data.error);
                console.log('ERRORS: ' + data.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
            console.log('ERRORS: ' + textStatus);
            // STOP LOADING SPINNER
        }
    });
}