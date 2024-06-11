<?php
	
	namespace app\models;

	class viewsModel{

		/*---------- Modelo obtener vista ----------*/
		protected function obtenerVistasModelo($vista){

			$listaBlanca=["dashboard","cashierNew","cashierList","cashierSearch","cashierUpdate",
			"userNew","userList","userUpdate", "userUpdateAdmin", "userSearch","userPhoto",
			"controlNew", "controlList", "controlUpdate", "controlSearch", "controlPhoto",
			"categoryNew","categoryList","categoryUpdate","categorySearch", "categoryPhoto",
			"marcaNew","marcaList","marcaUpdate","marcaSearch", "marcaPhoto",
			"subcatNew","subcatList","subcatUpdate","subcatSearch", "subcatPhoto",
			"modeloNew","modeloList","modeloUpdate","modeloSearch", "modeloPhoto",
			"ubicacionNew", "ubicacionList", "ubicacionUpdate", "ubicacionSearch",
			"companyNew","companyList","companyUpdate", "companySearch","companyPhoto",
			"bancoNew","bancoList","bancoUpdate","bancoSearch", "bancoPhoto",
			"proveedorNew", "proveedorList", "proveedorSearch", "proveedorUpdate",
			"despachadorNew", "despachadorList", "despachadorSearch", "despachadorUpdate",
			"clienteNew","clienteList","clienteSearch","clienteUpdate",
			"productNew","productList","productSearch","productUpdate","productPhoto","productCategory",
			"saleNew","saleList","saleSearch","saleDetail",
			"logOut"
			];

			if(in_array($vista, $listaBlanca)){
				if(is_file("./app/views/content/".$vista."-view.php")){
					$contenido="./app/views/content/".$vista."-view.php";
				}else{
					$contenido="404";
				}
			}elseif($vista=="login" || $vista=="index"){
				$contenido="login";
			}else{
				$contenido="404";
			}
			return $contenido;
		}

	}