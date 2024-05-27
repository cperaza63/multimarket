<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	 
	use app\controllers\bancoController;

	if(isset($_POST['tab'])){
		$_SESSION['tab'] = $_POST['tab']; 
	}
	
	if(isset($_POST['modulo_banco'])){

		
		$insCategory = new bancoController();

		if($_POST['modulo_banco']=="registrar"){
			echo $insCategory->registrarBancoControlador();
		}

		if($_POST['modulo_banco']=="eliminar"){
			echo $insCategory->eliminarBancoControlador();
		}

		if($_POST['modulo_banco']=="actualizar"){
			echo $insCategory->actualizarBancoControlador();
		}
		
		if($_POST['modulo_banco']=="actualizarFoto"){
			echo $insCategory->actualizarFotoBancoControlador();
		}
		
	}else{
		echo "error";
		//session_destroy();
		//header("Location: ".APP_URL."login/");
	}