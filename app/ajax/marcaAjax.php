<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	 
	use app\controllers\marcaController;

	if(isset($_POST['tab'])){
		$_SESSION['tab'] = $_POST['tab']; 
	}
	
	if(isset($_POST['modulo_marca'])){

		
		$insCategory = new marcaController();

		if($_POST['modulo_marca']=="registrar"){
			echo $insCategory->registrarMarcaControlador();
		}

		if($_POST['modulo_marca']=="eliminar"){
			echo $insCategory->eliminarMarcaControlador();
		}

		if($_POST['modulo_marca']=="actualizar"){
			echo $insCategory->actualizarMarcaControlador();
		}
		
		if($_POST['modulo_marca']=="actualizarFoto"){
			echo $insCategory->actualizarFotoMarcaControlador();
		}
		
	}else{
		echo "error ajax marca";
		//session_destroy();
		//header("Location: ".APP_URL."login/");
	}