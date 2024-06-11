<?php

	namespace app\controllers;
	use app\models\mainModel; 
	class despachadorController extends mainModel{
		/*----------  Controlador registrar despachador  ----------*/
		public function registrarDespachadorControlador(){
			# Almacenando datos#
		    $despachador_name = $this->limpiarCadena($_POST['despachador_name']);
			$user_id = $this->limpiarCadena($_POST['user_id']);
			$company_id = $this->limpiarCadena($_POST['company_id']);
		    $despachador_description = $this->limpiarCadena($_POST['despachador_description']);
		    $despachador_address = $this->limpiarCadena($_POST['despachador_address']);
		    $despachador_country = $this->limpiarCadena($_POST['despachador_country']);
		    $despachador_state = $this->limpiarCadena($_POST['despachador_state']);
			$despachador_city = $this->limpiarCadena($_POST['despachador_city']);
			$despachador_email = $this->limpiarCadena($_POST['despachador_email']);
			$despachador_estatus = $this->limpiarCadena($_POST['despachador_estatus']);
			$despachador_phone = $this->limpiarCadena($_POST['despachador_phone']);
			$despachador_rif = $this->limpiarCadena($_POST['despachador_rif']);
			$created_at = date("Y-m-d");
			//$despachador_city = 0;

		    # Verificando campos obligatorios 
		    if($user_id=="" || $despachador_name=="" || $company_id=="" || $despachador_email=="" || $despachador_description=="" 
			|| $despachador_address=="" || $despachador_country=="" || $despachador_state=="" || $despachador_city=="" 
			|| $despachador_estatus=="" || $despachador_phone=="" || $despachador_rif==""
			){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al actualizar registro",
					"texto"=>"No has llenado todos los campos que son obligatorios...",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			if($this->verificarDatos("[0-9$-]{7,100}",$despachador_phone)){
		    	$alerta=[
				"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El TELEFONO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			
			if(!filter_var($despachador_email, FILTER_VALIDATE_EMAIL)){
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
			$sin_rif = str_replace ( "-", '', strtoupper($despachador_rif));
			$sin_rif = str_replace ( " ", '', $sin_rif);
			$sin_rif = ucfirst($sin_rif);
			$check_despachador=$this->ejecutarConsulta("SELECT * FROM company_despachadores WHERE despachador_rif = '$sin_rif'");
			if($check_despachador->rowCount()==1){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Rif ya se encuentra registrado en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}
			
		    $despachador_datos_reg=[
				[
					"campo_nombre"=>"user_id",
					"campo_marcador"=>":User_id",
					"campo_valor"=>$user_id
				],
				[
					"campo_nombre"=>"despachador_name",
					"campo_marcador"=>":Despachador_name",
					"campo_valor"=>$despachador_name
				],
				[
					"campo_nombre"=>"despachador_email",
					"campo_marcador"=>":Despachador_email",
					"campo_valor"=>$despachador_email
				],

				[
					"campo_nombre"=>"company_id",
					"campo_marcador"=>":Company_id",
					"campo_valor"=>$company_id
				],
				[
					"campo_nombre"=>"despachador_description",
					"campo_marcador"=>":Despachador_description",
					"campo_valor"=>$despachador_description
				],
				[
					"campo_nombre"=>"despachador_address",
					"campo_marcador"=>":Despachador_address",
					"campo_valor"=>$despachador_address
				],
				[
					"campo_nombre"=>"despachador_estatus",
					"campo_marcador"=>":Despachador_estatus",
					"campo_valor"=>$despachador_estatus
				],
				[
					"campo_nombre"=>"despachador_phone",
					"campo_marcador"=>":Despachador_phone",
					"campo_valor"=>$despachador_phone
				],
				[
					"campo_nombre"=>"despachador_rif",
					"campo_marcador"=>":Despachador_rif",
					"campo_valor"=>$despachador_rif
				],
				[
					"campo_nombre"=>"despachador_country",
					"campo_marcador"=>":Despachador_country",
					"campo_valor"=>$despachador_country
				],
				[
					"campo_nombre"=>"despachador_state",
					"campo_marcador"=>":Despachador_state",
					"campo_valor"=>$despachador_state
				],
				[
					"campo_nombre"=>"despachador_city",
					"campo_marcador"=>":Despachador_city",
					"campo_valor"=>$despachador_city
				],
				[
					"campo_nombre"=>"created_at",
					"campo_marcador"=>":Created_at",
					"campo_valor"=>$created_at
				]
			];

			$registrar_despachador=$this->guardarDatos("company_despachadores",$despachador_datos_reg);

			if($registrar_despachador->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Despachador registrado",
					"texto"=>"El item de codigo ".$despachador_name." se registro con exito",
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
		/*----------  Controlador listar despachador  ----------*/
		public function listarTodosDespachadorControlador($company_id, $busqueda){
			$company_id=$this->limpiarCadena($company_id); 
			$busqueda=$this->limpiarCadena($busqueda);

			if(isset($busqueda) && $busqueda!="*"){
				$consulta_datos="SELECT * FROM company_despachadores WHERE company_id= $company_id AND ( 
				despachador_phone LIKE '%$busqueda%'
				OR despachador_name LIKE '%$busqueda%' 
				OR despachador_description LIKE '%$busqueda%'
				OR despachador_rif LIKE '%$busqueda%' 
				OR despachador_email LIKE '%$busqueda%' 
				OR despachador_address LIKE '%$busqueda%' 
				) 
				ORDER BY despachador_name ASC";
			}else{
				$consulta_datos="SELECT * FROM company_despachadores WHERE company_id=$company_id 
				ORDER BY despachador_name ASC";
			}
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			return $datos;
			exit();
		}
		/*----------  Controlador eliminar despachador  ----------*/
		public function eliminarDespachadorControlador(){
			$id=$this->limpiarCadena($_POST['despachador_id']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			# Verificando despachador #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company_despachadores WHERE despachador_id='$id' and despachador_estatus<>1");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el despachador en Estado ACTIVO, deberá inactivarlo primero",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    $eliminarDespachador=$this->eliminarRegistro("company_despachadores","despachador_id",$id);

		    if($eliminarDespachador->rowCount()==1){

		    	if(is_file("../views/fotos/company/".$company_id."/despachadores/".$datos['despachador_foto'])){
		            chmod("../views/fotos/company/".$company_id."/despachadores/".$datos['despachador_foto'],0777);
		            unlink("../views/fotos/company/".$company_id."/despachadores/".$datos['despachador_foto']);
		        }

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Item de la tabla de Despachador eliminado",
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
		/*----------  Controlador actualizar despachador  ----------*/
		public function actualizarDespachadorControlador(){
			# Almacenando datos#
			$despachador_id=$this->limpiarCadena($_POST['despachador_id']);
			$user_id=$this->limpiarCadena($_POST['user_id']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
		    $despachador_name = $this->limpiarCadena($_POST['despachador_name']);
			$despachador_description = $this->limpiarCadena($_POST['despachador_description']);
		    $despachador_address = $this->limpiarCadena($_POST['despachador_address']);
		    $despachador_country = $this->limpiarCadena($_POST['despachador_country']);
		    $despachador_state = $this->limpiarCadena($_POST['despachador_state']);
			$despachador_city = $this->limpiarCadena($_POST['despachador_city']);
			$despachador_email = $this->limpiarCadena($_POST['despachador_email']);
			$despachador_estatus = $this->limpiarCadena($_POST['despachador_estatus']);
			$despachador_phone = $this->limpiarCadena($_POST['despachador_phone']);
			$despachador_rif = $this->limpiarCadena($_POST['despachador_rif']);
			//$despachador_city = 0;
			
		    # Verificando campos obligatorios 
		    if($user_id=="" || $despachador_name=="" || $company_id=="" || $despachador_email=="" || $despachador_description=="" 
			|| $despachador_address=="" || $despachador_country=="" || $despachador_id == "" 
			|| $despachador_state=="" || $despachador_city=="" || $despachador_estatus=="" || $despachador_phone=="" 
			|| $despachador_rif==""
			){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al actualizar registro",
					"texto"=>"No has llenado todos los campos que son obligatorios..",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

			if($this->verificarDatos("[0-9$-]{7,100}",$despachador_phone)){
		    	$alerta=[
				"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El TELEFONO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			
			if(!filter_var($despachador_email, FILTER_VALIDATE_EMAIL)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error en la entrada de datos",
					"texto"=>"Ha ingresado un correo electrónico no valido",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			} 
			
		    $despachador_datos_reg=[
				[
					"campo_nombre"=>"user_id",
					"campo_marcador"=>":User_id",
					"campo_valor"=>$user_id
				],
				[
					"campo_nombre"=>"despachador_name",
					"campo_marcador"=>":Despachador_name",
					"campo_valor"=>$despachador_name
				],
				[
					"campo_nombre"=>"despachador_email",
					"campo_marcador"=>":Despachador_email",
					"campo_valor"=>$despachador_email
				],
				[
					"campo_nombre"=>"despachador_description",
					"campo_marcador"=>":Despachador_description",
					"campo_valor"=>$despachador_description
				],
				[
					"campo_nombre"=>"despachador_address",
					"campo_marcador"=>":Despachador_address",
					"campo_valor"=>$despachador_address
				],
				[
					"campo_nombre"=>"despachador_estatus",
					"campo_marcador"=>":Despachador_estatus",
					"campo_valor"=>$despachador_estatus
				],
				[
					"campo_nombre"=>"despachador_phone",
					"campo_marcador"=>":Despachador_phone",
					"campo_valor"=>$despachador_phone
				],
				[
					"campo_nombre"=>"despachador_rif",
					"campo_marcador"=>":Despachador_rif",
					"campo_valor"=>$despachador_rif
				],
				[
					"campo_nombre"=>"despachador_country",
					"campo_marcador"=>":Despachador_country",
					"campo_valor"=>$despachador_country
				],
				[
					"campo_nombre"=>"despachador_state",
					"campo_marcador"=>":Despachador_state",
					"campo_valor"=>$despachador_state
				],
				[
					"campo_nombre"=>"despachador_city",
					"campo_marcador"=>":Despachador_city",
					"campo_valor"=>$despachador_city
				]
			];
			$condicion=[
				"condicion_campo"=>"despachador_id",
				"condicion_marcador"=>":Despachador_id",
				"condicion_valor"=>$despachador_id
			];

			//return json_encode($despachador_datos_reg);
			//exit();

			if($this->actualizarDatos("company_despachadores", $despachador_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Despachador actualizado",
				"texto"=>"Los datos de la tabla de despachador ".$despachador_name." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de la tabla de control ".$despachador_name.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}
		/*----------  Controlador actualizar despachador  ----------*/
		public function actualizarMasInformacionControlador(){
			# Almacenando datos#
			$despachador_id=$this->limpiarCadena($_POST['despachador_id']);
			$despachador_red1 = $this->limpiarCadena($_POST['despachador_red1']);
			$despachador_red_valor1 = $this->limpiarCadena($_POST['despachador_red_valor1']);
			$despachador_red2 = $this->limpiarCadena($_POST['despachador_red2']);
			$despachador_red_valor2 = $this->limpiarCadena($_POST['despachador_red_valor2']);
			$despachador_red3 = $this->limpiarCadena($_POST['despachador_red3']);
			$despachador_red_valor3 = $this->limpiarCadena($_POST['despachador_red_valor3']);
		    $despachador_web = $this->limpiarCadena($_POST['despachador_web']);
		    $despachador_youtube_index = $this->limpiarCadena($_POST['despachador_youtube_index']);
		    $despachador_logo_witdh= $this->limpiarCadena($_POST['despachador_logo_witdh']);
			$despachador_logo_height= $this->limpiarCadena($_POST['despachador_logo_height']);
			# Verificando campos obligatorios 
		    if($despachador_red1=="" || $despachador_red_valor1=="" || $despachador_red2=="" 
			|| $despachador_red_valor2=="" || $despachador_red3=="" || $despachador_red_valor3==""
			|| $despachador_web=="" || $despachador_logo_witdh==""|| $despachador_logo_height=="" 
			){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al actualizar registro",
					"texto"=>"No has llenado todos los campos que son obligatorios.",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			//return json_encode($despachador_iva);
			//exit();
		    $despachador_datos_reg=[
				[
					"campo_nombre"=>"despachador_red1",
					"campo_marcador"=>":Despachador_red1",
					"campo_valor"=>$despachador_red1
				],
				[
					"campo_nombre"=>"despachador_red2",
					"campo_marcador"=>":Despachador_red2",
					"campo_valor"=>$despachador_red2
				],
				[
					"campo_nombre"=>"despachador_red3",
					"campo_marcador"=>":Despachador_red3",
					"campo_valor"=>$despachador_red3
				],
				[
					"campo_nombre"=>"despachador_red_valor1",
					"campo_marcador"=>":Despachador_red_valor1",
					"campo_valor"=>$despachador_red_valor1
				],
				[
					"campo_nombre"=>"despachador_red_valor2",
					"campo_marcador"=>":Despachador_valor2",
					"campo_valor"=>$despachador_red_valor2
				],
				[
					"campo_nombre"=>"despachador_red_valor3",
					"campo_marcador"=>":Despachador_red_valor3",
					"campo_valor"=>$despachador_red_valor3
				],
				[
					"campo_nombre"=>"despachador_web",
					"campo_marcador"=>":Despachador_web",
					"campo_valor"=>$despachador_web
				],
				[
					"campo_nombre"=>"despachador_logo_witdh",
					"campo_marcador"=>":Despachador_logo_witdh",
					"campo_valor"=>$despachador_logo_witdh
				],
				[
					"campo_nombre"=>"despachador_logo_height",
					"campo_marcador"=>":Despachador_logo_height",
					"campo_valor"=>$despachador_logo_height
				],
				[
					"campo_nombre"=>"despachador_youtube_index",
					"campo_marcador"=>":Despachador_youtube_index",
					"campo_valor"=>$despachador_youtube_index
				]
			];
			$condicion=[
				"condicion_campo"=>"despachador_id",
				"condicion_marcador"=>":Despachador_id",
				"condicion_valor"=>$despachador_id
			];

			if($this->actualizarDatos("company_despachadores", $despachador_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Control actualizado",
				"texto"=>"Los datos de información adicional ".$despachador_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de información adicional ".$despachador_id.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}
		/*----------  Controlador actualizar despachador  ----------*/
		public function actualizarZonaHorariaControlador(){
			$despachador_id=$this->limpiarCadena($_POST['despachador_id']);
			$dia_semana = $this->limpiarCadena($_POST['dia_semana']);
			$hora_desde = $this->limpiarCadena($_POST['hora_desde']);
			$hora_hasta = $this->limpiarCadena($_POST['hora_hasta']);
			$aplica_submit = $this->limpiarCadena($_POST['submit']);
			$despachador_horario_desde = explode("|", $this->limpiarCadena($_POST['despachador_horario_desde']));
			$despachador_horario_hasta = explode("|", $this->limpiarCadena($_POST['despachador_horario_hasta']));
			$vector_desde = [];
			$vector_hasta = [];
			//
			if($dia_semana=="" || $hora_desde=="" || $hora_hasta=="" 
			|| $despachador_horario_desde=="" || $despachador_horario_hasta=="") {
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
					"texto"=>"Debe presionar el button tipo de acción día o semana",
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
						$vector_desde[$i] = $despachador_horario_desde[$i];
						$vector_hasta[$i] = $despachador_horario_hasta[$i];
					}
					$cadena_desde = $cadena_desde . "|". $vector_desde[$i];
					$cadena_hasta = $cadena_hasta . "|". $vector_hasta[$i];
				}
				$cadena_desde = substr($cadena_desde, 1, 100);
				$cadena_hasta = substr($cadena_hasta, 1, 100);
				//echo $cadena; //retorna 1,5,9,6,8
				$despachador_datos_reg=[
					[
						"campo_nombre"=>"despachador_horario_desde",
						"campo_marcador"=>":Despachador_horario_desde",
						"campo_valor"=>$cadena_desde
					],
					[
						"campo_nombre"=>"despachador_horario_hasta",
						"campo_marcador"=>":Despachador_horario_hasta",
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
				$despachador_datos_reg=[
					[
						"campo_nombre"=>"despachador_horario_desde",
						"campo_marcador"=>":Despachador_horario_desde",
						"campo_valor"=>$cadena_desde
					],
					[
						"campo_nombre"=>"despachador_horario_hasta",
						"campo_marcador"=>":Despachador_horario_hasta",
						"campo_valor"=>$cadena_hasta
					]
				];
			}

			$condicion=[
				"condicion_campo"=>"despachador_id",
				"condicion_marcador"=>":Despachador_id",
				"condicion_valor"=>$despachador_id
			];

			if($this->actualizarDatos("company_despachadores", $despachador_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Despachador actualizado",
				"texto"=>"Los datos de información adicional ".$despachador_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de información adicional ".$despachador_id.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}
		/*----------  Controlador actualizar despachador  ----------*/
		public function actualizarUbicacionControlador(){
			$despachador_id=$this->limpiarCadena($_POST['despachador_id']);
			$latitude = $this->limpiarCadena($_POST['latitude']);
			$longitude = $this->limpiarCadena($_POST['longitude']);
			if($latitude=="" || $longitude=="") {
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al actualizar registro",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}

			$despachador_datos_reg=[
				[
					"campo_nombre"=>"despachador_latitude",
					"campo_marcador"=>":Despachador_latitude",
					"campo_valor"=>$latitude
				],
				[
					"campo_nombre"=>"despachador_longitude",
					"campo_marcador"=>":Despachador_longitude",
					"campo_valor"=>$longitude
				]
			];

			$condicion=[
				"condicion_campo"=>"despachador_id",
				"condicion_marcador"=>":Despachador_id",
				"condicion_valor"=>$despachador_id
			];

			if($this->actualizarDatos("company_despachadores", $despachador_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Despachador actualizado",
				"texto"=>"Los datos de ubicación ".$despachador_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de información adicional ".$despachador_id.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}
		/*----------  Controlador eliminar foto despachador  ----------*/
		public function eliminarFotoDespachadorControlador(){
			$id=$this->limpiarCadena($_POST['despachador_id']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			# Verificando despachador #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company_despachadores WHERE despachador_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el despachador en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/fotos/company/".$company_id."/despachador/";

    		chmod($img_dir,0777);

    		if(is_file($img_dir.$datos['despachador_foto'])){

		        chmod($img_dir.$datos['despachador_foto'],0777);

		        if(!unlink($img_dir.$datos['despachador_foto'])){
		            $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Error al intentar eliminar la foto del despachador, por favor intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        	exit();
		        }
		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la foto del despachador en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $despachador_datos_up=[
				[
					"campo_nombre"=>"despachador_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>""
				]
			];

			$condicion=[
				"condicion_campo"=>"despachador_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("company_despachadores",$despachador_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']="";
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"La foto del despachador ".$datos['control_nombre']." ".$datos['control_apellido']." se elimino correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"No hemos podido actualizar algunos datos del despachador ".$datos['control_nombre']." ".$datos['control_apellido'].", sin embargo la foto ha sido eliminada correctamente",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}
		/*----------  Controlador actualizar foto despachador  ----------*/
		public function actualizarFotoDespachadorControlador(){
			$id = $this->limpiarCadena($_POST['despachador_id']);
			$despachador_tipo = $this->limpiarCadena($_POST['despachador_tipo']);
			$company_id =  $this->limpiarCadena($_POST['company_id']);
			# Verificando despachador 
			
			$datos=$this->ejecutarConsulta("SELECT * FROM company_despachadores WHERE despachador_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el despachador en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }
			
			# Directorio de imagenes #
    		$img_dir="../views/fotos/company/$company_id/despachadores/";
			
			# Comprobar si se selecciono una imagen #
    		if($_FILES['despachador_logo']['name']!="" && $_FILES['despachador_logo']['size']>0){
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
		        if(mime_content_type($_FILES['despachador_logo']['tmp_name'])!="image/jpeg" 
				&& mime_content_type($_FILES['despachador_logo']['tmp_name'])!="image/png"){
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
		        if(($_FILES['despachador_logo']['size']/1024)>5120){
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
		        $foto=str_ireplace(" ","despachador_",$id);
		        
				$foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['despachador_logo']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }
		        
				chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['despachador_logo']['tmp_name'],$img_dir.$foto)){
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

			$despachador_datos_up=[
				[
					"campo_nombre"=>$despachador_tipo,
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				]
			];

			$condicion=[
				"condicion_campo"=>"despachador_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];
			
			

			if($this->actualizarDatos("company_despachadores",$despachador_datos_up,$condicion)){

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
			$id = $this->limpiarCadena($_POST['despachador_id']);
			$company_id = $this->limpiarCadena($_POST['company_id']);
			# Verificando despachador #
			
			$datos=$this->ejecutarConsulta("SELECT * FROM company_despachadores WHERE despachador_id='$id'");
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

			$img_dir="../views/fotos/company/".$company_id."/despachadores/";
			$array=[0,0,0,0,0];
			$foto_array=["","","","",""];
			for ($i=0; $i <= 4; $i++) {
				//return json_encode($_FILES['archivo']['size'][$i]);
				//exit();
				if($_FILES['archivo']['name'][$i]!="" && $_FILES['archivo']['size'][$i]>0){
					if( $i == 0 ){
						$array[$i] = "despachador_card";
					}elseif($i == 1){
						$array[$i] = "despachador_banner1";
					}elseif($i == 2){
						$array[$i] = "despachador_banner2";
					}elseif($i == 3){	
						$array[$i] = "despachador_banner3";
					}elseif($i == 4){	
						$array[$i] = "despachador_pdf";
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
					
					if($i<4 && mime_content_type($_FILES['archivo']['tmp_name'][$i])!="image/jpeg" 
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
						if(($i == 4 && $_FILES['archivo']['size'][$i]/1024)>15120){
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
					$despachador_datos_up=[
						[
							"campo_nombre"=>$array[$i],
							"campo_marcador"=>":Foto_$array[$i]",
							"campo_valor"=>$foto_array[$i]
						]
					];
					$condicion=[
						"condicion_campo"=>"despachador_id",
						"condicion_marcador"=>":ID",
						"condicion_valor"=>$id
					];
					$this->actualizarDatos("company_despachadores",$despachador_datos_up,$condicion);
					
					// elimino la fot anterior
					if(is_file($img_dir.$datos[$array[$i]])){
						chmod($img_dir.$datos[$array[$i]],0777);
						if(!unlink($img_dir.$datos[$array[$i]])){
							$alerta=[
								"tipo"=>"simple",
								"titulo"=>"Ocurrió un error inesperado",
								"texto"=>"Error al intentar eliminar el archivo del despachador, por favor intente nuevamente",
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
				"texto"=>"El archivo del Despachador #$id se actualizo correctamente...",
				"icono"=>"success"
				];
			return json_encode($alerta);
		}
	}