<?php
	if(isset($_REQUEST['postData'])) {
		include 'bd/eventoDAO.php';
		include 'bd/tipoEntradaEventoDAO.php';
		$postData = $_REQUEST['postData'];
		$datos = json_decode($postData);
?>

<div class="formulario">
	<div class="tituloForm">Confirmar la compra</div>
	<?php
		$total = 0;
		foreach ($datos as $entrada) {
			$cantidad = htmlspecialchars(trim(strip_tags($entrada->cantidad)));
			$idEntrada = htmlspecialchars(trim(strip_tags($entrada->tipoEn)));
			$idEvento = htmlspecialchars(trim(strip_tags($entrada->idEvento)));
			$evento = eventoDAO::getEventoById($idEvento);
			$precioUd = tipoEntradaEventoDAO::getEntradaEventoByIdEvento($evento->getIdEvento(),$idEntrada)->getPrecio();
			$precio = $cantidad * $precioUd;
			$total += $precio;

			echo '
				<div class="row">
					<div class="celdaDef">'.$cantidad.' '.tipoEntradaEventoDAO::getEntradaEventoByIdEvento($evento->getIdEvento(),$idEntrada)->getNombreParticular().' x '.$precioUd.'€</div>	
					<div class="celdaVal">'.$precio.'€</div>
				</div>';
		}
		echo '
		<div class="row">
			<div class="celdaDef">Total</div>	
			<div class="celdaVal">'.$total.'€</div>
		</div>
		<div class="pieForm">
			<a class="boton2" id="bt_confirmar">Confirmar</a>
			<a class="boton2" href="index.php">Cancelar</a>
		</div>
		<form>
			<input type="hidden" name="postData" value="'.htmlspecialchars($postData).'">
    	</form>';

	?>
</div>

<?php } ?>