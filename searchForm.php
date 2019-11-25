<?php 
if(isset($_REQUEST["q"])){
	$textBusqueda=htmlspecialchars(trim(strip_tags($_REQUEST["q"])));
} else {
	$textBusqueda='Búsqueda';
}
?>

<form  method="post" action="search.php"> 
	<input type="text" name="q" value="<?php echo $textBusqueda ?>" id="searchInput"/>
	<input type="submit" class="boton2" name="enviar" value="buscar"/>
</form>
<script type="text/javascript">
	$(document).ready(function() {
			$("#searchInput").on("focus", function(){
        	$("#searchInput").val("");
        });
    });
</script>