<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	 
	use app\controllers\proveedorController;

	if(isset($_POST['tab'])){
		$_SESSION['tab'] = $_POST['tab']; 
	}
	
	if(isset($_POST['modulo_proveedor'])){

		$insProveedor = new proveedorController();

		if($_POST['modulo_proveedor']=="registrar"){
			echo $insProveedor->registrarProveedorControlador();
		}

		if($_POST['modulo_proveedor']=="eliminar"){
			echo $insProveedor->eliminarProveedorControlador();
		}

		if($_POST['modulo_proveedor']=="actualizarFoto"){
			echo $insProveedor->actualizarFotoProveedorControlador();
		}
		
		if($_POST['modulo_proveedor']=="actualizar"){
			echo $insProveedor->actualizarProveedorControlador();
		}
		if($_POST['modulo_proveedor']=="actualizarMasInformacion"){
			echo $insProveedor->actualizarMasInformacionControlador();
		}
		if($_POST['modulo_proveedor']=="actualizarZonaHoraria"){
			echo $insProveedor->actualizarZonaHorariaControlador();
		}
		if($_POST['modulo_proveedor']=="actualizarUbicacion"){
			echo $insProveedor->actualizarUbicacionControlador();
		}
		if($_POST['modulo_proveedor']=="eliminarFoto"){
			echo $insProveedor->eliminarFotoProveedorControlador();
		}

		if($_POST['modulo_proveedor']=="actualizarFotoMasa"){
			echo $insProveedor->actualizarFotoMasaControlador();
		}
		
	}else{
		echo "fin de sesion";
		//session_destroy();
		//header("Location: ".APP_URL."login/");
	}