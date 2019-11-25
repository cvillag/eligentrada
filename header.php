<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>ELIGENTRADA</title>
		<meta charset="utf-8"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name=viewport content="width=device-width, initial-scale=1">
		<meta name="author" content="Nicolas Bueno Mora" />
		<meta name="author" content="Víctor Diges Teijeira" />
		<meta name="author" content="Borja Salazar Rey" />
		<meta name="author" content="Enrique Ugedo Egido" />
		<meta name="author" content="Carlos Villarroel González" />	
		<!--Hojas de Estilo-->
		<link rel="stylesheet" type="text/css" href="css/reset.css">	
		<!--<link rel="stylesheet" type="text/css" href="css/interfaz.css"> -->
		<link rel="stylesheet" type="text/css" href="css/eventos.css">
		<link rel="stylesheet" type="text/css" href="css/eligentrada.css">
		<link rel="stylesheet" type="text/css" href="css/nav.css">
		<link rel="stylesheet" type="text/css" href="css/rejilla.css">
		<link rel="stylesheet" type="text/css" href="css/formularios.css">
		<link rel="stylesheet" type="text/css" href="css/user_admin.css">
		
		<link rel="icon" href="img/logo-small.png">
		
		<link rel="stylesheet" type="text/css" href="css/grid.css">
		<link rel="stylesheet" type="text/css" href="css/estiloGrid.css">
		<link href='http://fonts.googleapis.com/css?family=Syncopate' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	</head>

	<body>
		<header>
			<a href="index.php"><img id="logo" src="img/logo.png" alt="Eligentrada"/></a>
				<?php
				if(!isset($_SESSION['nombre'])){
					echo '
						<div id="login">
							<button id="botonLogin" class="boton" onclick="toggleLoginForm()">Login</button>
						</div>';
				}else{
					echo '
					<div id="login">
						<button id="botonLogin" class="boton" onclick="toggleLoginForm()">Bienvenido '.$_SESSION["nombre"].'</button>
					</div>';
				}?>
		</header>
		<div id="login_form"><?php include 'login.php';?></div>
		<script type="text/javascript" src="scripts/loginScript.js"></script>
