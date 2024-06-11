<?php
	namespace app\controllers;
	use app\models\mainModel; 
	class cuponController extends mainModel{
		/*----------  Controlador registrar control  ----------*/
		public function registrarCuponControlador(){
			//return json_encode("codigo");
			//exit();
			# Almacenando datos#
		    $codigo=$this->limpiarCadena($_POST['codigo']);
		    $nombre=$this->limpiarCadena($_POST['nombre']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			$product_id =$this->limpiarCadena($_POST['product_id']);
			$cupon_inicio = $this->limpiarCadena($_POST['cupon_inicio']);
			$cupon_final =$this->limpiarCadena($_POST['cupon_final']);
			$tipo_oferta =$this->limpiarCadena($_POST['tipo_oferta']);
			$estado = $this->limpiarCadena($_POST['estado']);
			$valor_descuento = $this->limpiarCadena($_POST['valor_descuento']);
			$cantidad_minima = $this->limpiarCadena($_POST['cantidad_minima']);
			$cupon_token = $this->limpiarCadena($_POST['cupon_token']);
			$detiene_compra = $this->limpiarCadena($_POST['detiene_compra']);
			# Verificando campos obligatorios #
		    if($codigo=="" || $nombre=="" || $company_id=="" || $product_id=="" ||
			$cupon_inicio=="" || $cupon_final=="" || $tipo_oferta=="" || $estado=="" 
			|| $valor_descuento=="" || $cantidad_minima =="" || $cupon_token=="" || $detiene_compra=="")
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
    		$img_dir="../views/fotos/company/$company_id/cupones/";

    		# Comprobar si se selecciono una imagen #
    		if($_FILES['cupon_foto']['name']!="" && $_FILES['cupon_foto']['size']>0){
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
		        if(mime_content_type($_FILES['cupon_foto']['tmp_name'])!="image\/jpeg" && mime_content_type($_FILES['cupon_foto']['tmp_name'])!="image/png"){
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
		        if(($_FILES['cupon_foto']['size']/1024)>5120){
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
		        $foto=str_ireplace(" ","cupon_",$codigo);
		        $foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['cupon_foto']['tmp_name'])){
		            case 'image\/jpeg':
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
		        if(!move_uploaded_file($_FILES['cupon_foto']['tmp_name'],$img_dir.$foto)){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"No podimos subir la imagen de el cupón, intente mas tarde",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }
    		}else{
    			$foto="";
    		}
		    $cupon_datos_reg=[
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
					"campo_nombre"=>"cupon_foto",
					"campo_marcador"=>":cupon_foto",
					"campo_valor"=>$foto
				],
				[
					"campo_nombre"=>"company_id",
					"campo_marcador"=>":Company_id",
					"campo_valor"=>$company_id
				],
				[
					"campo_nombre"=>"product_id",
					"campo_marcador"=>":Product_id",
					"campo_valor"=>$product_id
				],
				[
					"campo_nombre"=>"cupon_inicio",
					"campo_marcador"=>":Cupon_inicio",
					"campo_valor"=>$cupon_inicio
				],
				[
					"campo_nombre"=>"cupon_final",
					"campo_marcador"=>":Cupon_final",
					"campo_valor"=>$cupon_final
				],
				[
					"campo_nombre"=>"valor_descuento",
					"campo_marcador"=>":Valor_descuento",
					"campo_valor"=>$valor_descuento
				],
				[
					"campo_nombre"=>"tipo_oferta",
					"campo_marcador"=>":Tipo_oferta",
					"campo_valor"=>$tipo_oferta
				],
				[
					"campo_nombre"=>"cantidad_minima",
					"campo_marcador"=>":Cantidad_minima",
					"campo_valor"=>$cantidad_minima
				],
				[
					"campo_nombre"=>"cupon_token",
					"campo_marcador"=>":Cupon_token",
					"campo_valor"=>$cupon_token
				],[
					"campo_nombre"=>"detiene_compra",
					"campo_marcador"=>":Detiene_compra",
					"campo_valor"=>$detiene_compra
				]
			];
			//return json_encode($cupon_datos_reg);
			//exit();
			$registrar_marca=$this->guardarDatos("company_cupones",$cupon_datos_reg);
			if($registrar_marca->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Cupon registrada",
					"texto"=>"El cupon ".$codigo." ".$nombre." se registro con éxito",
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
					"texto"=>"No se pudo registrar el cupón, por favor intente nuevamente",
					"icono"=>"error"
				];
			}
			return json_encode($alerta);
		}
		/*----------  Controlador listar control  ----------*/
		public function listarTodosCuponControlador($company_id,$busqueda){	
			$busqueda=$this->limpiarCadena($busqueda);
			$company_id=$this->limpiarCadena($company_id);
			if(isset($busqueda) && $busqueda!="*"){
				$consulta_datos="SELECT * FROM company_cupones WHERE company_id=$company_id AND ( 
				codigo LIKE '%$busqueda%'
				OR nombre LIKE '%$busqueda%' 
				) 
				ORDER BY nombre ASC limit 500";
			}else{
				$consulta_datos="SELECT * FROM company_cupones WHERE company_id=$company_id  ORDER BY nombre ASC limit 500";
			}
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			return $datos;
			exit();
		}
		public function obtenerUnItemControlador($id){
			$consulta_datos = "SELECT * FROM company_cupones WHERE cupon_id=$id";
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
				$consulta_datos="SELECT * FROM company_cupones WHERE tipo = '$busqueda' ORDER BY tipo";
			}
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			return $datos;
			exit();
		}
		/*----------  Controlador eliminar control  ----------*/
		public function eliminarCuponControlador(){
			$id=$this->limpiarCadena($_POST['cupon_id']);
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
		    $datos=$this->ejecutarConsulta("SELECT * FROM company_cupones WHERE cupon_id='$id' and estatus=0");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado a el cupón en estado ACTIVO, deberá inactivarlo primero",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }
		    $eliminarCategoria=$this->eliminarRegistro("company_cupones","cupon_id",$id);
		    if($eliminarCategoria->rowCount()==1){
		    	if(is_file("../views/fotos/company/".$company_id."/cupones/".$datos['cupon_foto'])){
		             chmod("../views/fotos/company/".$company_id."/cupones/".$datos['cupon_foto'],0777);
		            unlink("../views/fotos/company/".$company_id."/cupones/".$datos['cupon_foto']);
		        }
		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"El item de la tabla de Cupons eliminado",
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
		public function actualizarCuponControlador(){
			$cupon_id=$this->limpiarCadena($_POST['cupon_id']);
			$codigo=$this->limpiarCadena($_POST['codigo']);
		    $nombre=$this->limpiarCadena($_POST['nombre']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			$product_id =$this->limpiarCadena($_POST['product_id']);
			$cupon_inicio = $this->limpiarCadena($_POST['cupon_inicio']);
			$cupon_final =$this->limpiarCadena($_POST['cupon_final']);
			$tipo_oferta =$this->limpiarCadena($_POST['tipo_oferta']);
			$estado = $this->limpiarCadena($_POST['estado']);
			$valor_descuento = $this->limpiarCadena($_POST['valor_descuento']);
			$cantidad_minima = $this->limpiarCadena($_POST['cantidad_minima']);
			$cupon_token = $this->limpiarCadena($_POST['cupon_token']);
			$detiene_compra = $this->limpiarCadena($_POST['detiene_compra']);
			# Verificando campos obligatorios #
		    if($cupon_id=="" || $codigo=="" || $nombre=="" || $company_id=="" || $product_id=="" ||
			$cupon_inicio=="" || $cupon_final=="" || $tipo_oferta=="" || $estado=="" 
			|| $valor_descuento=="" || $cantidad_minima =="" || $cupon_token=="" || $detiene_compra=="")
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
		    
		    $cupon_datos_reg=[
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
					"campo_nombre"=>"company_id",
					"campo_marcador"=>":Company_id",
					"campo_valor"=>$company_id
				],
				[
					"campo_nombre"=>"product_id",
					"campo_marcador"=>":Product_id",
					"campo_valor"=>$product_id
				],
				[
					"campo_nombre"=>"cupon_inicio",
					"campo_marcador"=>":Cupon_inicio",
					"campo_valor"=>$cupon_inicio
				],
				[
					"campo_nombre"=>"cupon_final",
					"campo_marcador"=>":Cupon_final",
					"campo_valor"=>$cupon_final
				],
				[
					"campo_nombre"=>"valor_descuento",
					"campo_marcador"=>":Valor_descuento",
					"campo_valor"=>$valor_descuento
				],
				[
					"campo_nombre"=>"tipo_oferta",
					"campo_marcador"=>":Tipo_oferta",
					"campo_valor"=>$tipo_oferta
				],
				[
					"campo_nombre"=>"cantidad_minima",
					"campo_marcador"=>":Cantidad_minima",
					"campo_valor"=>$cantidad_minima
				],
				[
					"campo_nombre"=>"cupon_token",
					"campo_marcador"=>":Cupon_token",
					"campo_valor"=>$cupon_token
				],[
					"campo_nombre"=>"detiene_compra",
					"campo_marcador"=>":Detiene_compra",
					"campo_valor"=>$detiene_compra
				]
			];
			//return json_encode($cupon_datos_reg);
			//exit();
			
			$condicion=[
				"condicion_campo"=>"cupon_id",
				"condicion_marcador"=>":cupon_id",
				"condicion_valor"=>$cupon_id
			];

			if($this->actualizarDatos("company_cupones", $cupon_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Control actualizado",
				"texto"=>"Los datos de la tabla de cupon se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de la tabla de cupon, por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}

		/*----------  Controlador actualizar foto control  ----------*/
		public function actualizarFotoCuponControlador(){
			$id = $this->limpiarCadena($_POST['cupon_id']);
			$company_id = $this->limpiarCadena($_POST['company_id']);
			$cupon_tipo = $this->limpiarCadena($_POST['cupon_tipo']);

			# Verificando control #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company_cupones WHERE company_id = $company_id and cupon_id = '$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el cupón en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }
			
			# Directorio de imagenes #
    		$img_dir="../views/fotos/company/$company_id/cupones/";

			# Comprobar si se selecciono una imagen #
    		if($_FILES['cupon_foto']['name']!="" && $_FILES['cupon_foto']['size']>0){
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
		        if(mime_content_type($_FILES['cupon_foto']['tmp_name'])!="image\/jpeg" && mime_content_type($_FILES['cupon_foto']['tmp_name'])!="image/png"){
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
		        if(($_FILES['cupon_foto']['size']/1024)>5120){
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
		        $foto=str_ireplace(" ","_","cupon-$company_id-".$id);
		        
				$foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['cupon_foto']['tmp_name'])){
		            case 'image\/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }
		        
				chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['cupon_foto']['tmp_name'],$img_dir.$foto)){
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
					"campo_nombre"=>$cupon_tipo,
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				]
			];

			$condicion=[
				"condicion_campo"=>"cupon_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];
			
			

			if($this->actualizarDatos("company_cupones", $categoria_datos_up, $condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']=$foto;
				}
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"La foto de el cupón $id se actualizo correctamente...",
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