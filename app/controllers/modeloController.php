<?php
	namespace app\controllers;
	use app\models\mainModel; 
	class modeloController extends mainModel{
		/*----------  Controlador registrar control  ----------*/
		public function registrarModeloControlador(){
			# Almacenando datos#
		    $codigo=$this->limpiarCadena($_POST['codigo']);
		    $nombre=$this->limpiarCadena($_POST['nombre']);
			$marca_id=$this->limpiarCadena($_POST['marca_id']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			# Verificando campos obligatorios #
		    if($codigo=="" || $nombre=="" || $company_id=="" || $marca_id=="")
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
    		$img_dir="../views/fotos/company/$company_id/marcas/";

    		# Comprobar si se selecciono una imagen #
    		if($_FILES['marca_foto']['name']!="" && $_FILES['marca_foto']['size']>0){
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
		        if(mime_content_type($_FILES['marca_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['marca_foto']['tmp_name'])!="image/png"){
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
		        if(($_FILES['marca_foto']['size']/1024)>5120){
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
				$foto=str_ireplace(" ","_","modelo-$company_id-".$codigo);
		        $foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['marca_foto']['tmp_name'])){
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
		        if(!move_uploaded_file($_FILES['marca_foto']['tmp_name'],$img_dir.$foto)){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"No podimos subir la imagen del modelo, intente mas tarde",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }
    		}else{
    			$foto="";
    		}
		    $modelo_datos_reg=[
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
					"campo_nombre"=>"marca_foto",
					"campo_marcador"=>":marca_foto",
					"campo_valor"=>$foto
				],
				[
					"campo_nombre"=>"company_id",
					"campo_marcador"=>":Company_id",
					"campo_valor"=>$company_id
				],
				[
					"campo_nombre"=>"unidad",
					"campo_marcador"=>":Unidad",
					"campo_valor"=>$marca_id
				]
			];

			// return json_encode($marca_id);
			// exit();
			
			$registrar_modelo=$this->guardarDatos("company_marcas",$modelo_datos_reg);

			if($registrar_modelo->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Subcategoría registrada",
					"texto"=>"La subcategoría ".$codigo." ".$nombre." se registro con éxito",
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
					"texto"=>"No se pudo registrar la subcategoría, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}
		/*----------  Controlador listar control  ----------*/
		public function listarTodosModeloControlador($marca_id, $busqueda){	
			$busqueda = $this->limpiarCadena($busqueda);
			$marca_id = $this->limpiarCadena($marca_id);
			
			if($marca_id=="")
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
			
			if(isset($busqueda) && $busqueda!="*"){
				$consulta_datos="SELECT * FROM company_marcas WHERE unidad = $marca_id AND ( 
				codigo LIKE '%$busqueda%'
				OR nombre LIKE '%$busqueda%' 
				) 
				ORDER BY nombre ASC limit 500";
			}else{
				$consulta_datos="SELECT * FROM company_marcas WHERE unidad = $marca_id ORDER BY nombre ASC limit 500";
			}
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			return $datos;
			exit();
		}
		public function obtenerListaMarketControlador($tipo){
			$consulta_datos = "SELECT * FROM company_marcas 
			WHERE estatus=1 AND tipo='$tipo' AND a.company_id=0 ORDER BY a.tipo, a.nombre";
			//
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();

			return $datos;
			exit();
		}
		public function obtenerUnItemControlador($id){ 
			$consulta_datos = "SELECT a.unidad, b.nombre, a.marca_id, a.codigo, a.nombre as nombre_marca, a.marca_foto FROM company_marcas a INNER JOIN company_marcas b ON (a.unidad = b.marca_id) WHERE a.marca_id=$id";
			$datos=$this->ejecutarConsulta($consulta_datos);
			if($datos->rowCount()>0){
				$datos=$datos->fetch();
				return $datos;
			}else{
				return false;
			}
			exit();
		}
		/*----------  Controlador listar control  ----------*/
		public function listarSoloTipoControlador($busqueda){	
			$busqueda=$this->limpiarCadena($busqueda);
			
			if(isset($busqueda)){
				$consulta_datos="SELECT * FROM company_marcas WHERE tipo = '$busqueda' ORDER BY tipo";
			}
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			return $datos;
			exit();
		}
		/*----------  Controlador eliminar control  ----------*/
		public function eliminarModeloControlador(){
			$id=$this->limpiarCadena($_POST['marca_id']);
			$unidad=$this->limpiarCadena($_POST['unidad']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			
			if($id==1){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar el modelo",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}
			# Verificando control #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company_marcas WHERE unidad=$unidad AND marca_id='$id' and estatus=0");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El modelo está en estado ACTIVO, deberá inactivarlo para poder eliminarlo",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }
		    $eliminarMarca=$this->eliminarRegistro("company_marcas","marca_id",$id);
		    if($eliminarMarca->rowCount()==1){
		    	if(is_file("../views/fotos/company/".$company_id."/marcas/".$datos['marca_foto'])){
		             chmod("../views/fotos/company/".$company_id."/marcas/".$datos['marca_foto'],0777);
		            unlink("../views/fotos/company/".$company_id."/marcas/".$datos['marca_foto']);
		        }
		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"tabla de Modelos",
					"texto"=>"El Item $id ha sido eliminado del sistema correctamente",
					"icono"=>"success"
				];
		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar el modelo $id del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }
		    return json_encode($alerta);
		}
		/*----------  Controlador actualizar control  ----------*/
		public function actualizarModeloControlador(){
			$marca_id=$this->limpiarCadena($_POST['marca_id']);
			$codigo = $this->limpiarCadena($_POST['codigo']);
			$nombre = $this->limpiarCadena($_POST['nombre']);
			$estatus=$this->limpiarCadena($_POST['estatus']);
			//return json_encode($estatus);
			# Verificando control #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company_marcas WHERE marca_id=$marca_id");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el modelo en el sistema",
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

            $marca_datos_up=[
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
				"condicion_campo"=>"marca_id",
				"condicion_marcador"=>":marca_id",
				"condicion_valor"=>$marca_id
			];

			if($this->actualizarDatos("company_marcas", $marca_datos_up, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Control actualizado",
				"texto"=>"Los datos de la tabla de modelos se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de la tabla de modelos, por favor intente nuevamente",
				"icono"=>"error"
			];
			}

			return json_encode($alerta);
		}
		/*----------  Controlador actualizar foto control  ----------*/
		public function actualizarFotoModeloControlador(){
			$id = $this->limpiarCadena($_POST['marca_id']);
			$codigo = $this->limpiarCadena($_POST['codigo']);
			$company_id = $this->limpiarCadena($_POST['company_id']);
			$marca_tipo = $this->limpiarCadena($_POST['marca_tipo']);

			# Verificando control #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company_marcas WHERE company_id = $company_id and marca_id = '$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la marca en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }
			
			# Directorio de imagenes #
    		$img_dir="../views/fotos/company/$company_id/marcas/";

			# Comprobar si se selecciono una imagen #
    		if($_FILES['marca_foto']['name']!="" && $_FILES['marca_foto']['size']>0){
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
		        if(mime_content_type($_FILES['marca_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['marca_foto']['tmp_name'])!="image/png"){
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
		        if(($_FILES['marca_foto']['size']/1024)>5120){
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
		        $foto=str_ireplace(" ","_","modelo-$company_id-".$codigo);
		        
				$foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['marca_foto']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }
		        
				chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['marca_foto']['tmp_name'],$img_dir.$foto)){
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

			$marca_datos_up=[
				[
					"campo_nombre"=>$marca_tipo,
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				]
			];

			$condicion=[
				"condicion_campo"=>"marca_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];
			
			

			if($this->actualizarDatos("company_marcas", $marca_datos_up, $condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']=$foto;
				}
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"La foto del modelo $id se actualizo correctamente...",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"No hemos podido actualizar algunos datos del modelo $id, sin embargo la foto ha sido actualizada",
					"icono"=>"warning"
				];
			}
			return json_encode($alerta);
		}
	}