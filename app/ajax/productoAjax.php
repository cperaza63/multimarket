<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	use app\controllers\productController;
	if(isset($_POST['tab'])){
		$_SESSION['tab'] = $_POST['tab']; 
	}
	if(isset($_POST['modulo_producto'])){

		$insProducto = new productController();
		if($_POST['modulo_producto']=="registrar"){
			echo $insProducto->registrarProductoControlador();
		}
		if($_POST['modulo_producto']=="eliminar"){
			echo $insProducto->eliminarProductoControlador();
		}
		if($_POST['modulo_producto']=="actualizarFoto"){
			echo $insProducto->actualizarFotoProductoControlador();
		}
		if($_POST['modulo_producto']=="actualizar"){
			echo $insProducto->actualizarProductoControlador();
		}
		if($_POST['modulo_producto']=="actualizarMasInformacion"){
			echo $insProducto->actualizarMasInformacionControlador();
		}
		if($_POST['modulo_producto']=="actualizarZonaHoraria"){
			echo $insProducto->actualizarZonaHorariaControlador();
		}
		if($_POST['modulo_producto']=="actualizarMarket"){
			echo $insProducto->actualizarMarketControlador();
		}
		if($_POST['modulo_producto']=="actualizarUbicacion"){
			echo $insProducto->actualizarUbicacionControlador();
		}
		if($_POST['modulo_producto']=="eliminarFoto"){
			echo $insProducto->eliminarFotoProductoControlador();
		}
		if($_POST['modulo_producto']=="actualizarFotoMasa"){
			echo $insProducto->actualizarFotoMasaControlador();
		}
	}else{
		//echo "fin de sesion";
		session_destroy();
		header("Location: ".APP_URL."login/");
	}