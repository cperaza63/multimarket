<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	 
	use app\controllers\clienteController;

	if(isset($_POST['tab'])){
		$_SESSION['tab'] = $_POST['tab']; 
	}
	
	if(isset($_POST['modulo_cliente'])){

		$insCliente = new clienteController();

		if($_POST['modulo_cliente']=="registrar"){
			echo $insCliente->registrarClienteControlador();
		}

		if($_POST['modulo_cliente']=="eliminar"){
			echo $insCliente->eliminarClienteControlador();
		}

		if($_POST['modulo_cliente']=="actualizarFoto"){
			echo $insCliente->actualizarFotoClienteControlador();
		}
		
		if($_POST['modulo_cliente']=="actualizar"){
			echo $insCliente->actualizarClienteControlador();
		}
		if($_POST['modulo_cliente']=="actualizarMasInformacion"){
			echo $insCliente->actualizarMasInformacionControlador();
		}
		if($_POST['modulo_cliente']=="actualizarZonaHoraria"){
			echo $insCliente->actualizarZonaHorariaControlador();
		}
		if($_POST['modulo_cliente']=="actualizarUbicacion"){
			echo $insCliente->actualizarUbicacionControlador();
		}
		if($_POST['modulo_cliente']=="eliminarFoto"){
			echo $insCliente->eliminarFotoClienteControlador();
		}

		if($_POST['modulo_cliente']=="actualizarFotoMasa"){
			echo $insCliente->actualizarFotoMasaControlador();
		}
		
	}else{
		echo "fin de sesion cliente";
		//session_destroy();
		//header("Location: ".APP_URL."login/");
	}