<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	 
	use app\controllers\companyController;

	if(isset($_POST['tab'])){
		$_SESSION['tab'] = $_POST['tab']; 
	}
	
	if(isset($_POST['modulo_company'])){

		$insCompany = new companyController();

		if($_POST['modulo_company']=="registrar"){
			echo $insCompany->registrarCompanyControlador();
		}

		if($_POST['modulo_company']=="eliminar"){
			echo $insCompany->eliminarCompanyControlador();
		}

		if($_POST['modulo_company']=="actualizarFoto"){
			echo $insCompany->actualizarFotoCompanyControlador();
		}
		
		if($_POST['modulo_company']=="actualizar"){
			echo $insCompany->actualizarCompanyControlador();
		}

		if($_POST['modulo_company']=="actualizarMasInformacion"){
			echo $insCompany->actualizarMasInformacionControlador();
		}
		if($_POST['modulo_company']=="actualizarZonaHoraria"){
			echo $insCompany->actualizarZonaHorariaControlador();
		}
		if($_POST['modulo_company']=="actualizarMarket"){
			echo $insCompany->actualizarMarketControlador();
		}
		if($_POST['modulo_company']=="actualizarUbicacion"){
			echo $insCompany->actualizarUbicacionControlador();
		}
		if($_POST['modulo_company']=="eliminarFoto"){
			echo $insCompany->eliminarFotoCompanyControlador();
		}

		if($_POST['modulo_company']=="actualizarFotoMasa"){
			echo $insCompany->actualizarFotoMasaControlador();
		}
		
	}else{
		echo "fin de sesion company";
		session_destroy();
		header("Location: ".APP_URL."login/");
	}