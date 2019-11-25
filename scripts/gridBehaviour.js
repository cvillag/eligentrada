$(document).ready(function(){
	//Reordenacion de elementos con parametro posicion-sm para pantallas pequeñas (<992px)
	if($(window).width()<992){
		var listaDiv = $('div[posicion-sm]');
		if(listaDiv.length > 0){
			listaDiv.sort(function(a,b){
				return $(a).attr('posicion-sm') - $(b).attr('posicion-sm');
			});
			$('.page-wrapper').html(listaDiv);
		}
	}

	//Creacion de la barra  superior en moviles
	if($(window).width()<768){
		$('#navG').css('position', 'absolute');
		$('#navG').css('z-index', '1');
		$('#navG').css('left', '-260px');
		$("#logo").attr("src","img/logo-small.png");

		$('header').prepend('<button type=\"button\" class=\"navbar-toggle\" id=\"expandMenu\""><span class=\"sr-only\">Toggle navigation</span><span class=\"icon-bar\"></span><span class=\"icon-bar\"></span><span class=\"icon-bar\"></span></button>');

		$('#expandMenu').click(function(){
			var io = this.io ^= 1;
			$('#navG').animate({ left: io ? 0 : -260 }, 'slow');
		})
	};
});