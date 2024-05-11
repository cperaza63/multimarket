<?php

	namespace app\controllers;
	use app\models\mainModel; 

	class companyController extends mainModel{

		/*----------  Controlador registrar company  ----------*/
		public function registrarCompanyControlador(){
			# Almacenando datos#
		    $company_name = $this->limpiarCadena($_POST['company_name']);
		    $company_type = $this->limpiarCadena($_POST['company_type']);
		    $company_description = $this->limpiarCadena($_POST['company_description']);
		    $company_address = $this->limpiarCadena($_POST['company_address']);
		    $company_country = $this->limpiarCadena($_POST['company_country']);
		    $company_state = $this->limpiarCadena($_POST['company_state']);
			$company_city = $this->limpiarCadena($_POST['company_city']);
			$company_email = $this->limpiarCadena($_POST['company_email']);
			$company_estatus = $this->limpiarCadena($_POST['company_estatus']);
			$company_phone = $this->limpiarCadena($_POST['company_phone']);
			$company_rif = $this->limpiarCadena($_POST['company_rif']);
			$created_at = date("Y-m-d");

		    # Verificando campos obligatorios #
		    if($company_name=="" || $company_type=="" || $company_email=="" || $company_description=="" 
			|| $company_address=="" || $company_country=="" || $company_city==""|| $company_state==""
			|| $company_estatus=="" || $company_phone=="" || $company_rif==""
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

			if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$company_rif)){
		    	$alerta=[
				"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El RIF no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
    		}

		    # Verificando integridad de los datos #
		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,45}",$company_name)){
		         $alerta=[
			 		"tipo"=>"simple",
			 		"titulo"=>"Ocurrió un error inesperado",
			 		"texto"=>"El NOMBRE no coincide con el formato solicitado",
			 		"icono"=>"error"
			 	];
			 	return json_encode($alerta);
		         exit();
		    }

			if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$company_phone)){
		    	$alerta=[
				"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El TELEFONO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			
			if(!filter_var($company_email, FILTER_VALIDATE_EMAIL)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error en la entrada de datos",
					"texto"=>"Ha ingresado un correo electrónico no valido",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			} 
           
			# Verificando usuario #
			$sin_rif = str_replace ( "-", '', $company_rif);
			$sin_rif = str_replace ( " ", '', $sin_rif);
			$sin_rif = ucfirst($sin_rif);
			$check_company=$this->ejecutarConsulta("SELECT * FROM company WHERE company_rif = '$sin_rif'");
			if($check_company->rowCount()==1){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Rif ya se encuentra registrado en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}
			
		    $company_datos_reg=[
				[
					"campo_nombre"=>"company_name",
					"campo_marcador"=>":Company_name",
					"campo_valor"=>$company_name
				],
				[
					"campo_nombre"=>"company_email",
					"campo_marcador"=>":Company_email",
					"campo_valor"=>$company_email
				],
				[
					"campo_nombre"=>"$company_description",
					"campo_marcador"=>":Company_description",
					"campo_valor"=>$company_description
				],
				[
					"campo_nombre"=>"$company_address",
					"campo_marcador"=>":Company_address",
					"campo_valor"=>$company_address
				],
				[
					"campo_nombre"=>"$company_estatus",
					"campo_marcador"=>":Company_estatus",
					"campo_valor"=>$company_estatus
				],
				[
					"campo_nombre"=>"$company_phone",
					"campo_marcador"=>":Company_phone",
					"campo_valor"=>$company_phone
				],
				[
					"campo_nombre"=>"$company_rif",
					"campo_marcador"=>":Company_rif",
					"campo_valor"=>$company_rif
				],
				[
					"campo_nombre"=>"$company_country",
					"campo_marcador"=>":Company_country",
					"campo_valor"=>$company_country
				],
				[
					"campo_nombre"=>"$company_state",
					"campo_marcador"=>":Company_state",
					"campo_valor"=>$company_state
				],
				[
					"campo_nombre"=>"$company_city",
					"campo_marcador"=>":Company_city",
					"campo_valor"=>$company_city
				],
				[
					"campo_nombre"=>"$created_at",
					"campo_marcador"=>":Created_at",
					"campo_valor"=>$created_at
				]
			];

			//return json_encode("regstrar company");

			$registrar_company=$this->guardarDatos("company",$company_datos_reg);

			if($registrar_company->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Control registrado",
					"texto"=>"El item de codigo ".$company_name." se registro con exito",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo registrar el negocio de la tabla, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}

		/*----------  Controlador listar company  ----------*/
		public function listarTodosCompanyControlador($busqueda){	

			$busqueda=$this->limpiarCadena($busqueda);

			if(isset($busqueda) && $busqueda!="*"){
				$consulta_datos="SELECT * FROM company WHERE ( 
				company_phone LIKE '%$busqueda%'
				OR company_name LIKE '%$busqueda%' 
				OR company_description LIKE '%$busqueda%'
				OR company_rif LIKE '%$busqueda%' 
				OR company_email LIKE '%$busqueda%' 
				OR company_address LIKE '%$busqueda%' 
				) 
				ORDER BY company_type, company_name ASC limit 500";
			}else{
				$consulta_datos="SELECT * FROM company ORDER BY company_type, company_name ASC limit 500";
			}
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();

			return $datos;
			exit();
		}

		/*----------  Controlador listar company  ----------*/
		public function listarSoloTipoControlador($busqueda){	
			$busqueda=$this->limpiarCadena($busqueda);
			
			if(isset($busqueda)){
				$consulta_datos="SELECT * FROM company WHERE company_type = '$busqueda' 
				ORDER BY company_type";
			}
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			return $datos;
			exit();
		}

		/*----------  Controlador eliminar company  ----------*/
		public function eliminarCompanyControlador(){

			$id=$this->limpiarCadena($_POST['control_id']);

			//return json_encode($id);
			//exit();

			if($id==1){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar el item de la tabla de company",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			# Verificando company #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company WHERE control_id='$id' and estatus<>1");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el company en Estado ACTIVO, deberá inactivarlo primero",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    $eliminarControl=$this->eliminarRegistro("company","control_id",$id);

		    if($eliminarControl->rowCount()==1){

		    	if(is_file("../views/fotos/company/".$datos['control_foto'])){
		            chmod("../views/fotos/company/".$datos['control_foto'],0777);
		            unlink("../views/fotos/company/".$datos['control_foto']);
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

		/*----------  Controlador actualizar company  ----------*/
		public function actualizarCompanyControlador(){

			$control_id=$this->limpiarCadena($_POST['control_id']);
			$codigo = $this->limpiarCadena($_POST['codigo']);
			$nombre = $this->limpiarCadena($_POST['nombre']);
			$tipo=$this->limpiarCadena($_POST['tipo']);
			$estatus=$this->limpiarCadena($_POST['estatus']);
			
			//return json_encode($estatus);
			# Verificando company #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company WHERE control_id='$control_id'");
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
		    
			if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{3,45}",$codigo)){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al registrar Control",
					"texto"=>"El codigo $codigo no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

			if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{3,80}",$nombre)){
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

			if($this->actualizarDatos("company", $control_datos_up, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Control actualizado",
				"texto"=>"Los datos de la tabla de company ".$datos['tipo']." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de la tabla de company ".$datos['tipo'].", por favor intente nuevamente",
				"icono"=>"error"
			];
			}

			return json_encode($alerta);
		}

		/*----------  Controlador eliminar foto company  ----------*/
		public function eliminarFotoCompanyControlador(){

			$id=$this->limpiarCadena($_POST['control_id']);

			# Verificando company #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company WHERE control_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el company en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/fotos/company/";

    		chmod($img_dir,0777);

    		if(is_file($img_dir.$datos['control_foto'])){

		        chmod($img_dir.$datos['control_foto'],0777);

		        if(!unlink($img_dir.$datos['control_foto'])){
		            $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Error al intentar eliminar la foto del company, por favor intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        	exit();
		        }
		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la foto del company en el sistema",
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

			if($this->actualizarDatos("company",$control_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']="";
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"La foto del company ".$datos['control_nombre']." ".$datos['control_apellido']." se elimino correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"No hemos podido actualizar algunos datos del company ".$datos['control_nombre']." ".$datos['control_apellido'].", sin embargo la foto ha sido eliminada correctamente",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}

		/*----------  Controlador actualizar foto company  ----------*/
		public function actualizarFotoCompanyControlador(){
			$id = $this->limpiarCadena($_POST['control_id']);
			$control_tipo = $this->limpiarCadena($_POST['control_tipo']);

			# Verificando company #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company WHERE control_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el company en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }
			
			# Directorio de imagenes #
    		$img_dir="../views/fotos/company/";

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
		        $foto=str_ireplace(" ","_",$control_tipo."-".$id);
		        
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
					"campo_nombre"=>$control_tipo,
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				]
			];

			$condicion=[
				"condicion_campo"=>"control_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];
			
			

			if($this->actualizarDatos("company",$control_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']=$foto;
				}
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"La foto $control_tipo del item $id se actualizo correctamente...",
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

		public function actualizarFotoMasaControlador(){
			$id = $this->limpiarCadena($_POST['control_id']);
			# Verificando company #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company WHERE control_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el company en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }
			$img_dir="../views/fotos/company/";
			$array=[0,0,0,0];
			$foto_array=["","","",""];
			$num_archivos=count($_FILES['archivo']['name']);
			for ($i=0; $i <= 3; $i++) {
				//return json_encode($_FILES['archivo']['size'][$i]);
				//exit();
				if($_FILES['archivo']['name'][$i]!="" && $_FILES['archivo']['size'][$i]>0){
					
					if( $i == 0 ){
						$array[$i] = "control_card";
					}elseif($i == 1){
						$array[$i] = "control_banner1";
					}elseif($i == 2){
						$array[$i] = "control_banner2";
					}elseif($i == 3){	
						$array[$i] =  "control_banner3";
					}
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
					if(mime_content_type($_FILES['archivo']['tmp_name'][$i])!="image/jpeg" 
					&& mime_content_type($_FILES['archivo']['tmp_name'][$i])!="image/png"){
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
					if(($_FILES['archivo']['size'][$i]/1024)>5120){
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
					$foto_array[$i] = str_ireplace(" ","_",$array[$i]."-".$id);
					
					$foto_array[$i] = $foto_array[$i]."_".rand(0,100);
	
					# Extension de la imagen #
					switch(mime_content_type($_FILES['archivo']['tmp_name'][$i])){
						case 'image/jpeg':
							$foto_array[$i]=$foto_array[$i].".jpg";
						break;
						case 'image/png':
							$foto_array[$i]=$foto_array[$i].".png";
						break;
					}
					
					chmod($img_dir,0777);
	
					# Moviendo imagen al directorio #
					if(!move_uploaded_file($_FILES['archivo']['tmp_name'][$i],$img_dir.$foto_array[$i])){
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
					$foto_array[$i] = "";
				}
				
				if ( $array[$i] != "" && $array[$i] != "0" ) {
					$control_datos_up=[
						[
							"campo_nombre"=>$array[$i],
							"campo_marcador"=>":Foto_$array[$i]",
							"campo_valor"=>$foto_array[$i]
						]
					];
					$condicion=[
						"condicion_campo"=>"control_id",
						"condicion_marcador"=>":ID",
						"condicion_valor"=>$id
					];
					$this->actualizarDatos("company",$control_datos_up,$condicion);
					
					// elimino la fot anterior
					if(is_file($img_dir.$datos[$array[$i]])){
						chmod($img_dir.$datos[$array[$i]],0777);
						if(!unlink($img_dir.$datos[$array[$i]])){
							$alerta=[
								"tipo"=>"simple",
								"titulo"=>"Ocurrió un error inesperado",
								"texto"=>"Error al intentar eliminar la foto del company, por favor intente nuevamente",
								"icono"=>"error"
							];
							return json_encode($alerta);
							exit();
						}
					}
				}
			}

			if($id==$_SESSION['id']){
				$_SESSION['foto']=$foto_array[$i];
			}
			$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Foto actualizada",
				"texto"=>"La foto del item $id se actualizo correctamente...",
				"icono"=>"success"
				];
			return json_encode($alerta);

			// end For
			// $alerta=[
			// 	"tipo"=>"simple",
			// 	"titulo"=>"proceso finalizado",
			// 	"texto"=>"Todo bien $foto_array[0] $foto_array[1] $foto_array[2] $foto_array[3]",
			// 	"icono"=>"success"
			// ];
			// return json_encode($alerta);
			// exit();
		}
	}