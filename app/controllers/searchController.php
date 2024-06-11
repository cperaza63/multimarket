<?php

	namespace app\controllers;
	use app\models\mainModel;

	class searchController extends mainModel{

		/*----------  Controlador modulos de busquedas  ----------*/
		public function modulosBusquedaControlador($modulo){
			$listaModulos=[
				'despachadorList','categoryList', 'clienteList','proveedorList', 'bancoList', 'modeloList', 'cuponList', 'marcaList', 'companyList', 'userSearch', 'userList', 'controlSearch', 'controlList', 'ubicacionSearch', 'ubicacionList', 'cashierSearch', 'clientSearch', 'productList','subcategoriaList', 'saleSearch', 'subcatList'];
			if(in_array($modulo, $listaModulos)){
				return false;
			}else{
				return true;
			}
		}
		/*----------  Controlador iniciar busqueda  ----------*/
		public function iniciarBuscadorControlador(){

		    $url=$this->limpiarCadena($_POST['modulo_url']);
			$texto=$this->limpiarCadena($_POST['txt_buscador']);

			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento...",
					"icono"=>"error"
				];
			}
			if($texto==""){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Introduce un termino de busqueda",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}
			$_SESSION[$url]=$texto;
			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];
			return json_encode($alerta);
		}
		/*----------  Controlador eliminar busqueda  ----------*/
		public function eliminarBuscadorControlador(){
			$url=$this->limpiarCadena($_POST['modulo_url']);
			// return json_encode($url);
			// exit();
			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento..",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}
			unset($_SESSION[$url]);
			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];
			return json_encode($alerta);
		}

	}