<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	 
	use app\controllers\despachadorController;

	if(isset($_POST['tab'])){
		$_SESSION['tab'] = $_POST['tab']; 
	}
	
	if(isset($_POST['modulo_despachador'])){

		$insDespachador = new despachadorController();

		if($_POST['modulo_despachador']=="registrar"){
			echo $insDespachador->registrarDespachadorControlador();
		}

		if($_POST['modulo_despachador']=="eliminar"){
			echo $insDespachador->eliminarDespachadorControlador();
		}

		if($_POST['modulo_despachador']=="actualizarFoto"){
			echo $insDespachador->actualizarFotoDespachadorControlador();
		}
		
		if($_POST['modulo_despachador']=="actualizar"){
			echo $insDespachador->actualizarDespachadorControlador();
		}
		if($_POST['modulo_despachador']=="actualizarMasInformacion"){
			echo $insDespachador->actualizarMasInformacionControlador();
		}
		if($_POST['modulo_despachador']=="actualizarZonaHoraria"){
			echo $insDespachador->actualizarZonaHorariaControlador();
		}
		if($_POST['modulo_despachador']=="actualizarUbicacion"){
			echo $insDespachador->actualizarUbicacionControlador();
		}
		if($_POST['modulo_despachador']=="eliminarFoto"){
			echo $insDespachador->eliminarFotoDespachadorControlador();
		}

		if($_POST['modulo_despachador']=="actualizarFotoMasa"){
			echo $insDespachador->actualizarFotoMasaControlador();
		}
		
	}else{
		echo "fin de sesion despachadores";
		//session_destroy();
		//header("Location: ".APP_URL."login/");
	}