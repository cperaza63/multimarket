<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	 
	use app\controllers\ubicacionController;

	if(isset($_POST['modulo_ubicacion'])){

		
		$insControl = new ubicacionController();

		if($_POST['modulo_ubicacion']=="registrar"){
			echo $insControl->registrarUbicacionControlador();
		}

		if($_POST['modulo_ubicacion']=="eliminar"){
			echo $insControl->eliminarUbicacionControlador();
		}

		if($_POST['modulo_ubicacion']=="actualizarFoto"){
			echo $insControl->actualizarFotoUbicacionControlador();
		}

		if($_POST['modulo_ubicacion']=="actualizarClave"){
			echo $insControl->actualizarPasswordControlador();
		}
		
		if($_POST['modulo_ubicacion']=="actualizar"){
			echo $insControl->actualizarUbicacionControlador();
		}

		if($_POST['modulo_ubicacion']=="eliminarFoto"){
			echo $insControl->eliminarFotoUbicacionControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}