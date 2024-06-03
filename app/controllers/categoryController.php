<?php
	namespace app\controllers;
	use app\models\mainModel; 
	class categoryController extends mainModel{
		/*----------  Controlador registrar control  ----------*/
		public function registrarCategoryControlador(){
			// return json_encode("regstrar control");
			// exit();
			# Almacenando datos#
		    $codigo=$this->limpiarCadena($_POST['codigo']);
		    $nombre=$this->limpiarCadena($_POST['nombre']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			# Verificando campos obligatorios #
		    if($codigo=="" || $nombre=="" || $company_id=="")
			{
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al actualizar registro",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
		    # Directorio de imagenes #
    		$img_dir="../views/fotos/company/$company_id/categorias/";

    		# Comprobar si se selecciono una imagen #
    		if($_FILES['categoria_foto']['name']!="" && $_FILES['categoria_foto']['size']>0){
    			# Creando directorio #
		        if(!file_exists($img_dir)){
		            if(!mkdir($img_dir,0777)){
		            	$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"Error al crear el directorio",
							"icono"=>"error"
						];
						return json_encode($alerta);
		                exit();
		            } 
		        }
		        # Verificando formato de imagenes #
		        if(mime_content_type($_FILES['categoria_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['categoria_foto']['tmp_name'])!="image/png"){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La imagen que ha seleccionado es de un formato no permitido (solo jpg/png)",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }

		        # Verificando peso de imagen #
		        if(($_FILES['categoria_foto']['size']/1024)>5120){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La imagen que ha seleccionado supera el peso permitido (hasta 500K)",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }

		        # Nombre de la foto #
		        $foto=str_ireplace(" ","cat_",$codigo);
		        $foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['categoria_foto']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }
		        chmod($img_dir,0777);
				//return json_encode($codigo.",".$nombre.",".$company_id);
				//exit();
		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['categoria_foto']['tmp_name'],$img_dir.$foto)){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"No podimos subir la imagen de la categoría, intente mas tarde",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }
    		}else{
    			$foto="";
    		}
		    $category_datos_reg=[
				[
					"campo_nombre"=>"codigo",
					"campo_marcador"=>":Codigo",
					"campo_valor"=>$codigo
				],
				[
					"campo_nombre"=>"nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"categoria_foto",
					"campo_marcador"=>":Categoria_foto",
					"campo_valor"=>$foto
				],
				[
					"campo_nombre"=>"company_id",
					"campo_marcador"=>":Company_id",
					"campo_valor"=>$company_id
				]
			];

			//return json_encode("regstrar control");

			$registrar_category=$this->guardarDatos("company_categorias",$category_datos_reg);

			if($registrar_category->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Categoría registrada",
					"texto"=>"La categoría ".$codigo." ".$nombre." se registro con éxito",
					"icono"=>"success"
				];
			}else{
				
				if(is_file($img_dir.$foto)){
		            chmod($img_dir.$foto,0777);
		            unlink($img_dir.$foto);
		        }

				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo registrar la categoría, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}
		/*----------  Controlador listar control  ----------*/
		public function listarTodosCategoryControlador($company_id, $busqueda){	
			$busqueda=$this->limpiarCadena($busqueda);
			$company_id=$this->limpiarCadena($company_id);
			if(isset($busqueda) && $busqueda!="*"){
				$consulta_datos="SELECT * FROM company_categorias WHERE $company_id=$company_id AND unidad=0  AND ( 
				codigo LIKE '%$busqueda%' OR nombre LIKE '%$busqueda%' 
				) 
				ORDER BY nombre ASC limit 500";
			}else{
				$consulta_datos="SELECT * FROM company_categorias WHERE company_id=$company_id AND unidad=0 ORDER BY nombre ASC limit 500";
			}
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			return $datos;
			exit();
		}
		public function obtenerListaMarketControlador($tipo){
			$consulta_datos = "SELECT * FROM company_categorias 
			WHERE estatus=1 AND tipo='$tipo' AND a.company_id=0 ORDER BY a.tipo, a.nombre";
			//
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();

			return $datos;
			exit();
		}
		public function obtenerUnItemControlador($id){
			$consulta_datos = "SELECT * FROM company_categorias WHERE categoria_id=$id";
			$datos=$this->ejecutarConsulta($consulta_datos);
			if($datos->rowCount()<=0){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el item de la tabla en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}else{
				$datos=$datos->fetch();
			}
			return $datos;
			exit();
		}
		/*----------  Controlador listar control  ----------*/
		public function listarSoloTipoControlador($busqueda){	
			$busqueda=$this->limpiarCadena($busqueda);
			
			if(isset($busqueda)){
				$consulta_datos="SELECT * FROM company_categorias WHERE tipo = '$busqueda' ORDER BY tipo";
			}
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			return $datos;
			exit();
		}
		/*----------  Controlador eliminar control  ----------*/
		public function eliminarCategoryControlador(){
			$id=$this->limpiarCadena($_POST['categoria_id']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			
			if($id==1){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar el item de la tabla de control",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}
			# Verificando control #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company_categorias WHERE categoria_id='$id' and estatus=0");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado a la categoría en estado ACTIVO, deberá inactivarlo primero",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }
		    $eliminarCategoria=$this->eliminarRegistro("company_categorias","categoria_id",$id);
		    if($eliminarCategoria->rowCount()==1){
		    	if(is_file("../views/fotos/company/".$company_id."/categorias/".$datos['categoria_foto'])){
		             chmod("../views/fotos/company/".$company_id."/categorias/".$datos['categoria_foto'],0777);
		            unlink("../views/fotos/company/".$company_id."/categorias/".$datos['categoria_foto']);
		        }
		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"El item de la tabla de Categoría eliminado",
					"texto"=>"El Item $id ha sido eliminado del sistema correctamente",
					"icono"=>"success"
				];
		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar el item $id del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }
		    return json_encode($alerta);
		}

		/*----------  Controlador actualizar control  ----------*/
		public function actualizarCategoryControlador(){
			$categoria_id=$this->limpiarCadena($_POST['categoria_id']);
			$codigo = $this->limpiarCadena($_POST['codigo']);
			$nombre = $this->limpiarCadena($_POST['nombre']);
			$estatus=$this->limpiarCadena($_POST['estatus']);
			//return json_encode($estatus);
			# Verificando control #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company_categorias WHERE categoria_id=$categoria_id");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la ctaegoria en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
			}
		    # Verificando campos obligatorios #
		    if($codigo=="" || $nombre=="" || $estatus=="" 
			){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al actualizar registro",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

            $categoria_datos_up=[
				[
					"campo_nombre"=>"codigo",
					"campo_marcador"=>":Codigo",
					"campo_valor"=>$codigo
				],
				[
					"campo_nombre"=>"nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"estatus",
					"campo_marcador"=>":Estatus",
					"campo_valor"=>$estatus
				]
			];

			$condicion=[
				"condicion_campo"=>"categoria_id",
				"condicion_marcador"=>":categoria_id",
				"condicion_valor"=>$categoria_id
			];

			if($this->actualizarDatos("company_categorias", $categoria_datos_up, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Control actualizado",
				"texto"=>"Los datos de la tabla de categorías se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de la tabla de categorías, por favor intente nuevamente",
				"icono"=>"error"
			];
			}

			return json_encode($alerta);
		}

		/*----------  Controlador actualizar foto control  ----------*/
		public function actualizarFotoCategoryControlador(){
			$id = $this->limpiarCadena($_POST['categoria_id']);
			$company_id = $this->limpiarCadena($_POST['company_id']);
			$categoria_tipo = $this->limpiarCadena($_POST['categoria_tipo']);

			# Verificando control #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company_categorias WHERE company_id = $company_id and categoria_id = '$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la categoría en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }
			
			# Directorio de imagenes #
    		$img_dir="../views/fotos/company/$company_id/categorias/";

			# Comprobar si se selecciono una imagen #
    		if($_FILES['categoria_foto']['name']!="" && $_FILES['categoria_foto']['size']>0){
    			# Creando directorio #
		        if(!file_exists($img_dir)){
		            if(!mkdir($img_dir,0777)){
		            	$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"Error al crear el directorio",
							"icono"=>"error"
						];
						return json_encode($alerta);
		                exit();
		            } 
		        }
				# Verificando formato de imagenes #
		        if(mime_content_type($_FILES['categoria_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['categoria_foto']['tmp_name'])!="image/png"){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La imagen que ha seleccionado es de un formato no permitido (solo jpg/png)",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }

		        # Verificando peso de imagen #
		        if(($_FILES['categoria_foto']['size']/1024)>5120){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La imagen que ha seleccionado supera el peso permitido (hasta 500K)",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }
				
		        # Nombre de la foto #
		        $foto=str_ireplace(" ","_","cat-$company_id-".$id);
		        
				$foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['categoria_foto']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }
		        
				chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['categoria_foto']['tmp_name'],$img_dir.$foto)){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"No podimos subir la imagen al sistema, intente mas tarde",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }
    		}else{
    			$foto="";
    		}

			$categoria_datos_up=[
				[
					"campo_nombre"=>$categoria_tipo,
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				]
			];

			$condicion=[
				"condicion_campo"=>"categoria_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];
			
			

			if($this->actualizarDatos("company_categorias", $categoria_datos_up, $condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']=$foto;
				}
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"La foto de la categoría $id se actualizo correctamente...",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"No hemos podido actualizar algunos datos de la categoria $id, sin embargo la foto ha sido actualizada",
					"icono"=>"warning"
				];
			}
			return json_encode($alerta);
		}
	}