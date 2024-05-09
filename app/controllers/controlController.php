<?php

	namespace app\controllers;
	use app\models\mainModel; 

	class controlController extends mainModel{

		/*----------  Controlador registrar control  ----------*/
		public function registrarControlControlador(){

			// return json_encode("regstrar control");
			// exit();
			# Almacenando datos#
		    $codigo=$this->limpiarCadena($_POST['codigo']);
		    $nombre=$this->limpiarCadena($_POST['nombre']);
		    $tipo=$this->limpiarCadena($_POST['tipo']);
			$unidad=$this->limpiarCadena($_POST['unidad']);

		    
			if( $unidad>0 && $tipo == "")
			{
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al actualizar registro",
					"texto"=>"No has seleccionado un tipo de tabla, dato obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			
			# Verificando campos obligatorios #
		    if($codigo=="" || $nombre=="" || $tipo=="" )
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
			
		    # Verificando integridad de los datos #
		    if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{3,40}",$codigo)){
		         $alerta=[
			 		"tipo"=>"simple",
			 		"titulo"=>"Ocurrió un error inesperado",
			 		"texto"=>"El CODIGO ASIGNADO no coincide con el formato solicitado",
			 		"icono"=>"error"
			 	];
			 	return json_encode($alerta);
		         exit();
		    }

		    if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{5,80}",$nombre)){
		         $alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"El NOMBRE ASIGNADO no coincide con el formato solicitado",
				"icono"=>"error"
				];
				return json_encode($alerta);
		    	exit();
			}

            # Verificando control #
		    #$check_control=$this->ejecutarConsulta("SELECT login FROM control WHERE login='$email'");
		    #if($check_control->rowCount()>0){
		   	# 	$alerta=[
			#		"tipo"=>"simple",
			#		"titulo"=>"Ocurrió un error inesperado",
			#		"texto"=>"El control ingresado ya se encuentra registrado, por favor cambie su email",
			#		"icono"=>"error"
			#	];
			#	return json_encode($alerta);
		     #   exit();
		    #}

		    # Directorio de imagenes #
    		$img_dir="../views/fotos/control/";

    		# Comprobar si se selecciono una imagen #
    		if($_FILES['control_foto']['name']!="" && $_FILES['control_foto']['size']>0){
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
		        if(mime_content_type($_FILES['control_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['control_foto']['tmp_name'])!="image/png"){
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
		        if(($_FILES['control_foto']['size']/1024)>5120){
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
		        $foto=str_ireplace(" ","_",$codigo);
		        $foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['control_foto']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }

		        chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['control_foto']['tmp_name'],$img_dir.$foto)){
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
			
		    $control_datos_reg=[
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
					"campo_nombre"=>"tipo",
					"campo_marcador"=>":Tipo",
					"campo_valor"=>$tipo
				],
				[
					"campo_nombre"=>"control_foto",
					"campo_marcador"=>":Control_foto",
					"campo_valor"=>$foto
				],
				[
					"campo_nombre"=>"unidad",
					"campo_marcador"=>":Unidad",
					"campo_valor"=>$unidad
				]
			];

			//return json_encode("regstrar control");

			$registrar_control=$this->guardarDatos("control",$control_datos_reg);

			if($registrar_control->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Control registrado",
					"texto"=>"El item de codigo ".$codigo." ".$nombre." se registro con exito",
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
					"texto"=>"No se pudo registrar el item de la tabla, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}

		/*----------  Controlador listar control  ----------*/
		public function listarTodosControlControlador($busqueda){	

			$busqueda=$this->limpiarCadena($busqueda);

			if(isset($busqueda) && $busqueda!="*"){
				$consulta_datos="SELECT * FROM control WHERE ( 
				codigo LIKE '%$busqueda%'
				OR nombre LIKE '%$busqueda%' 
				OR tipo LIKE '%$busqueda%' 
				) 
				ORDER BY tipo, nombre ASC limit 500";
			}else{
				$consulta_datos="SELECT * FROM control ORDER BY tipo, nombre ASC limit 500";
			}
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();

			return $datos;
			exit();
		}

		/*----------  Controlador listar control  ----------*/
		public function listarSoloTipoControlador($busqueda){	
			$busqueda=$this->limpiarCadena($busqueda);
			
			if(isset($busqueda)){
				$consulta_datos="SELECT * FROM control WHERE tipo = '$busqueda' ORDER BY tipo";
			}
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			return $datos;
			exit();
		}

		/*----------  Controlador eliminar control  ----------*/
		public function eliminarControlControlador(){

			$id=$this->limpiarCadena($_POST['control_id']);

			//return json_encode($id);
			//exit();

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
		    $datos=$this->ejecutarConsulta("SELECT * FROM control WHERE control_id='$id' and estatus<>1");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el control en Estado ACTIVO, deberá inactivarlo primero",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    $eliminarControl=$this->eliminarRegistro("control","control_id",$id);

		    if($eliminarControl->rowCount()==1){

		    	if(is_file("../views/fotos/control/".$datos['control_foto'])){
		            chmod("../views/fotos/control/".$datos['control_foto'],0777);
		            unlink("../views/fotos/control/".$datos['control_foto']);
		        }

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Item de la tabla de Control eliminado",
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
		public function actualizarControlControlador(){

			$control_id=$this->limpiarCadena($_POST['control_id']);
			$codigo = $this->limpiarCadena($_POST['codigo']);
			$nombre = $this->limpiarCadena($_POST['nombre']);
			$tipo=$this->limpiarCadena($_POST['tipo']);
			$estatus=$this->limpiarCadena($_POST['estatus']);
			
			//return json_encode($estatus);
			# Verificando control #
		    $datos=$this->ejecutarConsulta("SELECT * FROM control WHERE control_id='$control_id'");
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
		    
			if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$codigo)){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al registrar Control",
					"texto"=>"El codigo $codigo no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

			if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,80}",$nombre)){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al registrar Control",
					"texto"=>"El nombre del $codigo no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificando campos obligatorios #
		    if($codigo=="" || $nombre=="" || $tipo=="" || $estatus=="" 
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

            $control_datos_up=[
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
					"campo_nombre"=>"tipo",
					"campo_marcador"=>":Tipo",
					"campo_valor"=>$tipo
				],
				[
					"campo_nombre"=>"estatus",
					"campo_marcador"=>":Estatus",
					"campo_valor"=>$estatus
				]
			];

			$condicion=[
				"condicion_campo"=>"control_id",
				"condicion_marcador"=>":Control_id",
				"condicion_valor"=>$control_id
			];

			if($this->actualizarDatos("control", $control_datos_up, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Control actualizado",
				"texto"=>"Los datos de la tabla de control ".$datos['tipo']." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de la tabla de control ".$datos['tipo'].", por favor intente nuevamente",
				"icono"=>"error"
			];
			}

			return json_encode($alerta);
		}

		/*----------  Controlador eliminar foto control  ----------*/
		public function eliminarFotoControlControlador(){

			$id=$this->limpiarCadena($_POST['control_id']);

			# Verificando control #
		    $datos=$this->ejecutarConsulta("SELECT * FROM control WHERE control_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el control en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/fotos/control/";

    		chmod($img_dir,0777);

    		if(is_file($img_dir.$datos['control_foto'])){

		        chmod($img_dir.$datos['control_foto'],0777);

		        if(!unlink($img_dir.$datos['control_foto'])){
		            $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Error al intentar eliminar la foto del control, por favor intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        	exit();
		        }
		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la foto del control en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $control_datos_up=[
				[
					"campo_nombre"=>"control_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>""
				]
			];

			$condicion=[
				"condicion_campo"=>"control_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("control",$control_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']="";
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"La foto del control ".$datos['control_nombre']." ".$datos['control_apellido']." se elimino correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"No hemos podido actualizar algunos datos del control ".$datos['control_nombre']." ".$datos['control_apellido'].", sin embargo la foto ha sido eliminada correctamente",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}

		/*----------  Controlador actualizar foto control  ----------*/
		public function actualizarFotoControlControlador(){
			$id = $this->limpiarCadena($_POST['control_id']);

			# Verificando control #
		    $datos=$this->ejecutarConsulta("SELECT * FROM control WHERE control_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el control en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

			# Directorio de imagenes #
    		$img_dir="../views/fotos/control/";

    		# Comprobar si se selecciono una imagen #
    		if($_FILES['control_foto']['name']!="" && $_FILES['control_foto']['size']>0){
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
		        if(mime_content_type($_FILES['control_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['control_foto']['tmp_name'])!="image/png"){
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
		        if(($_FILES['control_foto']['size']/1024)>5120){
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
		        $foto=str_ireplace(" ","_",$id);
		        $foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['control_foto']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }

		        chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['control_foto']['tmp_name'],$img_dir.$foto)){
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

		    $control_datos_up=[
				[
					"campo_nombre"=>"control_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				]
			];

			$condicion=[
				"condicion_campo"=>"control_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("control",$control_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']=$foto;
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"La foto del item $id se actualizo correctamente",
					"icono"=>"success"
				];
			}else{

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"No hemos podido actualizar algunos datos del item $id, sin embargo la foto ha sido actualizada",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}


	}