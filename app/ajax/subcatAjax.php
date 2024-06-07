<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	 
	use app\controllers\subcatController;

	if(isset($_POST['tab'])){
		$_SESSION['tab'] = $_POST['tab']; 
	}
	
	if(isset($_POST['modulo_subcat'])){

		
		$insCategory = new subcatController();

		if($_POST['modulo_subcat']=="registrar"){
			echo $insCategory->registrarSubcatControlador();
		}

		if($_POST['modulo_subcat']=="eliminar"){
			echo $insCategory->eliminarSubcatControlador();
		}

		if($_POST['modulo_subcat']=="actualizar"){
			echo $insCategory->actualizarSubcatControlador();
		}
		
		if($_POST['modulo_subcat']=="actualizarFoto"){
			echo $insCategory->actualizarFotoSubcatControlador();
		}
		
	}else{
		echo "error ajax subcat";
		//session_destroy();
		//header("Location: ".APP_URL."login/");
	}