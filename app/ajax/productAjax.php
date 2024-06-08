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
		if($_POST['modulo_product']=="registrar" || $_POST['modulo_product']=="actualizar" ){
			echo $insProducto->registrarProductControlador();
		}
		if($_POST['modulo_product']=="eliminar"){
			echo $insProducto->eliminarProductControlador();
		}
		if($_POST['modulo_product']=="actualizarFoto"){
			echo $insProducto->actualizarFotoProductControlador();
		}
		if($_POST['modulo_product']=="actualizarMasInformacion"){
			echo $insProducto->actualizarMasInformacionControlador();
		}
		if($_POST['modulo_product']=="actualizarInteres"){
			echo $insProducto->actualizarInteresControlador();
		}
		if($_POST['modulo_product']=="excluirInteres"){
			echo $insProducto->excluirInteresControlador();
		}
		if($_POST['modulo_product']=="actualizarEtiquetas"){
			echo $insProducto->actualizarEtiquetasControlador();
		}
		if($_POST['modulo_product']=="excluirEtiquetas"){
			echo $insProducto->excluirEtiquetasControlador();
		}
		if($_POST['modulo_product']=="actualizarSubproducto"){
			echo $insProducto->actualizarSubproductoControlador();
		}
		if($_POST['modulo_product']=="detalleSubproducto"){
			echo $insProducto->actualizarDetalleSubproductoControlador();
		}
		if($_POST['modulo_product']=="actualizarDescuento"){
			echo $insProducto->actualizarDescuentoControlador();
		}
		if($_POST['modulo_product']=="detalleDescuento"){
			echo $insProducto->actualizarDetalleDescuentoControlador();
		}
		if($_POST['modulo_product']=="eliminarSubproducto"){
			echo $insProducto->eliminarSubproductoControlador();
		}
		if($_POST['modulo_product']=="eliminarFoto"){
			echo $insProducto->eliminarFotoProductControlador();
		}
		if($_POST['modulo_product']=="actualizarFotoMasa"){
			echo $insProducto->actualizarFotoMasaControlador();
		}
	}else{
		echo "fin de sesion product";
		//session_destroy();
		//header("Location: ".APP_URL."login/");
	}