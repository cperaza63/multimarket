<?php

	namespace app\controllers;
	use app\models\mainModel; 

	class companyController extends mainModel{

		/*----------  Controlador registrar company  ----------*/
		public function registrarCompanyControlador(){
			# Almacenando datos#
		    $company_name = $this->limpiarCadena($_POST['company_name']);
		    $company_type = $this->limpiarCadena($_POST['company_type']);
			$company_user = $this->limpiarCadena($_POST['company_user']);
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
			//$company_city = 0;
			
		    # Verificando campos obligatorios 
		    if($company_name=="" || $company_type=="" || $company_email=="" || $company_description=="" 
			|| $company_address=="" || $company_country=="" 
			|| $company_state=="" || $company_city=="" || $company_estatus=="" || $company_phone=="" 
			|| $company_rif==""
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

			if($this->verificarDatos("[0-9$-]{7,100}",$company_phone)){
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
			$sin_rif = str_replace ( "-", '', strtoupper($company_rif));
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
					"campo_nombre"=>"company_description",
					"campo_marcador"=>":Company_description",
					"campo_valor"=>$company_description
				],
				[
					"campo_nombre"=>"company_address",
					"campo_marcador"=>":Company_address",
					"campo_valor"=>$company_address
				],
				[
					"campo_nombre"=>"company_estatus",
					"campo_marcador"=>":Company_estatus",
					"campo_valor"=>$company_estatus
				],
				[
					"campo_nombre"=>"company_phone",
					"campo_marcador"=>":Company_phone",
					"campo_valor"=>$company_phone
				],
				[
					"campo_nombre"=>"company_rif",
					"campo_marcador"=>":Company_rif",
					"campo_valor"=>$company_rif
				],
				[
					"campo_nombre"=>"company_country",
					"campo_marcador"=>":Company_country",
					"campo_valor"=>$company_country
				],
				[
					"campo_nombre"=>"company_state",
					"campo_marcador"=>":Company_state",
					"campo_valor"=>$company_state
				],
				[
					"campo_nombre"=>"company_city",
					"campo_marcador"=>":Company_city",
					"campo_valor"=>$company_city
				],
				[
					"campo_nombre"=>"company_user",
					"campo_marcador"=>":Company_user",
					"campo_valor"=>$company_user
				],
				[
					"campo_nombre"=>"created_at",
					"campo_marcador"=>":Created_at",
					"campo_valor"=>$created_at
				]
			];

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
			# Almacenando datos#
			$company_id=$this->limpiarCadena($_POST['company_id']);
		    $company_name = $this->limpiarCadena($_POST['company_name']);
		    $company_type = $this->limpiarCadena($_POST['company_type']);
			$company_user = $this->limpiarCadena($_POST['company_user']);
		    $company_description = $this->limpiarCadena($_POST['company_description']);
		    $company_address = $this->limpiarCadena($_POST['company_address']);
		    $company_country = $this->limpiarCadena($_POST['company_country']);
		    $company_state = $this->limpiarCadena($_POST['company_state']);
			$company_city = $this->limpiarCadena($_POST['company_city']);
			$company_email = $this->limpiarCadena($_POST['company_email']);
			$company_estatus = $this->limpiarCadena($_POST['company_estatus']);
			$company_phone = $this->limpiarCadena($_POST['company_phone']);
			$company_rif = $this->limpiarCadena($_POST['company_rif']);
			//$company_city = 0;
			
		    # Verificando campos obligatorios 
		    if($company_name=="" || $company_type=="" || $company_email=="" || $company_description=="" 
			|| $company_address=="" || $company_country=="" || $company_id == "" 
			|| $company_state=="" || $company_city=="" || $company_estatus=="" || $company_phone=="" 
			|| $company_rif==""
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

			if($this->verificarDatos("[0-9$-]{7,100}",$company_phone)){
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
					"campo_nombre"=>"company_description",
					"campo_marcador"=>":Company_description",
					"campo_valor"=>$company_description
				],
				[
					"campo_nombre"=>"company_address",
					"campo_marcador"=>":Company_address",
					"campo_valor"=>$company_address
				],
				[
					"campo_nombre"=>"company_estatus",
					"campo_marcador"=>":Company_estatus",
					"campo_valor"=>$company_estatus
				],
				[
					"campo_nombre"=>"company_phone",
					"campo_marcador"=>":Company_phone",
					"campo_valor"=>$company_phone
				],
				[
					"campo_nombre"=>"company_rif",
					"campo_marcador"=>":Company_rif",
					"campo_valor"=>$company_rif
				],
				[
					"campo_nombre"=>"company_country",
					"campo_marcador"=>":Company_country",
					"campo_valor"=>$company_country
				],
				[
					"campo_nombre"=>"company_state",
					"campo_marcador"=>":Company_state",
					"campo_valor"=>$company_state
				],
				[
					"campo_nombre"=>"company_city",
					"campo_marcador"=>":Company_city",
					"campo_valor"=>$company_city
				],
				[
					"campo_nombre"=>"company_user",
					"campo_marcador"=>":Company_user",
					"campo_valor"=>$company_user
				]
			];
			$condicion=[
				"condicion_campo"=>"company_id",
				"condicion_marcador"=>":Company_id",
				"condicion_valor"=>$company_id
			];

			//return json_encode($company_datos_reg);
			//exit();

			if($this->actualizarDatos("company", $company_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Control actualizado",
				"texto"=>"Los datos de la tabla de control ".$company_name." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de la tabla de control ".$company_name.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}

		/*----------  Controlador actualizar company  ----------*/
		public function actualizarMasInformacionControlador(){
			# Almacenando datos#
			$company_id=$this->limpiarCadena($_POST['company_id']);
			$company_iva = $this->limpiarCadena($_POST['company_iva']);
			$company_red1 = $this->limpiarCadena($_POST['company_red1']);
			$company_red_valor1 = $this->limpiarCadena($_POST['company_red_valor1']);
			$company_red2 = $this->limpiarCadena($_POST['company_red2']);
			$company_red_valor2 = $this->limpiarCadena($_POST['company_red_valor2']);
			$company_red3 = $this->limpiarCadena($_POST['company_red3']);
			$company_red_valor3 = $this->limpiarCadena($_POST['company_red_valor3']);
		    $company_slogan = $this->limpiarCadena($_POST['company_slogan']);
		    $company_web = $this->limpiarCadena($_POST['company_web']);
		    $company_servicio_email = $this->limpiarCadena($_POST['company_servicio_email']);
			$company_servicio_email_envio = $this->limpiarCadena($_POST['company_servicio_email_envio']);
			$company_servicio_email_password = $this->limpiarCadena($_POST['company_servicio_email_password']);
			$company_servicio_email_puerto = $this->limpiarCadena($_POST['company_servicio_email_puerto']);
			$company_youtube_index = $this->limpiarCadena($_POST['company_youtube_index']);
		    $company_logo_witdh= $this->limpiarCadena($_POST['company_logo_witdh']);
			$company_logo_height= $this->limpiarCadena($_POST['company_logo_height']);
			# Verificando campos obligatorios 
		    if($company_red1=="" || $company_red_valor1=="" || $company_red2=="" || $company_iva=="" 
			|| $company_red_valor2=="" || $company_red3=="" || $company_red_valor3==""
			|| $company_web=="" || $company_slogan=="" || $company_youtube_index=="" 
			|| $company_logo_witdh==""|| $company_logo_height=="" 
			|| $company_servicio_email=="" || $company_servicio_email_envio=="" 
			|| $company_servicio_email_password=="" || $company_servicio_email_puerto=="" 
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
			
			if(!filter_var($company_servicio_email_envio, FILTER_VALIDATE_EMAIL)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error en la entrada de datos",
					"texto"=>"Ha ingresado un correo electrónico no valido",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			} 
			
			//return json_encode($company_iva);
			//exit();

		    $company_datos_reg=[
				[
					"campo_nombre"=>"company_red1",
					"campo_marcador"=>":Company_red1",
					"campo_valor"=>$company_red1
				],
				[
					"campo_nombre"=>"company_iva",
					"campo_marcador"=>":Company_iva",
					"campo_valor"=>$company_iva
				],
				[
					"campo_nombre"=>"company_red2",
					"campo_marcador"=>":Company_red2",
					"campo_valor"=>$company_red2
				],
				[
					"campo_nombre"=>"company_red3",
					"campo_marcador"=>":Company_red3",
					"campo_valor"=>$company_red3
				],
				[
					"campo_nombre"=>"company_red_valor1",
					"campo_marcador"=>":Company_red_valor1",
					"campo_valor"=>$company_red_valor1
				],
				[
					"campo_nombre"=>"company_red_valor2",
					"campo_marcador"=>":Company_valor2",
					"campo_valor"=>$company_red_valor2
				],
				[
					"campo_nombre"=>"company_red_valor3",
					"campo_marcador"=>":Company_red_valor3",
					"campo_valor"=>$company_red_valor3
				],
				[
					"campo_nombre"=>"company_web",
					"campo_marcador"=>":Company_web",
					"campo_valor"=>$company_web
				],
				[
					"campo_nombre"=>"company_slogan",
					"campo_marcador"=>":Company_slogan",
					"campo_valor"=>$company_slogan
				],
				[
					"campo_nombre"=>"company_logo_witdh",
					"campo_marcador"=>":Company_logo_witdh",
					"campo_valor"=>$company_logo_witdh
				],
				[
					"campo_nombre"=>"company_logo_height",
					"campo_marcador"=>":Company_logo_height",
					"campo_valor"=>$company_logo_height
				],
				[
					"campo_nombre"=>"company_youtube_index",
					"campo_marcador"=>":Company_youtube_index",
					"campo_valor"=>$company_youtube_index
				],
				[
					"campo_nombre"=>"company_servicio_email",
					"campo_marcador"=>":Company_servicio_email",
					"campo_valor"=>$company_servicio_email
				],
				[
					"campo_nombre"=>"company_servicio_email_envio",
					"campo_marcador"=>":Company_servicio_email_envio",
					"campo_valor"=>$company_servicio_email_envio
				],
				[
					"campo_nombre"=>"company_servicio_email_password",
					"campo_marcador"=>":Company_servicio_email_password",
					"campo_valor"=>$company_servicio_email_password
				],
				[
					"campo_nombre"=>"company_servicio_email_puerto",
					"campo_marcador"=>":Company_servicio_email_puerto",
					"campo_valor"=>$company_servicio_email_puerto
				]
			];
			$condicion=[
				"condicion_campo"=>"company_id",
				"condicion_marcador"=>":Company_id",
				"condicion_valor"=>$company_id
			];

			return json_encode($company_datos_reg);
			exit();

			if($this->actualizarDatos("company", $company_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Control actualizado",
				"texto"=>"Los datos de información adicional ".$company_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de información adicional ".$company_id.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}

		/*----------  Controlador actualizar company  ----------*/
		public function actualizarZonaHorariaControlado(){
			$company_id=$this->limpiarCadena($_POST['company_id']);
			$dia_semana = $this->limpiarCadena($_POST['dia_semana']);
			$hora_desde = $this->limpiarCadena($_POST['hora_desde']);
			$hora_hasta = $this->limpiarCadena($_POST['hora_hasta']);
			$aplica_submit = $this->limpiarCadena($_POST['submit']);
			$company_horario_desde = explode("|", $this->limpiarCadena($_POST['company_horario_desde']));
			$company_horario_hasta = explode("|", $this->limpiarCadena($_POST['company_horario_hasta']));
			//return json_encode($company_horario_hasta);
		    //exit();
			$vector_desde = [];
			$vector_hasta = [];
			//
			if($dia_semana=="" || $hora_desde=="" || $hora_hasta=="" 
			|| $company_horario_desde=="" || $company_horario_hasta=="") {
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al actualizar registro",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			if($aplica_submit != "dia" && $aplica_submit != "semana"){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error en la entrada de datos",
					"texto"=>"Debe presioar el button tipo de acción día o semana",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}

			if($aplica_submit == "dia"){
				$cadena_desde = "";
				$cadena_hasta = "";
				for($i=0;$i<=6;$i++ ){
					if($i == $dia_semana){
						$vector_desde[$i] = $hora_desde;
						$vector_hasta[$i] = $hora_hasta;
					}else{
						$vector_desde[$i] = $company_horario_desde[$i];
						$vector_hasta[$i] = $company_horario_hasta[$i];
					}
					$cadena_desde = $cadena_desde . "|". $vector_desde[$i];
					$cadena_hasta = $cadena_hasta . "|". $vector_hasta[$i];
				}
				$cadena_desde = substr($cadena_desde, 1, 100);
				$cadena_hasta = substr($cadena_hasta, 1, 100);
				//echo $cadena; //retorna 1,5,9,6,8
				$company_datos_reg=[
					[
						"campo_nombre"=>"company_horario_desde",
						"campo_marcador"=>":Company_horario_desde",
						"campo_valor"=>$cadena_desde
					],
					[
						"campo_nombre"=>"company_horario_hasta",
						"campo_marcador"=>":Company_horario_hasta",
						"campo_valor"=>$cadena_hasta
					]
				];
			}else{
				$cadena_desde = "";
				$cadena_hasta = "";
				for($i=0;$i<=6;$i++ ){
					$cadena_desde = $cadena_desde . "|". $hora_desde;
					$cadena_hasta = $cadena_hasta . "|". $hora_hasta;
				}
				$cadena_desde = substr($cadena_desde, 1, 100);
				$cadena_hasta = substr($cadena_hasta, 1, 100);
				//echo $cadena; //retorna 1,5,9,6,8
				$company_datos_reg=[
					[
						"campo_nombre"=>"company_horario_desde",
						"campo_marcador"=>":Company_horario_desde",
						"campo_valor"=>$cadena_desde
					],
					[
						"campo_nombre"=>"company_horario_hasta",
						"campo_marcador"=>":Company_horario_hasta",
						"campo_valor"=>$cadena_hasta
					]
				];
			}

			$condicion=[
				"condicion_campo"=>"company_id",
				"condicion_marcador"=>":Company_id",
				"condicion_valor"=>$company_id
			];

			if($this->actualizarDatos("company", $company_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Control actualizado",
				"texto"=>"Los datos de información adicional ".$company_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de información adicional ".$company_id.", por favor intente nuevamente",
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
			$id = $this->limpiarCadena($_POST['company_id']);
			$company_tipo = $this->limpiarCadena($_POST['company_tipo']);

			# Verificando company #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company WHERE company_id='$id'");
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
    		$img_dir="../views/fotos/company/$id/";

			# Comprobar si se selecciono una imagen #
    		if($_FILES['company_logo']['name']!="" && $_FILES['company_logo']['size']>0){
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
		        if(mime_content_type($_FILES['company_logo']['tmp_name'])!="image/jpeg" 
				&& mime_content_type($_FILES['company_logo']['tmp_name'])!="image/png"){
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
		        if(($_FILES['company_logo']['size']/1024)>5120){
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
		        $foto=str_ireplace(" ","_",$company_tipo."-".$id);
		        
				$foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['company_logo']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }
		        
				chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['company_logo']['tmp_name'],$img_dir.$foto)){
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
					"campo_nombre"=>$company_tipo,
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				]
			];

			$condicion=[
				"condicion_campo"=>"company_id",
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
					"texto"=>"La foto del negocio $id se actualizo correctamente...",
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
			$id = $this->limpiarCadena($_POST['company_id']);
			# Verificando company #
			
			$datos=$this->ejecutarConsulta("SELECT * FROM company WHERE company_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el negocio en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

			$img_dir="../views/fotos/company/$id/";
			$array=[0,0,0,0,0];
			$foto_array=["","","","",""];

			

			for ($i=0; $i <= 4; $i++) {
				//return json_encode($_FILES['archivo']['size'][$i]);
				//exit();
				if($_FILES['archivo']['name'][$i]!="" && $_FILES['archivo']['size'][$i]>0){
					if( $i == 0 ){
						$array[$i] = "company_card";
					}elseif($i == 1){
						$array[$i] = "company_banner1";
					}elseif($i == 2){
						$array[$i] = "company_banner2";
					}elseif($i == 3){	
						$array[$i] = "company_banner3";
					}elseif($i == 4){	
						$array[$i] = "company_pdf";
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
					&& mime_content_type($_FILES['archivo']['tmp_name'][$i])!="image/png"
					&& mime_content_type($_FILES['archivo']['tmp_name'][$i])!="application/pdf"
					){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"La imagen que ha seleccionado es de un formato no permitido (solo jpg/png)",
							"icono"=>"error"
						];
						return json_encode($alerta);
						exit();
					}
					
					if(mime_content_type($_FILES['archivo']['tmp_name'][$i])!="image/jpeg" 
					&& mime_content_type($_FILES['archivo']['tmp_name'][$i])!="image/png") {
					# Verificando peso de imagen #
						if(($_FILES['archivo']['size'][$i]/1024)>5120){
							$alerta=[
								"tipo"=>"simple",
								"titulo"=>"Ocurrió un error inesperado",
								"texto"=>"La imagen supera el peso permitido (hasta 500K)",
								"icono"=>"error"
							];
							return json_encode($alerta);
							exit();
						}
					}else{
						if(($_FILES['archivo']['size'][$i]/1024)>15120){
							$alerta=[
								"tipo"=>"simple",
								"titulo"=>"Ocurrió un error inesperado",
								"texto"=>"El archivo PDF supera el peso permitido (hasta 900K)",
								"icono"=>"error"
							];
							return json_encode($alerta);
							exit();
						}
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
						case 'application/pdf':
							$foto_array[$i]=$foto_array[$i].".pdf";
						break;
					}
					
					chmod($img_dir,0777);
	
					# Moviendo imagen al directorio #
					if(!move_uploaded_file($_FILES['archivo']['tmp_name'][$i],$img_dir.$foto_array[$i])){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"No podimos subir el archivo al sistema, intente mas tarde",
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
						"condicion_campo"=>"company_id",
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
								"texto"=>"Error al intentar eliminar el archivo del negocio, por favor intente nuevamente",
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
				"titulo"=>"Foto/Documento actualizado",
				"texto"=>"El archivo del Negocio #$id se actualizo correctamente...",
				"icono"=>"success"
				];
			return json_encode($alerta);
		}
	}