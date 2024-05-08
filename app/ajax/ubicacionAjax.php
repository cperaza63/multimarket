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

		if($_POST['modulo_ubicacion']=="actualizar"){
			echo $insControl->actualizarUbicacionControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}