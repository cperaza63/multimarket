<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	 
	use app\controllers\productoController;

	if(isset($_POST['tab'])){
		$_SESSION['tab'] = $_POST['tab']; 
	}
	
	if(isset($_POST['modulo_producto'])){

		$insCompany = new productoController();

		if($_POST['modulo_producto']=="registrar"){
			echo $insCompany->registrarProductoControlador();
		}

		if($_POST['modulo_producto']=="eliminar"){
			echo $insCompany->eliminarProductoControlador();
		}

		if($_POST['modulo_producto']=="actualizarFoto"){
			echo $insCompany->actualizarFotoProductoControlador();
		}
		
		if($_POST['modulo_producto']=="actualizar"){
			echo $insCompany->actualizarProductoControlador();
		}

		if($_POST['modulo_producto']=="actualizarMasInformacion"){
			echo $insCompany->actualizarMasInformacionControlador();
		}
		if($_POST['modulo_producto']=="actualizarZonaHoraria"){
			echo $insCompany->actualizarZonaHorariaControlador();
		}
		if($_POST['modulo_producto']=="actualizarMarket"){
			echo $insCompany->actualizarMarketControlador();
		}
		if($_POST['modulo_producto']=="actualizarUbicacion"){
			echo $insCompany->actualizarUbicacionControlador();
		}
		if($_POST['modulo_producto']=="eliminarFoto"){
			echo $insCompany->eliminarFotoProductoControlador();
		}

		if($_POST['modulo_producto']=="actualizarFotoMasa"){
			echo $insCompany->actualizarFotoMasaControlador();
		}
		
	}else{
		//echo "fin de sesion";
		session_destroy();
		header("Location: ".APP_URL."login/");
	}