<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	 
	use app\controllers\modeloController;

	if(isset($_POST['tab'])){
		$_SESSION['tab'] = $_POST['tab']; 
	}
	
	if(isset($_POST['modulo_modelo'])){

		
		$insCategory = new modeloController();

		if($_POST['modulo_subcat']=="registrar"){
			echo $insCategory->registrarModeloControlador();
		}

		if($_POST['modulo_subcat']=="eliminar"){
			echo $insCategory->eliminarModeloControlador();
		}

		if($_POST['modulo_subcat']=="actualizar"){
			echo $insCategory->actualizarModeloControlador();
		}
		
		if($_POST['modulo_subcat']=="actualizarFoto"){
			echo $insCategory->actualizarFotoModeloControlador();
		}
		
	}else{
		echo "error";
		//session_destroy();
		//header("Location: ".APP_URL."login/");
	}