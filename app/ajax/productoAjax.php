<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	use app\controllers\productController;
	if(isset($_POST['tab'])){
		$_SESSION['tab'] = $_POST['tab']; 
	}
	if(isset($_POST['modulo_product'])){

		$insProducto = new productController();
		if($_POST['modulo_product']=="registrar"){
			echo $insProducto->registrarProductControlador();
		}
		if($_POST['modulo_product']=="eliminar"){
			echo $insProducto->eliminarProductControlador();
		}
		if($_POST['modulo_product']=="actualizarFoto"){
			echo $insProducto->actualizarFotoProductControlador();
		}
		if($_POST['modulo_product']=="actualizar"){
			echo $insProducto->actualizarProductControlador();
		}
		if($_POST['modulo_product']=="actualizarMasInformacion"){
			echo $insProducto->actualizarMasInformacionControlador();
		}
		if($_POST['modulo_product']=="actualizarZonaHoraria"){
			echo $insProducto->actualizarZonaHorariaControlador();
		}
		if($_POST['modulo_product']=="actualizarMarket"){
			echo $insProducto->actualizarProductControlador();
		}
		if($_POST['modulo_product']=="actualizarUbicacion"){
			echo $insProducto->actualizarUbicacionControlador();
		}
		if($_POST['modulo_product']=="eliminarFoto"){
			echo $insProducto->eliminarFotoProductControlador();
		}
		if($_POST['modulo_product']=="actualizarFotoMasa"){
			echo $insProducto->actualizarFotoMasaControlador();
		}
	}else{
		//echo "fin de sesion";
		session_destroy();
		header("Location: ".APP_URL."login/");
	}