<?php
	include 'bd/usuarioDAO.php';
	include 'bd/eventoDAO.php';
	include 'bd/loginDAO.php';
	include 'bd/tipoEventoDAO.php';
	include 'bd/tipoEntradaEventoDAO.php';
	include 'bd/tipoEntradaDAO.php';
	include 'bd/retailDAO.php';

	session_start();

	if(isset($_REQUEST["do"])){
		$accion = htmlspecialchars(trim(strip_tags($_REQUEST["do"])));
		switch ($accion){
			case 'actualizaDatosUsuario' :
				if(isset($_REQUEST['postData'])) echo actualizaDatosUsuario($_REQUEST['postData']); 
				break;
			case 'getDatosPropios' :
				header('Content-type: application/json');
				echo getDatosPropios();
				break;
			case 'checkPassword' :
				header('Content-type: application/json');
				if(isset($_REQUEST['pass'])) echo checkPassword($_REQUEST['pass']);
				break;
			case 'registroUsuario' :
				if(isset($_REQUEST['postData'])) echo registroUsuario($_REQUEST['postData']); 
				break;
			case 'registroPromotor' :
				if(isset($_REQUEST['postData'])) echo registroPromotor($_REQUEST['postData']); 
				break;
			case 'crearEvento' :
				if(isset($_REQUEST['postData'])) echo crearEvento($_REQUEST['postData']); 
				break;
			case 'crearTipoEvento' :
				if(isset($_REQUEST['postData'])) echo crearTipoEvento($_REQUEST['postData']); 
				break;
			case 'editarTipoEvento' :
				if(isset($_REQUEST['postData'])) echo editarTipoEvento($_REQUEST['postData']); 
				break;
			case 'crearTipoEntrada' :
				if(isset($_REQUEST['postData'])) echo crearTipoEntrada($_REQUEST['postData']); 
				break;
			case 'editarTipoEntrada' :
				if(isset($_REQUEST['postData'])) echo editarTipoEntrada($_REQUEST['postData']); 
				break;
			case 'añadirTipoEntradaEvento' :
				if(isset($_REQUEST['postData'])) echo crearTipoEntradaEvento($_REQUEST['postData']); 
				break;
			case 'userAdminSigPag':
				if(isset($_REQUEST['postData'])) echo siguientePaginaUsuarios($_REQUEST['postData']);
				break;
			case 'buscarUsuario':
				if(isset($_REQUEST['postData'])) echo buscaUsuario($_REQUEST['postData']);
				break; 
			case 'buyTickets':
				if(isset($_REQUEST['postData'])) echo buyTickets($_REQUEST['postData']);
				break;
			case 'editarEvento':
				if(isset($_REQUEST['postData'])) echo editarEvento($_REQUEST['postData']);
				break;
			default:
				header('Location: index.php');
		}
	}

	function actualizaDatosUsuario($postData){
		$datos = json_decode($postData);
		if(!isset($datos->nombre)||!isset($datos->correo)) return false;
		if(isset($_SESSION['id'])){
			$id=0;
			if(isset($_SESSION['rol'])&&$_SESSION['rol']==4){
				
				$id = htmlspecialchars(trim(strip_tags($datos->id)));
			}
			else{
				$id = ($_SESSION['id']);
			}
			$usuario = UsuarioDAO::getUserById($id);
			$usuario->setNombre(htmlspecialchars(trim(strip_tags($datos->nombre))));
			$usuario->setApellidos(htmlspecialchars(trim(strip_tags($datos->apellidos))));
			if(isset($datos->dni)) $usuario->setDni(htmlspecialchars(trim(strip_tags($datos->dni))));
			if(isset($datos->cif)) $usuario->setCif(htmlspecialchars(trim(strip_tags($datos->cif))));
			$usuario->setCorreo(htmlspecialchars(trim(strip_tags($datos->correo))));
			$usuario->setDireccion(htmlspecialchars(trim(strip_tags($datos->direccion))));
			$usuario->setTelefono(htmlspecialchars(trim(strip_tags($datos->telefono))));
			if(isset($datos->oldPass)&&isset($datos->newPass)){
				$valido = json_decode(checkPassword(htmlspecialchars(trim(strip_tags($datos->oldPass)))));
				$salt = rand(0, 1000000);
				$password = sha1(htmlspecialchars(trim(strip_tags($datos->newPass))).$salt);
				if($valido->login){ 
					$usuario->setPass($password);
					
					//crear salt
					$retail = new  retail($id, $salt);
					retailDAO::insertRetail($retail);
					
					//modificar
					//$retail = retailDAO::getRetailById($usuario->getIdUsuario());
					//$retail->setSalt($salt);
					//retailDAO::updateRetail($retail);
					
				}
				
			}
			usuarioDAO::updateUser($usuario);
			
			
			return true;			
		} else return null;
	}

	function getDatosPropios(){
		if(isset($_SESSION['id'])){
			$user = UsuarioDAO::getUserById($_SESSION['id']);
			return $user->toJSON();
		} else return null;
	}

	function checkPassword($pass){
		if(isset($_SESSION['id'])){
			$user = UsuarioDAO::getUserById($_SESSION['id']);
			$intentos = loginDAO::checkIntentos();
			if($intentos < 3){
				if($pass===$user->getPass()){
					loginDAO::borraIntentos();
					return json_encode(array('login'=> true, 'intentos'=>0));
				} else {
					loginDAO::logIntento();
					return json_encode(array('login'=> false, 'intentos'=>$intentos+1));
				}
			} else return json_encode(array('login'=> false, 'intentos'=>$intentos));
		} else return null;
	}

	function registroUsuario($postData){
		//ToDo: comprobar que usuario existe. Devolver info en JSON
		$datos = json_decode($postData);

		if(!is_null(usuarioDAO::getUserByCorreo($datos->correo))) return json_encode(array('err'=> 'userExists'));
		if(!isset($datos->nombre)||!isset($datos->correo)||!isset($datos->password)||!isset($datos->passwordCheck)) return false;
		if($datos->password == $datos->passwordCheck){
			$nombre = htmlspecialchars(trim(strip_tags($datos->nombre)));
			$apellidos = htmlspecialchars(trim(strip_tags($datos->apellidos)));
			$correo = htmlspecialchars(trim(strip_tags($datos->correo)));
			$salt = rand(0, 1000000);
			$password = sha1(htmlspecialchars(trim(strip_tags($datos->password))).$salt);
			$dni = htmlspecialchars(trim(strip_tags($datos->dni)));
			$cif = null;
			$direccion = htmlspecialchars(trim(strip_tags($datos->direccion)));
			$telefono = htmlspecialchars(trim(strip_tags($datos->telefono)));
			$usuario = new usuario(null, $nombre, $apellidos, $correo, $password, $dni, $cif, $direccion, $telefono, 6);

			usuarioDAO::insertUser($usuario);
			
			$usr = usuarioDAO::getUserByCorreo($datos->correo);
			
			$retail = new retail($usr->getIdUsuario(), $salt);
			
			retailDAO::insertRetail($retail);
			
			return json_encode(array('err'=> 0));
		} else return json_encode(array('err'=> 'passNotCheck'));
	}

	function registroPromotor($postData){
		//ToDo: comprobar que usuario existe. Devolver info en JSON
		$datos = json_decode($postData);

		if(!is_null(usuarioDAO::getUserByCorreo($datos->correo))) return json_encode(array('err'=> 'userExists'));
		if(!isset($datos->nombre)||!isset($datos->correo)||!isset($datos->pass)||!isset($datos->passCheck)) return false;
		if($datos->pass == $datos->passCheck){
			$nombre = htmlspecialchars(trim(strip_tags($datos->nombre)));
			$apellidos = null;
			$correo = htmlspecialchars(trim(strip_tags($datos->correo)));
			$password = htmlspecialchars(trim(strip_tags($datos->pass)));
			$dni = null;
			$cif = htmlspecialchars(trim(strip_tags($datos->cif)));
			$direccion = htmlspecialchars(trim(strip_tags($datos->direccion)));
			$telefono = htmlspecialchars(trim(strip_tags($datos->telefono)));
			$usuario = new usuario(null, $nombre, $apellidos, $correo, $password, $dni, $cif, $direccion, $telefono, 5);

			usuarioDAO::insertUser($usuario);
			return json_encode(array('err'=> 0));
		} else return json_encode(array('err'=> 'passNotCheck'));
	}

	function crearEvento($postData){
		if(isset($_SESSION['rol'])&&$_SESSION['rol']==5){
			//ToDo: comprobar que usuario existe. Devolver info en JSON
			$datos = json_decode($postData);
			$nombre = htmlspecialchars(trim(strip_tags($datos->nombre)));
			$lugar = htmlspecialchars(trim(strip_tags($datos->lugar)));
			$fecha = htmlspecialchars(trim(strip_tags($datos->fecha)));
			$hora = htmlspecialchars(trim(strip_tags($datos->hora)));
			$descripcion = htmlspecialchars(trim(strip_tags($datos->descripcion)));
			$rutaImagen = htmlspecialchars(trim(strip_tags($datos->imagen)));
			$ubicacionLatLong = htmlspecialchars(trim(strip_tags($datos->ubicacionLatLong)));
			$tipo = null;
			$teventos = tipoEventoDAO::getTiposEvento();
			foreach ($teventos as $tevento) {
				if ($tevento->getNombreTipo() == $datos->tipo) {
					$tipo = $tevento->getIdTipo();
				}
			}
			$prioridad = 4;
			$fechaCreacion = null;
			$idPromotor = $_SESSION['id'];

			$evento = new evento(null, $nombre, $lugar, $fecha, $hora, $descripcion, $tipo, $prioridad, $fechaCreacion, $idPromotor, $rutaImagen, $ubicacionLatLong);

			eventoDAO::insertEvento($evento);
			return json_encode(array('err'=> 0));
		}
	}
	
	function crearTipoEvento($postData){
		if(isset($_SESSION['rol'])&&$_SESSION['rol']==4){
			//ToDo: comprobar que usuario existe. Devolver info en JSON
			$datos = json_decode($postData);
			$nombre = htmlspecialchars(trim(strip_tags($datos->nombreTipo)));

			$tevento = new tipoEvento(null, $nombre);

			tipoEventoDAO::insertTipoEvento($tevento);
			return json_encode(array('err'=> 0));
		}
	}

	function editarTipoEvento($postData){
		if(isset($_SESSION['rol'])&&$_SESSION['rol']==4){
			//ToDo: comprobar que usuario existe. Devolver info en JSON
			$datos = json_decode($postData);
			$nombre = htmlspecialchars(trim(strip_tags($datos->tipo)));
			$idTipo = 1;
			$teventos = tipoEventoDAO::getTiposEvento();
			foreach($teventos as $tevento){
				if ($tevento->getNombreTipo() == $datos->tipoOrig){
					$idTipo = $tevento->getIdTipo();
				}
			}
			$tipoEvento = new tipoEvento($idTipo, $nombre);

			tipoEventoDAO::editarTipoEvento($tipoEvento);
			return json_encode(array('err'=> 0));
		}
	}
	function crearTipoEntrada($postData){
		if(isset($_SESSION['rol'])&&$_SESSION['rol']==4){
			//ToDo: comprobar que usuario existe. Devolver info en JSON
			$datos = json_decode($postData);
			$nombre = htmlspecialchars(trim(strip_tags($datos->nombreTipo)));

			$tentrada = new tipoEntrada(null, $nombre);

			tipoEntradaDAO::insertTipoEntrada($tentrada);
			return json_encode(array('err'=> 0));
		}
	}

	function editarTipoEntrada($postData){
		if(isset($_SESSION['rol'])&&$_SESSION['rol']==4){
			//ToDo: comprobar que usuario existe. Devolver info en JSON
			$datos = json_decode($postData);
			$nombre = htmlspecialchars(trim(strip_tags($datos->tipo)));
			$idTipo = 1;
			$tentradas = tipoEntradaDAO::getTiposEntrada();
			foreach($tentradas as $tentrada){
				if ($tentrada->getNombre() == $datos->tipoOrig){
					$idTipo = $tentrada->getIdTipo();
				}
			}
			$tipoEntrada = new tipoEntrada($idTipo, $nombre);

			tipoEntradaDAO::editarTipoEntrada($tipoEntrada);
			return json_encode(array('err'=> 0));
		}
	}
	
	function crearTipoEntradaEvento($postData){
		if(isset($_SESSION['rol'])&&$_SESSION['rol']==5){
			$datos = json_decode($postData);
			$idTipo = 3;
			$tentradas = tipoEntradaDAO::getTiposEntrada();
			foreach($tentradas as $tentrada){
				if ($tentrada->getNombre() == $datos->tipoEn){
					$idTipo = $tentrada->getIdTipo();
				}
			}

			$evento = eventoDAO::getEventoByName($datos->nombre);
			$idEvento = $evento->getIdEvento();

			$nombreEntrada = htmlspecialchars(trim(strip_tags($datos->nombreEntrada)));
			$precio = htmlspecialchars(trim(strip_tags($datos->precio)));
			$cantidad = htmlspecialchars(trim(strip_tags($datos->cantidad)));

			$tipoEntradaEvento = new tipoEntradaEvento($idTipo, $idEvento, $nombreEntrada, $precio, $cantidad);
			tipoEntradaEventoDAO::insertTipoEntradaEvento($tipoEntradaEvento);

			return json_encode(array('err'=> 0));
		}
	}
	
	function editarEvento($postData){
		if(isset($_SESSION['rol'])&&$_SESSION['rol']==5){
			//ToDo: comprobar que usuario existe. Devolver info en JSON
			$datos = json_decode($postData);
			$idEvento = htmlspecialchars(trim(strip_tags($datos->idEvento)));
			$eventoOrig = eventoDAO::getEventoById($idEvento);

			if($eventoOrig->getIdPromotor() == $_SESSION['id']){
				$nombre = htmlspecialchars(trim(strip_tags($datos->nombre)));
				$lugar = htmlspecialchars(trim(strip_tags($datos->lugar)));
				$fecha = htmlspecialchars(trim(strip_tags($datos->fecha)));
				$hora = htmlspecialchars(trim(strip_tags($datos->hora)));
				$descripcion = htmlspecialchars(trim(strip_tags($datos->descripcion)));
				$rutaImagen = htmlspecialchars(trim(strip_tags($datos->imagen)));
				$ubicacionLatLong = htmlspecialchars(trim(strip_tags($datos->ubicacionLatLong)));
				$tipo = null;

				$teventos = tipoEventoDAO::getTiposEvento();
				foreach ($teventos as $tevento) {
					if ($tevento->getNombreTipo() == $datos->tipo) {
						$tipo = $tevento->getIdTipo();
					}
				}

				$entradas = $datos->entradas;
				$tentradas = tipoEntradaDAO::getTiposEntrada();
				foreach ($entradas as $entrada){
					if(property_exists($entrada, 'tipoEn')){
						$idTipo = 0;
						foreach($tentradas as $tentrada){ 
							if ($tentrada->getNombre() == $entrada->tipoEn){
								$idTipo = $tentrada->getIdTipo();
							}
						}
						$nombreEntrada = htmlspecialchars(trim(strip_tags($entrada->nombreEntrada)));
						$precio = htmlspecialchars(trim(strip_tags($entrada->precio)));
						$cantidad = htmlspecialchars(trim(strip_tags($entrada->cantidad)));

						$tipoEntradaEvento = new tipoEntradaEvento($idTipo, $idEvento, $nombreEntrada, $precio, $cantidad);
						tipoEntradaEventoDAO::updateTipoEntradaEvento($tipoEntradaEvento);
						//ToDo: eliminacion de entradas
					}
				}

				$prioridad = $eventoOrig->getPrioridad();
				$fechaCreacion = $eventoOrig->getFechaCreacion();
				$idPromotor = $_SESSION['id'];

				$evento = new evento($idEvento, $nombre, $lugar, $fecha, $hora, $descripcion, $tipo, $prioridad, $fechaCreacion, $idPromotor, $rutaImagen, $ubicacionLatLong);

				eventoDAO::editEvento($evento);
				return json_encode(array('err'=> 0));
			} else {
				return json_encode(array('err'=>'NotOwner'));
			}
		} else return json_encode(array('err'=>'NoPermissions'));
	}

	function buscaUsuario($postData){
		//TODO: Dividir búsquedas de usuarios en búsquedas de texto con like "contiene" y exactas para las numéricas.
		if(isset($_SESSION['rol'])&&$_SESSION['rol']==4){
			$datos = json_decode($postData);
			$nombre = htmlspecialchars(trim(strip_tags($datos->nombre)));
			$apellidos = htmlspecialchars(trim(strip_tags($datos->apellidos)));
			$dni = htmlspecialchars(trim(strip_tags($datos->dni)));
			$cif = htmlspecialchars(trim(strip_tags($datos->cif)));
			$telefono = htmlspecialchars(trim(strip_tags($datos->telefono)));
			$correo = htmlspecialchars(trim(strip_tags($datos->correo)));
			$tipo = htmlspecialchars(trim(strip_tags($datos->tipo)));
			$pag = htmlspecialchars(trim(strip_tags($datos->pag)));
			$tamPag = htmlspecialchars(trim(strip_tags($datos->tamPag)));
			
			$usuarios = UsuarioDAO::findUsers($nombre, $apellidos, $dni, $cif, $telefono, $correo, $tipo, $pag*$tamPag, $tamPag);
			$num = UsuarioDAO::tamBusqueda($nombre, $apellidos, $dni, $cif, $telefono, $correo, $tipo, $pag*$tamPag, $tamPag);
			error_log("Numero: " . $num);
			$jsondata = array(
					'error' => 0,
					'numUsers' => $num,
					'newPag'=>  $pag++
			);
			$cont=0;
			foreach ($usuarios as $us){
				$usarray = array();
				$usarray["nombre"] = $us->getNombre();
				$usarray["dni"] = $us->getDni();
				$usarray["apellidos"] = $us->getApellidos();
				$usarray["cif"] = $us->getCif();
				$usarray["correo"] = $us->getCorreo();
				$usarray["direccion"] = $us->getDireccion();
				$usarray["idUsuario"] = $us->getIdUsuario();
				$usarray["telefono"] = $us->getTelefono();
				$usarray["id"] = $us->getIdUsuario();
				$arrayUsers[] = $usarray;
			}
			$jsondata["users"] = $arrayUsers;
			return json_encode($jsondata);
		}
		else{
			return null;
		}
	}
	
	function siguientePaginaUsuarios($postData){
		if(isset($_SESSION['rol'])&&$_SESSION['rol']==4){
			$datos = json_decode($postData);
			$tipo = htmlspecialchars(trim(strip_tags($datos->tipo)));
			$pagina = htmlspecialchars(trim(strip_tags($datos->pagina)));
			$tamPagina = htmlspecialchars(trim(strip_tags($datos->tamPagina)));
			
			$usuarios = UsuarioDAO::getUsersByRol($tipo, $pagina*$tamPagina, $tamPagina);
			
			$jsondata = array(
					'error' => 0,
					'newPag' => $pagina,
					'numUsers' => count($usuarios),
			);
			$cont=0;
			foreach ($usuarios as $us){
				$usarray = array();
				$usarray["nombre"] = $us->getNombre();
				$usarray["dni"] = $us->getDni();
				$usarray["apellidos"] = $us->getApellidos();
				$usarray["cif"] = $us->getCif();
				$usarray["correo"] = $us->getCorreo();
				$usarray["direccion"] = $us->getDireccion();
				$usarray["idUsuario"] = $us->getIdUsuario();
				$usarray["telefono"] = $us->getTelefono();
				$usarray["id"] = $us->getIdUsuario();
				$arrayUsers[] = $usarray;
			}
			$jsondata["users"] = $arrayUsers;
			return json_encode($jsondata);
		}		
	}
	
	function buyTickets($postData){
		include 'bd/compraDAO.php';
		$datos = json_decode($postData);

		foreach ($datos as $entrada) {
			$cantidad = htmlspecialchars(trim(strip_tags($entrada->cantidad)));
			$idEntrada = htmlspecialchars(trim(strip_tags($entrada->tipoEn)));
			$idEvento = htmlspecialchars(trim(strip_tags($entrada->idEvento)));
			$disponibles = compraDAO::getEntradasDisponibles($idEvento, $idEntrada);

			if(!is_null($disponibles)&&($disponibles >= $cantidad)){
				if(isset($_SESSION['id'])){
					$compra = new Compra($idEntrada,$idEvento,$_SESSION['id'],NULL,$cantidad);
					compraDAO::insertCompra($compra);
					return json_encode(array('err'=> 0));
				} else {
					$compra = new Compra($idEntrada,$idEvento,NULL,NULL,$cantidad);
					compraDAO::insertCompra($compra);//idV == NULL?
					return json_encode(array('err'=> 0));
				}
			} else return json_encode(array('err'=> 'notEnough')); 
		}
	}

?>