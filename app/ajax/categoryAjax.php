<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	 
	use app\controllers\categoryController;

	if(isset($_POST['tab'])){
		$_SESSION['tab'] = $_POST['tab']; 
	}
	
	if(isset($_POST['modulo_category'])){

		
		$insCategory = new categoryController();

		if($_POST['modulo_category']=="registrar"){
			echo $insCategory->registrarCategoryControlador();
		}

		if($_POST['modulo_category']=="eliminar"){
			echo $insCategory->eliminarCategoryControlador();
		}

		if($_POST['modulo_category']=="actualizar"){
			echo $insCategory->actualizarCategoryControlador();
		}
		
		if($_POST['modulo_category']=="actualizarFoto"){
			echo $insCategory->actualizarFotoCategoryControlador();
		}
		
	}else{
		echo "error Ajax categoria";
		//session_destroy();
		//header("Location: ".APP_URL."login/");
	}