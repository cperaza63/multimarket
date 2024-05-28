<?php

	namespace app\controllers;
	use app\models\mainModel; 
	class clienteController extends mainModel{
		/*----------  Controlador registrar cliente  ----------*/
		public function registrarClienteControlador(){
			# Almacenando datos#
		    $cliente_name = $this->limpiarCadena($_POST['cliente_name']);
			$company_id = $this->limpiarCadena($_POST['company_id']);
		    $cliente_description = $this->limpiarCadena($_POST['cliente_description']);
		    $cliente_address = $this->limpiarCadena($_POST['cliente_address']);
		    $cliente_country = $this->limpiarCadena($_POST['cliente_country']);
		    $cliente_state = $this->limpiarCadena($_POST['cliente_state']);
			$cliente_city = $this->limpiarCadena($_POST['cliente_city']);
			$cliente_email = $this->limpiarCadena($_POST['cliente_email']);
			$cliente_estatus = $this->limpiarCadena($_POST['cliente_estatus']);
			$cliente_phone = $this->limpiarCadena($_POST['cliente_phone']);
			$cliente_rif = $this->limpiarCadena($_POST['cliente_rif']);
			$created_at = date("Y-m-d");
			//$cliente_city = 0;

		    # Verificando campos obligatorios 
		    if($cliente_name=="" || $company_id=="" || $cliente_email=="" || $cliente_description=="" 
			|| $cliente_address=="" || $cliente_country=="" || $cliente_state=="" || $cliente_city=="" 
			|| $cliente_estatus=="" || $cliente_phone=="" || $cliente_rif==""
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
			if($this->verificarDatos("[0-9$-]{7,100}",$cliente_phone)){
		    	$alerta=[
				"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El TELEFONO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			
			if(!filter_var($cliente_email, FILTER_VALIDATE_EMAIL)){
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
			$sin_rif = str_replace ( "-", '', strtoupper($cliente_rif));
			$sin_rif = str_replace ( " ", '', $sin_rif);
			$sin_rif = ucfirst($sin_rif);
			$check_cliente=$this->ejecutarConsulta("SELECT * FROM cliente WHERE cliente_rif = '$sin_rif'");
			if($check_cliente->rowCount()==1){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Rif ya se encuentra registrado en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}
			
		    $cliente_datos_reg=[
				[
					"campo_nombre"=>"cliente_name",
					"campo_marcador"=>":Cliente_name",
					"campo_valor"=>$cliente_name
				],
				[
					"campo_nombre"=>"cliente_email",
					"campo_marcador"=>":Cliente_email",
					"campo_valor"=>$cliente_email
				],

				[
					"campo_nombre"=>"company_id",
					"campo_marcador"=>":Company_id",
					"campo_valor"=>$company_id
				],
				[
					"campo_nombre"=>"cliente_description",
					"campo_marcador"=>":Cliente_description",
					"campo_valor"=>$cliente_description
				],
				[
					"campo_nombre"=>"cliente_address",
					"campo_marcador"=>":Cliente_address",
					"campo_valor"=>$cliente_address
				],
				[
					"campo_nombre"=>"cliente_estatus",
					"campo_marcador"=>":Cliente_estatus",
					"campo_valor"=>$cliente_estatus
				],
				[
					"campo_nombre"=>"cliente_phone",
					"campo_marcador"=>":Cliente_phone",
					"campo_valor"=>$cliente_phone
				],
				[
					"campo_nombre"=>"cliente_rif",
					"campo_marcador"=>":Cliente_rif",
					"campo_valor"=>$cliente_rif
				],
				[
					"campo_nombre"=>"cliente_country",
					"campo_marcador"=>":Cliente_country",
					"campo_valor"=>$cliente_country
				],
				[
					"campo_nombre"=>"cliente_state",
					"campo_marcador"=>":Cliente_state",
					"campo_valor"=>$cliente_state
				],
				[
					"campo_nombre"=>"cliente_city",
					"campo_marcador"=>":Cliente_city",
					"campo_valor"=>$cliente_city
				],
				[
					"campo_nombre"=>"created_at",
					"campo_marcador"=>":Created_at",
					"campo_valor"=>$created_at
				]
			];

			$registrar_cliente=$this->guardarDatos("cliente",$cliente_datos_reg);

			if($registrar_cliente->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Cliente registrado",
					"texto"=>"El item de codigo ".$cliente_name." se registro con exito",
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
		/*----------  Controlador listar cliente  ----------*/
		public function listarTodosClienteControlador($company_id, $busqueda){
			$company_id=$this->limpiarCadena($company_id); 
			$busqueda=$this->limpiarCadena($busqueda);

			if(isset($busqueda) && $busqueda!="*"){
				$consulta_datos="SELECT * FROM cliente WHERE company_id= $company_id AND ( 
				cliente_phone LIKE '%$busqueda%'
				OR cliente_name LIKE '%$busqueda%' 
				OR cliente_description LIKE '%$busqueda%'
				OR cliente_rif LIKE '%$busqueda%' 
				OR cliente_email LIKE '%$busqueda%' 
				OR cliente_address LIKE '%$busqueda%' 
				) 
				ORDER BY cliente_name ASC";
			}else{
				$consulta_datos="SELECT * FROM cliente WHERE company_id=$company_id 
				ORDER BY cliente_name ASC";
			}

			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			return $datos;
			exit();
		}
		/*----------  Controlador eliminar cliente  ----------*/
		public function eliminarClienteControlador(){
			$id=$this->limpiarCadena($_POST['cliente_id']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			# Verificando cliente #
		    $datos=$this->ejecutarConsulta("SELECT * FROM cliente WHERE cliente_id='$id' and cliente_estatus<>1");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el cliente en Estado ACTIVO, deberá inactivarlo primero",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    $eliminarCliente=$this->eliminarRegistro("cliente","cliente_id",$id);

		    if($eliminarCliente->rowCount()==1){

		    	if(is_file("../views/fotos/company/".$company_id."/clientees/".$datos['cliente_foto'])){
		            chmod("../views/fotos/company/".$company_id."/clientees/".$datos['cliente_foto'],0777);
		            unlink("../views/fotos/company/".$company_id."/clientees/".$datos['cliente_foto']);
		        }

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Item de la tabla de Cliente eliminado",
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
		/*----------  Controlador actualizar cliente  ----------*/
		public function actualizarClienteControlador(){
			# Almacenando datos#
			$cliente_id=$this->limpiarCadena($_POST['cliente_id']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
		    $cliente_name = $this->limpiarCadena($_POST['cliente_name']);
			$cliente_description = $this->limpiarCadena($_POST['cliente_description']);
		    $cliente_address = $this->limpiarCadena($_POST['cliente_address']);
		    $cliente_country = $this->limpiarCadena($_POST['cliente_country']);
		    $cliente_state = $this->limpiarCadena($_POST['cliente_state']);
			$cliente_city = $this->limpiarCadena($_POST['cliente_city']);
			$cliente_email = $this->limpiarCadena($_POST['cliente_email']);
			$cliente_estatus = $this->limpiarCadena($_POST['cliente_estatus']);
			$cliente_phone = $this->limpiarCadena($_POST['cliente_phone']);
			$cliente_rif = $this->limpiarCadena($_POST['cliente_rif']);
			//$cliente_city = 0;
			
		    # Verificando campos obligatorios 
		    if($cliente_name=="" || $company_id=="" || $cliente_email=="" || $cliente_description=="" 
			|| $cliente_address=="" || $cliente_country=="" || $cliente_id == "" 
			|| $cliente_state=="" || $cliente_city=="" || $cliente_estatus=="" || $cliente_phone=="" 
			|| $cliente_rif==""
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

			if($this->verificarDatos("[0-9$-]{7,100}",$cliente_phone)){
		    	$alerta=[
				"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El TELEFONO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			
			if(!filter_var($cliente_email, FILTER_VALIDATE_EMAIL)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error en la entrada de datos",
					"texto"=>"Ha ingresado un correo electrónico no valido",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			} 
			
		    $cliente_datos_reg=[
				[
					"campo_nombre"=>"cliente_name",
					"campo_marcador"=>":Cliente_name",
					"campo_valor"=>$cliente_name
				],
				[
					"campo_nombre"=>"cliente_email",
					"campo_marcador"=>":Cliente_email",
					"campo_valor"=>$cliente_email
				],
				[
					"campo_nombre"=>"cliente_description",
					"campo_marcador"=>":Cliente_description",
					"campo_valor"=>$cliente_description
				],
				[
					"campo_nombre"=>"cliente_address",
					"campo_marcador"=>":Cliente_address",
					"campo_valor"=>$cliente_address
				],
				[
					"campo_nombre"=>"cliente_estatus",
					"campo_marcador"=>":Cliente_estatus",
					"campo_valor"=>$cliente_estatus
				],
				[
					"campo_nombre"=>"cliente_phone",
					"campo_marcador"=>":Cliente_phone",
					"campo_valor"=>$cliente_phone
				],
				[
					"campo_nombre"=>"cliente_rif",
					"campo_marcador"=>":Cliente_rif",
					"campo_valor"=>$cliente_rif
				],
				[
					"campo_nombre"=>"cliente_country",
					"campo_marcador"=>":Cliente_country",
					"campo_valor"=>$cliente_country
				],
				[
					"campo_nombre"=>"cliente_state",
					"campo_marcador"=>":Cliente_state",
					"campo_valor"=>$cliente_state
				],
				[
					"campo_nombre"=>"cliente_city",
					"campo_marcador"=>":Cliente_city",
					"campo_valor"=>$cliente_city
				]
			];
			$condicion=[
				"condicion_campo"=>"cliente_id",
				"condicion_marcador"=>":Cliente_id",
				"condicion_valor"=>$cliente_id
			];

			//return json_encode($cliente_datos_reg);
			//exit();

			if($this->actualizarDatos("cliente", $cliente_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Cliente actualizado",
				"texto"=>"Los datos de la tabla de cliente ".$cliente_name." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de la tabla de control ".$cliente_name.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}
		/*----------  Controlador actualizar cliente  ----------*/
		public function actualizarMasInformacionControlador(){
			# Almacenando datos#
			$cliente_id=$this->limpiarCadena($_POST['cliente_id']);
			$cliente_red1 = $this->limpiarCadena($_POST['cliente_red1']);
			$cliente_red_valor1 = $this->limpiarCadena($_POST['cliente_red_valor1']);
			$cliente_red2 = $this->limpiarCadena($_POST['cliente_red2']);
			$cliente_red_valor2 = $this->limpiarCadena($_POST['cliente_red_valor2']);
			$cliente_red3 = $this->limpiarCadena($_POST['cliente_red3']);
			$cliente_red_valor3 = $this->limpiarCadena($_POST['cliente_red_valor3']);
		    $cliente_web = $this->limpiarCadena($_POST['cliente_web']);
		    $cliente_youtube_index = $this->limpiarCadena($_POST['cliente_youtube_index']);
		    $cliente_logo_witdh= $this->limpiarCadena($_POST['cliente_logo_witdh']);
			$cliente_logo_height= $this->limpiarCadena($_POST['cliente_logo_height']);
			# Verificando campos obligatorios 
		    if($cliente_red1=="" || $cliente_red_valor1=="" || $cliente_red2=="" 
			|| $cliente_red_valor2=="" || $cliente_red3=="" || $cliente_red_valor3==""
			|| $cliente_web=="" || $cliente_youtube_index=="" 
			|| $cliente_logo_witdh==""|| $cliente_logo_height=="" 
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
			//return json_encode($cliente_iva);
			//exit();
		    $cliente_datos_reg=[
				[
					"campo_nombre"=>"cliente_red1",
					"campo_marcador"=>":Cliente_red1",
					"campo_valor"=>$cliente_red1
				],
				[
					"campo_nombre"=>"cliente_red2",
					"campo_marcador"=>":Cliente_red2",
					"campo_valor"=>$cliente_red2
				],
				[
					"campo_nombre"=>"cliente_red3",
					"campo_marcador"=>":Cliente_red3",
					"campo_valor"=>$cliente_red3
				],
				[
					"campo_nombre"=>"cliente_red_valor1",
					"campo_marcador"=>":Cliente_red_valor1",
					"campo_valor"=>$cliente_red_valor1
				],
				[
					"campo_nombre"=>"cliente_red_valor2",
					"campo_marcador"=>":Cliente_valor2",
					"campo_valor"=>$cliente_red_valor2
				],
				[
					"campo_nombre"=>"cliente_red_valor3",
					"campo_marcador"=>":Cliente_red_valor3",
					"campo_valor"=>$cliente_red_valor3
				],
				[
					"campo_nombre"=>"cliente_web",
					"campo_marcador"=>":Cliente_web",
					"campo_valor"=>$cliente_web
				],
				[
					"campo_nombre"=>"cliente_logo_witdh",
					"campo_marcador"=>":Cliente_logo_witdh",
					"campo_valor"=>$cliente_logo_witdh
				],
				[
					"campo_nombre"=>"cliente_logo_height",
					"campo_marcador"=>":Cliente_logo_height",
					"campo_valor"=>$cliente_logo_height
				],
				[
					"campo_nombre"=>"cliente_youtube_index",
					"campo_marcador"=>":Cliente_youtube_index",
					"campo_valor"=>$cliente_youtube_index
				]
			];
			$condicion=[
				"condicion_campo"=>"cliente_id",
				"condicion_marcador"=>":Cliente_id",
				"condicion_valor"=>$cliente_id
			];

			if($this->actualizarDatos("cliente", $cliente_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Control actualizado",
				"texto"=>"Los datos de información adicional ".$cliente_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de información adicional ".$cliente_id.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}
		/*----------  Controlador actualizar cliente  ----------*/
		public function actualizarZonaHorariaControlador(){
			$cliente_id=$this->limpiarCadena($_POST['cliente_id']);
			$dia_semana = $this->limpiarCadena($_POST['dia_semana']);
			$hora_desde = $this->limpiarCadena($_POST['hora_desde']);
			$hora_hasta = $this->limpiarCadena($_POST['hora_hasta']);
			$aplica_submit = $this->limpiarCadena($_POST['submit']);
			$cliente_horario_desde = explode("|", $this->limpiarCadena($_POST['cliente_horario_desde']));
			$cliente_horario_hasta = explode("|", $this->limpiarCadena($_POST['cliente_horario_hasta']));
			//return json_encode($cliente_horario_hasta);
		    //exit();
			$vector_desde = [];
			$vector_hasta = [];
			//
			if($dia_semana=="" || $hora_desde=="" || $hora_hasta=="" 
			|| $cliente_horario_desde=="" || $cliente_horario_hasta=="") {
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
						$vector_desde[$i] = $cliente_horario_desde[$i];
						$vector_hasta[$i] = $cliente_horario_hasta[$i];
					}
					$cadena_desde = $cadena_desde . "|". $vector_desde[$i];
					$cadena_hasta = $cadena_hasta . "|". $vector_hasta[$i];
				}
				$cadena_desde = substr($cadena_desde, 1, 100);
				$cadena_hasta = substr($cadena_hasta, 1, 100);
				//echo $cadena; //retorna 1,5,9,6,8
				$cliente_datos_reg=[
					[
						"campo_nombre"=>"cliente_horario_desde",
						"campo_marcador"=>":Cliente_horario_desde",
						"campo_valor"=>$cadena_desde
					],
					[
						"campo_nombre"=>"cliente_horario_hasta",
						"campo_marcador"=>":Cliente_horario_hasta",
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
				$cliente_datos_reg=[
					[
						"campo_nombre"=>"cliente_horario_desde",
						"campo_marcador"=>":Cliente_horario_desde",
						"campo_valor"=>$cadena_desde
					],
					[
						"campo_nombre"=>"cliente_horario_hasta",
						"campo_marcador"=>":Cliente_horario_hasta",
						"campo_valor"=>$cadena_hasta
					]
				];
			}

			$condicion=[
				"condicion_campo"=>"cliente_id",
				"condicion_marcador"=>":Cliente_id",
				"condicion_valor"=>$cliente_id
			];

			if($this->actualizarDatos("cliente", $cliente_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Cliente actualizado",
				"texto"=>"Los datos de información adicional ".$cliente_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de información adicional ".$cliente_id.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}
		/*----------  Controlador actualizar cliente  ----------*/
		public function actualizarUbicacionControlador(){
			$cliente_id=$this->limpiarCadena($_POST['cliente_id']);
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

			$cliente_datos_reg=[
				[
					"campo_nombre"=>"cliente_latitude",
					"campo_marcador"=>":Cliente_latitude",
					"campo_valor"=>$latitude
				],
				[
					"campo_nombre"=>"cliente_longitude",
					"campo_marcador"=>":Cliente_longitude",
					"campo_valor"=>$longitude
				]
			];

			$condicion=[
				"condicion_campo"=>"cliente_id",
				"condicion_marcador"=>":Cliente_id",
				"condicion_valor"=>$cliente_id
			];

			if($this->actualizarDatos("cliente", $cliente_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Cliente actualizado",
				"texto"=>"Los datos de ubicación ".$cliente_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de información adicional ".$cliente_id.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}
		/*----------  Controlador eliminar foto cliente  ----------*/
		public function eliminarFotoClienteControlador(){
			$id=$this->limpiarCadena($_POST['cliente_id']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			# Verificando cliente #
		    $datos=$this->ejecutarConsulta("SELECT * FROM cliente WHERE cliente_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el cliente en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/fotos/company/".$company_id."/cliente/";

    		chmod($img_dir,0777);

    		if(is_file($img_dir.$datos['cliente_foto'])){

		        chmod($img_dir.$datos['cliente_foto'],0777);

		        if(!unlink($img_dir.$datos['cliente_foto'])){
		            $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Error al intentar eliminar la foto del cliente, por favor intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        	exit();
		        }
		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la foto del cliente en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $cliente_datos_up=[
				[
					"campo_nombre"=>"cliente_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>""
				]
			];

			$condicion=[
				"condicion_campo"=>"cliente_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("cliente",$cliente_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']="";
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"La foto del cliente ".$datos['control_nombre']." ".$datos['control_apellido']." se elimino correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"No hemos podido actualizar algunos datos del cliente ".$datos['control_nombre']." ".$datos['control_apellido'].", sin embargo la foto ha sido eliminada correctamente",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}
		/*----------  Controlador actualizar foto cliente  ----------*/
		public function actualizarFotoClienteControlador(){
			$id = $this->limpiarCadena($_POST['cliente_id']);
			$cliente_tipo = $this->limpiarCadena($_POST['cliente_tipo']);
			$company_id =  $this->limpiarCadena($_POST['company_id']);
			# Verificando cliente 
			
			$datos=$this->ejecutarConsulta("SELECT * FROM cliente WHERE cliente_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el cliente en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }
			
			# Directorio de imagenes #
    		$img_dir="../views/fotos/company/$company_id/clientees/";
			
			# Comprobar si se selecciono una imagen #
    		if($_FILES['cliente_logo']['name']!="" && $_FILES['cliente_logo']['size']>0){
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
		        if(mime_content_type($_FILES['cliente_logo']['tmp_name'])!="image/jpeg" 
				&& mime_content_type($_FILES['cliente_logo']['tmp_name'])!="image/png"){
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
		        if(($_FILES['cliente_logo']['size']/1024)>5120){
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
		        $foto=str_ireplace(" ","cliente_",$id);
		        
				$foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['cliente_logo']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }
		        
				chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['cliente_logo']['tmp_name'],$img_dir.$foto)){
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

			$cliente_datos_up=[
				[
					"campo_nombre"=>$cliente_tipo,
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				]
			];

			$condicion=[
				"condicion_campo"=>"cliente_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];
			
			

			if($this->actualizarDatos("cliente",$cliente_datos_up,$condicion)){

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
			$id = $this->limpiarCadena($_POST['cliente_id']);
			$company_id = $this->limpiarCadena($_POST['company_id']);
			# Verificando cliente #
			
			$datos=$this->ejecutarConsulta("SELECT * FROM cliente WHERE cliente_id='$id'");
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

			$img_dir="../views/fotos/company/".$company_id."/clientees/";
			$array=[0,0,0,0,0];
			$foto_array=["","","","",""];
			for ($i=0; $i <= 4; $i++) {
				//return json_encode($_FILES['archivo']['size'][$i]);
				//exit();
				if($_FILES['archivo']['name'][$i]!="" && $_FILES['archivo']['size'][$i]>0){
					if( $i == 0 ){
						$array[$i] = "cliente_card";
					}elseif($i == 1){
						$array[$i] = "cliente_banner1";
					}elseif($i == 2){
						$array[$i] = "cliente_banner2";
					}elseif($i == 3){	
						$array[$i] = "cliente_banner3";
					}elseif($i == 4){	
						$array[$i] = "cliente_pdf";
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
					$cliente_datos_up=[
						[
							"campo_nombre"=>$array[$i],
							"campo_marcador"=>":Foto_$array[$i]",
							"campo_valor"=>$foto_array[$i]
						]
					];
					$condicion=[
						"condicion_campo"=>"cliente_id",
						"condicion_marcador"=>":ID",
						"condicion_valor"=>$id
					];
					$this->actualizarDatos("cliente",$cliente_datos_up,$condicion);
					
					// elimino la fot anterior
					if(is_file($img_dir.$datos[$array[$i]])){
						chmod($img_dir.$datos[$array[$i]],0777);
						if(!unlink($img_dir.$datos[$array[$i]])){
							$alerta=[
								"tipo"=>"simple",
								"titulo"=>"Ocurrió un error inesperado",
								"texto"=>"Error al intentar eliminar el archivo del cliente, por favor intente nuevamente",
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