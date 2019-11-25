<!--problema con conexiones lentas-->
<?php

echo '<nav id="navG">';
include_once 'bd/tipoEventoDAO.php';
include_once 'class/tipoEvento.php';
include_once 'bd/eventoDAO.php';

date_default_timezone_set('Europe/Madrid');
$arr = TipoEventoDAO::getTiposEvento();
echo '<h2 class="c1">Navegación</h2>';
for($i = 0; $i < sizeof($arr); $i++){
    echo '<h3 class="c2"><a href="search.php?t='.$arr[$i]->getIdTipo().'">'.$arr[$i]->getNombreTipo().'</a></h3><div class="linea"></div><ul class="lista">';
    $eventos = EventoDAO::getEventosByTipo($arr[$i]->getIdTipo());
    /*$j = 0;
    if (sizeof($eventos)>0) {
        while (strtotime($eventos[$j]->getFecha())<strtotime(date("Y/m/d"))) {
        	$j++;
        }
    }*/
    for($j = 0, $k = 0; $j < sizeof($eventos) && $k < 4; $j++){
    	if(strtotime($eventos[$j]->getFecha())>=strtotime(date("Y/m/d"))) {
    		echo'<li class="c3"><a href="evento.php?eid='.$eventos[$j]->getIdEvento().'">'.$eventos[$j]->getNombreEvento().'</a></li>';
    		$k++;
    	}
    }
    if ($k == 0)
    	echo'<li class="c3">No hay eventos futuros.</li>';
    echo '</ul>';
}
echo '</nav>';

?>
