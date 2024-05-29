<?php

	namespace app\controllers;
	use app\models\mainModel; 
	class proveedorController extends mainModel{
		/*----------  Controlador registrar proveedor  ----------*/
		public function registrarProveedorControlador(){
			# Almacenando datos#
		    $proveedor_name = $this->limpiarCadena($_POST['proveedor_name']);
			$company_id = $this->limpiarCadena($_POST['company_id']);
		    $proveedor_description = $this->limpiarCadena($_POST['proveedor_description']);
		    $proveedor_address = $this->limpiarCadena($_POST['proveedor_address']);
		    $proveedor_country = $this->limpiarCadena($_POST['proveedor_country']);
		    $proveedor_state = $this->limpiarCadena($_POST['proveedor_state']);
			$proveedor_city = $this->limpiarCadena($_POST['proveedor_city']);
			$proveedor_email = $this->limpiarCadena($_POST['proveedor_email']);
			$proveedor_estatus = $this->limpiarCadena($_POST['proveedor_estatus']);
			$proveedor_phone = $this->limpiarCadena($_POST['proveedor_phone']);
			$proveedor_rif = $this->limpiarCadena($_POST['proveedor_rif']);
			$created_at = date("Y-m-d");
			//$proveedor_city = 0;

		    # Verificando campos obligatorios 
		    if($proveedor_name=="" || $company_id=="" || $proveedor_email=="" || $proveedor_description=="" 
			|| $proveedor_address=="" || $proveedor_country=="" || $proveedor_state=="" || $proveedor_city=="" 
			|| $proveedor_estatus=="" || $proveedor_phone=="" || $proveedor_rif==""
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
			if($this->verificarDatos("[0-9$-]{7,100}",$proveedor_phone)){
		    	$alerta=[
				"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El TELEFONO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			
			if(!filter_var($proveedor_email, FILTER_VALIDATE_EMAIL)){
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
			$sin_rif = str_replace ( "-", '', strtoupper($proveedor_rif));
			$sin_rif = str_replace ( " ", '', $sin_rif);
			$sin_rif = ucfirst($sin_rif);
			$check_proveedor=$this->ejecutarConsulta("SELECT * FROM company_proveedores WHERE proveedor_rif = '$sin_rif'");
			if($check_proveedor->rowCount()==1){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Rif ya se encuentra registrado en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}
			
		    $proveedor_datos_reg=[
				[
					"campo_nombre"=>"proveedor_name",
					"campo_marcador"=>":Proveedor_name",
					"campo_valor"=>$proveedor_name
				],
				[
					"campo_nombre"=>"proveedor_email",
					"campo_marcador"=>":Proveedor_email",
					"campo_valor"=>$proveedor_email
				],

				[
					"campo_nombre"=>"company_id",
					"campo_marcador"=>":Company_id",
					"campo_valor"=>$company_id
				],
				[
					"campo_nombre"=>"proveedor_description",
					"campo_marcador"=>":Proveedor_description",
					"campo_valor"=>$proveedor_description
				],
				[
					"campo_nombre"=>"proveedor_address",
					"campo_marcador"=>":Proveedor_address",
					"campo_valor"=>$proveedor_address
				],
				[
					"campo_nombre"=>"proveedor_estatus",
					"campo_marcador"=>":Proveedor_estatus",
					"campo_valor"=>$proveedor_estatus
				],
				[
					"campo_nombre"=>"proveedor_phone",
					"campo_marcador"=>":Proveedor_phone",
					"campo_valor"=>$proveedor_phone
				],
				[
					"campo_nombre"=>"proveedor_rif",
					"campo_marcador"=>":Proveedor_rif",
					"campo_valor"=>$proveedor_rif
				],
				[
					"campo_nombre"=>"proveedor_country",
					"campo_marcador"=>":Proveedor_country",
					"campo_valor"=>$proveedor_country
				],
				[
					"campo_nombre"=>"proveedor_state",
					"campo_marcador"=>":Proveedor_state",
					"campo_valor"=>$proveedor_state
				],
				[
					"campo_nombre"=>"proveedor_city",
					"campo_marcador"=>":Proveedor_city",
					"campo_valor"=>$proveedor_city
				],
				[
					"campo_nombre"=>"created_at",
					"campo_marcador"=>":Created_at",
					"campo_valor"=>$created_at
				]
			];

			$registrar_proveedor=$this->guardarDatos("company_proveedores",$proveedor_datos_reg);

			if($registrar_proveedor->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Proveedor registrado",
					"texto"=>"El item de codigo ".$proveedor_name." se registro con exito",
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
		/*----------  Controlador listar proveedor  ----------*/
		public function listarTodosProveedorControlador($company_id, $busqueda){
			$company_id=$this->limpiarCadena($company_id); 
			$busqueda=$this->limpiarCadena($busqueda);

			if(isset($busqueda) && $busqueda!="*"){
				$consulta_datos="SELECT * FROM company_proveedores WHERE company_id= $company_id AND ( 
				proveedor_phone LIKE '%$busqueda%'
				OR proveedor_name LIKE '%$busqueda%' 
				OR proveedor_description LIKE '%$busqueda%'
				OR proveedor_rif LIKE '%$busqueda%' 
				OR proveedor_email LIKE '%$busqueda%' 
				OR proveedor_address LIKE '%$busqueda%' 
				) 
				ORDER BY proveedor_name ASC";
			}else{
				$consulta_datos="SELECT * FROM company_proveedores WHERE company_id=$company_id 
				ORDER BY proveedor_name ASC";
			}
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			return $datos;
			exit();
		}
		/*----------  Controlador eliminar proveedor  ----------*/
		public function eliminarProveedorControlador(){
			$id=$this->limpiarCadena($_POST['proveedor_id']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			# Verificando proveedor #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company_proveedores WHERE proveedor_id='$id' and proveedor_estatus<>1");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el proveedor en Estado ACTIVO, deberá inactivarlo primero",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    $eliminarProveedor=$this->eliminarRegistro("company_proveedores","proveedor_id",$id);

		    if($eliminarProveedor->rowCount()==1){

		    	if(is_file("../views/fotos/company/".$company_id."/proveedores/".$datos['proveedor_foto'])){
		            chmod("../views/fotos/company/".$company_id."/proveedores/".$datos['proveedor_foto'],0777);
		            unlink("../views/fotos/company/".$company_id."/proveedores/".$datos['proveedor_foto']);
		        }

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Item de la tabla de Proveedor eliminado",
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
		/*----------  Controlador actualizar proveedor  ----------*/
		public function actualizarProveedorControlador(){
			# Almacenando datos#
			$proveedor_id=$this->limpiarCadena($_POST['proveedor_id']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
		    $proveedor_name = $this->limpiarCadena($_POST['proveedor_name']);
			$proveedor_description = $this->limpiarCadena($_POST['proveedor_description']);
		    $proveedor_address = $this->limpiarCadena($_POST['proveedor_address']);
		    $proveedor_country = $this->limpiarCadena($_POST['proveedor_country']);
		    $proveedor_state = $this->limpiarCadena($_POST['proveedor_state']);
			$proveedor_city = $this->limpiarCadena($_POST['proveedor_city']);
			$proveedor_email = $this->limpiarCadena($_POST['proveedor_email']);
			$proveedor_estatus = $this->limpiarCadena($_POST['proveedor_estatus']);
			$proveedor_phone = $this->limpiarCadena($_POST['proveedor_phone']);
			$proveedor_rif = $this->limpiarCadena($_POST['proveedor_rif']);
			//$proveedor_city = 0;
			
		    # Verificando campos obligatorios 
		    if($proveedor_name=="" || $company_id=="" || $proveedor_email=="" || $proveedor_description=="" 
			|| $proveedor_address=="" || $proveedor_country=="" || $proveedor_id == "" 
			|| $proveedor_state=="" || $proveedor_city=="" || $proveedor_estatus=="" || $proveedor_phone=="" 
			|| $proveedor_rif==""
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

			if($this->verificarDatos("[0-9$-]{7,100}",$proveedor_phone)){
		    	$alerta=[
				"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El TELEFONO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			
			if(!filter_var($proveedor_email, FILTER_VALIDATE_EMAIL)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error en la entrada de datos",
					"texto"=>"Ha ingresado un correo electrónico no valido",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			} 
			
		    $proveedor_datos_reg=[
				[
					"campo_nombre"=>"proveedor_name",
					"campo_marcador"=>":Proveedor_name",
					"campo_valor"=>$proveedor_name
				],
				[
					"campo_nombre"=>"proveedor_email",
					"campo_marcador"=>":Proveedor_email",
					"campo_valor"=>$proveedor_email
				],
				[
					"campo_nombre"=>"proveedor_description",
					"campo_marcador"=>":Proveedor_description",
					"campo_valor"=>$proveedor_description
				],
				[
					"campo_nombre"=>"proveedor_address",
					"campo_marcador"=>":Proveedor_address",
					"campo_valor"=>$proveedor_address
				],
				[
					"campo_nombre"=>"proveedor_estatus",
					"campo_marcador"=>":Proveedor_estatus",
					"campo_valor"=>$proveedor_estatus
				],
				[
					"campo_nombre"=>"proveedor_phone",
					"campo_marcador"=>":Proveedor_phone",
					"campo_valor"=>$proveedor_phone
				],
				[
					"campo_nombre"=>"proveedor_rif",
					"campo_marcador"=>":Proveedor_rif",
					"campo_valor"=>$proveedor_rif
				],
				[
					"campo_nombre"=>"proveedor_country",
					"campo_marcador"=>":Proveedor_country",
					"campo_valor"=>$proveedor_country
				],
				[
					"campo_nombre"=>"proveedor_state",
					"campo_marcador"=>":Proveedor_state",
					"campo_valor"=>$proveedor_state
				],
				[
					"campo_nombre"=>"proveedor_city",
					"campo_marcador"=>":Proveedor_city",
					"campo_valor"=>$proveedor_city
				]
			];
			$condicion=[
				"condicion_campo"=>"proveedor_id",
				"condicion_marcador"=>":Proveedor_id",
				"condicion_valor"=>$proveedor_id
			];

			//return json_encode($proveedor_datos_reg);
			//exit();

			if($this->actualizarDatos("company_proveedores", $proveedor_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Proveedor actualizado",
				"texto"=>"Los datos de la tabla de proveedor ".$proveedor_name." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de la tabla de control ".$proveedor_name.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}
		/*----------  Controlador actualizar proveedor  ----------*/
		public function actualizarMasInformacionControlador(){
			# Almacenando datos#
			$proveedor_id=$this->limpiarCadena($_POST['proveedor_id']);
			$proveedor_red1 = $this->limpiarCadena($_POST['proveedor_red1']);
			$proveedor_red_valor1 = $this->limpiarCadena($_POST['proveedor_red_valor1']);
			$proveedor_red2 = $this->limpiarCadena($_POST['proveedor_red2']);
			$proveedor_red_valor2 = $this->limpiarCadena($_POST['proveedor_red_valor2']);
			$proveedor_red3 = $this->limpiarCadena($_POST['proveedor_red3']);
			$proveedor_red_valor3 = $this->limpiarCadena($_POST['proveedor_red_valor3']);
		    $proveedor_web = $this->limpiarCadena($_POST['proveedor_web']);
		    $proveedor_youtube_index = $this->limpiarCadena($_POST['proveedor_youtube_index']);
		    $proveedor_logo_witdh= $this->limpiarCadena($_POST['proveedor_logo_witdh']);
			$proveedor_logo_height= $this->limpiarCadena($_POST['proveedor_logo_height']);
			# Verificando campos obligatorios 
		    if($proveedor_red1=="" || $proveedor_red_valor1=="" || $proveedor_red2=="" 
			|| $proveedor_red_valor2=="" || $proveedor_red3=="" || $proveedor_red_valor3==""
			|| $proveedor_web=="" || $proveedor_logo_witdh==""|| $proveedor_logo_height=="" 
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
			//return json_encode($proveedor_iva);
			//exit();
		    $proveedor_datos_reg=[
				[
					"campo_nombre"=>"proveedor_red1",
					"campo_marcador"=>":Proveedor_red1",
					"campo_valor"=>$proveedor_red1
				],
				[
					"campo_nombre"=>"proveedor_red2",
					"campo_marcador"=>":Proveedor_red2",
					"campo_valor"=>$proveedor_red2
				],
				[
					"campo_nombre"=>"proveedor_red3",
					"campo_marcador"=>":Proveedor_red3",
					"campo_valor"=>$proveedor_red3
				],
				[
					"campo_nombre"=>"proveedor_red_valor1",
					"campo_marcador"=>":Proveedor_red_valor1",
					"campo_valor"=>$proveedor_red_valor1
				],
				[
					"campo_nombre"=>"proveedor_red_valor2",
					"campo_marcador"=>":Proveedor_valor2",
					"campo_valor"=>$proveedor_red_valor2
				],
				[
					"campo_nombre"=>"proveedor_red_valor3",
					"campo_marcador"=>":Proveedor_red_valor3",
					"campo_valor"=>$proveedor_red_valor3
				],
				[
					"campo_nombre"=>"proveedor_web",
					"campo_marcador"=>":Proveedor_web",
					"campo_valor"=>$proveedor_web
				],
				[
					"campo_nombre"=>"proveedor_logo_witdh",
					"campo_marcador"=>":Proveedor_logo_witdh",
					"campo_valor"=>$proveedor_logo_witdh
				],
				[
					"campo_nombre"=>"proveedor_logo_height",
					"campo_marcador"=>":Proveedor_logo_height",
					"campo_valor"=>$proveedor_logo_height
				],
				[
					"campo_nombre"=>"proveedor_youtube_index",
					"campo_marcador"=>":Proveedor_youtube_index",
					"campo_valor"=>$proveedor_youtube_index
				]
			];
			$condicion=[
				"condicion_campo"=>"proveedor_id",
				"condicion_marcador"=>":Proveedor_id",
				"condicion_valor"=>$proveedor_id
			];

			if($this->actualizarDatos("company_proveedores", $proveedor_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Control actualizado",
				"texto"=>"Los datos de información adicional ".$proveedor_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de información adicional ".$proveedor_id.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}
		/*----------  Controlador actualizar proveedor  ----------*/
		public function actualizarZonaHorariaControlador(){
			$proveedor_id=$this->limpiarCadena($_POST['proveedor_id']);
			$dia_semana = $this->limpiarCadena($_POST['dia_semana']);
			$hora_desde = $this->limpiarCadena($_POST['hora_desde']);
			$hora_hasta = $this->limpiarCadena($_POST['hora_hasta']);
			$aplica_submit = $this->limpiarCadena($_POST['submit']);
			$proveedor_horario_desde = explode("|", $this->limpiarCadena($_POST['proveedor_horario_desde']));
			$proveedor_horario_hasta = explode("|", $this->limpiarCadena($_POST['proveedor_horario_hasta']));
			$vector_desde = [];
			$vector_hasta = [];
			//
			if($dia_semana=="" || $hora_desde=="" || $hora_hasta=="" 
			|| $proveedor_horario_desde=="" || $proveedor_horario_hasta=="") {
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
						$vector_desde[$i] = $proveedor_horario_desde[$i];
						$vector_hasta[$i] = $proveedor_horario_hasta[$i];
					}
					$cadena_desde = $cadena_desde . "|". $vector_desde[$i];
					$cadena_hasta = $cadena_hasta . "|". $vector_hasta[$i];
				}
				$cadena_desde = substr($cadena_desde, 1, 100);
				$cadena_hasta = substr($cadena_hasta, 1, 100);
				//echo $cadena; //retorna 1,5,9,6,8
				$proveedor_datos_reg=[
					[
						"campo_nombre"=>"proveedor_horario_desde",
						"campo_marcador"=>":Proveedor_horario_desde",
						"campo_valor"=>$cadena_desde
					],
					[
						"campo_nombre"=>"proveedor_horario_hasta",
						"campo_marcador"=>":Proveedor_horario_hasta",
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
				$proveedor_datos_reg=[
					[
						"campo_nombre"=>"proveedor_horario_desde",
						"campo_marcador"=>":Proveedor_horario_desde",
						"campo_valor"=>$cadena_desde
					],
					[
						"campo_nombre"=>"proveedor_horario_hasta",
						"campo_marcador"=>":Proveedor_horario_hasta",
						"campo_valor"=>$cadena_hasta
					]
				];
			}

			$condicion=[
				"condicion_campo"=>"proveedor_id",
				"condicion_marcador"=>":Proveedor_id",
				"condicion_valor"=>$proveedor_id
			];

			if($this->actualizarDatos("company_proveedores", $proveedor_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Proveedor actualizado",
				"texto"=>"Los datos de información adicional ".$proveedor_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de información adicional ".$proveedor_id.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}
		/*----------  Controlador actualizar proveedor  ----------*/
		public function actualizarUbicacionControlador(){
			$proveedor_id=$this->limpiarCadena($_POST['proveedor_id']);
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

			$proveedor_datos_reg=[
				[
					"campo_nombre"=>"proveedor_latitude",
					"campo_marcador"=>":Proveedor_latitude",
					"campo_valor"=>$latitude
				],
				[
					"campo_nombre"=>"proveedor_longitude",
					"campo_marcador"=>":Proveedor_longitude",
					"campo_valor"=>$longitude
				]
			];

			$condicion=[
				"condicion_campo"=>"proveedor_id",
				"condicion_marcador"=>":Proveedor_id",
				"condicion_valor"=>$proveedor_id
			];

			if($this->actualizarDatos("company_proveedores", $proveedor_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Proveedor actualizado",
				"texto"=>"Los datos de ubicación ".$proveedor_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de información adicional ".$proveedor_id.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}
		/*----------  Controlador eliminar foto proveedor  ----------*/
		public function eliminarFotoProveedorControlador(){
			$id=$this->limpiarCadena($_POST['proveedor_id']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			# Verificando proveedor #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company_proveedores WHERE proveedor_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el proveedor en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/fotos/company/".$company_id."/proveedor/";

    		chmod($img_dir,0777);

    		if(is_file($img_dir.$datos['proveedor_foto'])){

		        chmod($img_dir.$datos['proveedor_foto'],0777);

		        if(!unlink($img_dir.$datos['proveedor_foto'])){
		            $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Error al intentar eliminar la foto del proveedor, por favor intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        	exit();
		        }
		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la foto del proveedor en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $proveedor_datos_up=[
				[
					"campo_nombre"=>"proveedor_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>""
				]
			];

			$condicion=[
				"condicion_campo"=>"proveedor_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("company_proveedores",$proveedor_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']="";
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"La foto del proveedor ".$datos['control_nombre']." ".$datos['control_apellido']." se elimino correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"No hemos podido actualizar algunos datos del proveedor ".$datos['control_nombre']." ".$datos['control_apellido'].", sin embargo la foto ha sido eliminada correctamente",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}
		/*----------  Controlador actualizar foto proveedor  ----------*/
		public function actualizarFotoProveedorControlador(){
			$id = $this->limpiarCadena($_POST['proveedor_id']);
			$proveedor_tipo = $this->limpiarCadena($_POST['proveedor_tipo']);
			$company_id =  $this->limpiarCadena($_POST['company_id']);
			# Verificando proveedor 
			
			$datos=$this->ejecutarConsulta("SELECT * FROM company_proveedores WHERE proveedor_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el proveedor en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }
			
			# Directorio de imagenes #
    		$img_dir="../views/fotos/company/$company_id/proveedores/";
			
			# Comprobar si se selecciono una imagen #
    		if($_FILES['proveedor_logo']['name']!="" && $_FILES['proveedor_logo']['size']>0){
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
		        if(mime_content_type($_FILES['proveedor_logo']['tmp_name'])!="image/jpeg" 
				&& mime_content_type($_FILES['proveedor_logo']['tmp_name'])!="image/png"){
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
		        if(($_FILES['proveedor_logo']['size']/1024)>5120){
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
		        $foto=str_ireplace(" ","proveedor_",$id);
		        
				$foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['proveedor_logo']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }
		        
				chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['proveedor_logo']['tmp_name'],$img_dir.$foto)){
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

			$proveedor_datos_up=[
				[
					"campo_nombre"=>$proveedor_tipo,
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				]
			];

			$condicion=[
				"condicion_campo"=>"proveedor_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];
			
			

			if($this->actualizarDatos("company_proveedores",$proveedor_datos_up,$condicion)){

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
			$id = $this->limpiarCadena($_POST['proveedor_id']);
			$company_id = $this->limpiarCadena($_POST['company_id']);
			# Verificando proveedor #
			
			$datos=$this->ejecutarConsulta("SELECT * FROM company_proveedores WHERE proveedor_id='$id'");
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

			$img_dir="../views/fotos/company/".$company_id."/proveedores/";
			$array=[0,0,0,0,0];
			$foto_array=["","","","",""];
			for ($i=0; $i <= 4; $i++) {
				//return json_encode($_FILES['archivo']['size'][$i]);
				//exit();
				if($_FILES['archivo']['name'][$i]!="" && $_FILES['archivo']['size'][$i]>0){
					if( $i == 0 ){
						$array[$i] = "proveedor_card";
					}elseif($i == 1){
						$array[$i] = "proveedor_banner1";
					}elseif($i == 2){
						$array[$i] = "proveedor_banner2";
					}elseif($i == 3){	
						$array[$i] = "proveedor_banner3";
					}elseif($i == 4){	
						$array[$i] = "proveedor_pdf";
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
					$proveedor_datos_up=[
						[
							"campo_nombre"=>$array[$i],
							"campo_marcador"=>":Foto_$array[$i]",
							"campo_valor"=>$foto_array[$i]
						]
					];
					$condicion=[
						"condicion_campo"=>"proveedor_id",
						"condicion_marcador"=>":ID",
						"condicion_valor"=>$id
					];
					$this->actualizarDatos("company_proveedores",$proveedor_datos_up,$condicion);
					
					// elimino la fot anterior
					if(is_file($img_dir.$datos[$array[$i]])){
						chmod($img_dir.$datos[$array[$i]],0777);
						if(!unlink($img_dir.$datos[$array[$i]])){
							$alerta=[
								"tipo"=>"simple",
								"titulo"=>"Ocurrió un error inesperado",
								"texto"=>"Error al intentar eliminar el archivo del proveedor, por favor intente nuevamente",
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