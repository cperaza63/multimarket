<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	 
	use app\controllers\companyController;

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

		if($_POST['modulo_company']=="eliminarFoto"){
			echo $insCompany->eliminarFotoCompanyControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}