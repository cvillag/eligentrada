<?php
	$conexion=mysql_connect ("192.210.137.109", "sw", "swmola") or die ("error conexion");
	mysql_select_db("sw",$conexion) or die ("error en seleccion");
	mysql_set_charset('utf8');
?>
