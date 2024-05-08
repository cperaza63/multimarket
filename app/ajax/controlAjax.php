<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	 
	use app\controllers\controlController;

	if(isset($_POST['modulo_control'])){

		
		$insControl = new controlController();

		if($_POST['modulo_control']=="registrar"){
			echo $insControl->registrarControlControlador();
		}

		if($_POST['modulo_control']=="eliminar"){
			echo $insControl->eliminarControlControlador();
		}

		if($_POST['modulo_control']=="actualizar"){
			echo $insControl->actualizarControlControlador();
		}
		
		if($_POST['modulo_control']=="actualizarFoto"){
			echo $insControl->actualizarFotoControlControlador();
		}

		if($_POST['modulo_control']=="eliminarFoto"){
			echo $insControl->eliminarFotoControlControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}