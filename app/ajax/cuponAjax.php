<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	 
	use app\controllers\cuponController;

	if(isset($_POST['tab'])){
		$_SESSION['tab'] = $_POST['tab']; 
	}
	
	if(isset($_POST['modulo_cupon'])){

		
		$insCategory = new  cuponController();

		if($_POST['modulo_cupon']=="registrar"){
			echo $insCategory->registrarCuponControlador();
		}

		if($_POST['modulo_cupon']=="eliminar"){
			echo $insCategory->eliminarCuponControlador();
		}

		if($_POST['modulo_cupon']=="actualizar"){
			echo $insCategory->actualizarCuponControlador();
		}
		
		if($_POST['modulo_cupon']=="actualizarFoto"){
			echo $insCategory->actualizarFotoCuponControlador();
		}
		
	}else{
		echo "error ajax marca";
		//session_destroy();
		//header("Location: ".APP_URL."login/");
	}