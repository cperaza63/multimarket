<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\marketController;

	if(isset($_POST['modulo_market'])){

		$insMarket = new marketController();

		if($_POST['modulo_market']=="registrar"){
			echo $insMarket->registrarMarketControlador();
		}

		if($_POST['modulo_market']=="actualizar"){
			echo $insMarket->actualizarMarketControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}