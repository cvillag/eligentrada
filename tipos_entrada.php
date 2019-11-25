<?php include("header.php");
	include_once 'bd/compraDAO.php';
	include_once 'bd/eventoDAO.php';
	include_once 'bd/tipoEventoDAO.php';
	include_once 'bd/tipoEntradaDAO.php';
	include_once 'class/compra.php';
 ?>

<div id="contenido">
	<?php include("nav.php") ?>
<?php if(isset($_SESSION['nombre'])){?>
	<div class="page-wrapper">
		<!--Barra de busqueda-->
		<div id="form_busqueda" class="grid-xs-12 grid-md-12 grid-sm-12">
			<?php include('searchForm.php');?>
		</div>
		
		<div id="cont_misentradas" class="grid-xs-12 grid-md-10 grid-sm-12">
		<div class="titulo_evento"><h2>Tipos de entradas</h2></div>
		<h3 class="c2">Existentes</h3>
		<div class="linea"></div>

		<form method="post" name="form_en">
			<ul class="lista">
				<li class="celda" id="tipo">
					<?php
						$arr = TipoEntradaDAO::getTiposEntrada();
						$i;
						for($i = 0; $i < sizeof($arr); $i++){
							echo '<input id="pru'.$i.'" type="radio" name="tipo" value="'.$arr[$i]->getNombre().'"><label for="pru'.$i.'"><span></span>'.$arr[$i]->getNombre().'</label><br>';
						}
					?>
				</li>
				<li class="celdaEditar" >
					<div class="row">
						<div class="celdaDef pequena">
							<input type="text" class="inputFull" name="nombrTipoEditar" id="nombreTipoEntrada" />
						</div>
						<div class="celdaVal grande">
							<a class="boton3" href="" id="editar">Editar</a>
						</div>
					</div>
				</li>	
			</ul>
		</form>
		<h3 class="c2">Crear nuevo</h3>
		<div class="linea"></div>
			<ul class="lista">
			<li class="celdaCrear" id="celdaCrear">
				<form method="post" name="form_ev">
					<div class="row">
						<div class="celdaDef pequena">
							<input type="text" class="inputFull" name="nombrTipo"  />
						</div>
						<div class="celdaVal grande">
							<a class="boton3" href="" id="crear">Crear</a>
						</div>
					</div>
				</form>
			</li>
			</ul>
		</div>
	</div>
</div>
<script type="text/javascript" src="scripts/crearTipoEntrada.js"></script>
<?php } else {	?>
	<div class="main">
		<h1>No tienes permisos para acceder a este contenido</h1>
	</div>
	</div>
<?php }?>
<?php include("footer.html") ?>