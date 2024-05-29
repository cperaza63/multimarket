<?php

	namespace app\controllers;
	use app\models\mainModel; 

	class productoController extends mainModel{

		/*----------  Controlador registrar company  ----------*/
		public function registrarProductoControlador(){
			# Almacenando datos#
		    $producto_name = $this->limpiarCadena($_POST['producto_name']);
		    $producto_type = $this->limpiarCadena($_POST['producto_type']);
			$producto_user = $this->limpiarCadena($_POST['producto_user']);
		    $producto_description = $this->limpiarCadena($_POST['producto_description']);
		    $producto_address = $this->limpiarCadena($_POST['producto_address']);
		    $producto_country = $this->limpiarCadena($_POST['producto_country']);
		    $producto_state = $this->limpiarCadena($_POST['producto_state']);
			$producto_city = $this->limpiarCadena($_POST['producto_city']);
			$producto_email = $this->limpiarCadena($_POST['producto_email']);
			$producto_estatus = $this->limpiarCadena($_POST['producto_estatus']);
			$producto_phone = $this->limpiarCadena($_POST['producto_phone']);
			$producto_rif = $this->limpiarCadena($_POST['producto_rif']);
			$created_at = date("Y-m-d");
			//$producto_city = 0;
			
		    # Verificando campos obligatorios 
		    if($producto_name=="" || $producto_type=="" || $producto_email=="" || $producto_description=="" 
			|| $producto_address=="" || $producto_country=="" 
			|| $producto_state=="" || $producto_city=="" || $producto_estatus=="" || $producto_phone=="" 
			|| $producto_rif==""
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

			if($this->verificarDatos("[0-9$-]{7,100}",$producto_phone)){
		    	$alerta=[
				"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El TELEFONO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			
			if(!filter_var($producto_email, FILTER_VALIDATE_EMAIL)){
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
			$sin_rif = str_replace ( "-", '', strtoupper($producto_rif));
			$sin_rif = str_replace ( " ", '', $sin_rif);
			$sin_rif = ucfirst($sin_rif);
			$check_company=$this->ejecutarConsulta("SELECT * FROM company WHERE producto_rif = '$sin_rif'");
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
			
		    $producto_datos_reg=[
				[
					"campo_nombre"=>"producto_name",
					"campo_marcador"=>":Producto_name",
					"campo_valor"=>$producto_name
				],
				[
					"campo_nombre"=>"producto_email",
					"campo_marcador"=>":Producto_email",
					"campo_valor"=>$producto_email
				],
				[
					"campo_nombre"=>"producto_description",
					"campo_marcador"=>":Producto_description",
					"campo_valor"=>$producto_description
				],
				[
					"campo_nombre"=>"producto_address",
					"campo_marcador"=>":Producto_address",
					"campo_valor"=>$producto_address
				],
				[
					"campo_nombre"=>"producto_estatus",
					"campo_marcador"=>":Producto_estatus",
					"campo_valor"=>$producto_estatus
				],
				[
					"campo_nombre"=>"producto_phone",
					"campo_marcador"=>":Producto_phone",
					"campo_valor"=>$producto_phone
				],
				[
					"campo_nombre"=>"producto_rif",
					"campo_marcador"=>":Producto_rif",
					"campo_valor"=>$producto_rif
				],
				[
					"campo_nombre"=>"producto_country",
					"campo_marcador"=>":Producto_country",
					"campo_valor"=>$producto_country
				],
				[
					"campo_nombre"=>"producto_state",
					"campo_marcador"=>":Producto_state",
					"campo_valor"=>$producto_state
				],
				[
					"campo_nombre"=>"producto_city",
					"campo_marcador"=>":Producto_city",
					"campo_valor"=>$producto_city
				],
				[
					"campo_nombre"=>"producto_user",
					"campo_marcador"=>":Producto_user",
					"campo_valor"=>$producto_user
				],
				[
					"campo_nombre"=>"created_at",
					"campo_marcador"=>":Created_at",
					"campo_valor"=>$created_at
				]
			];

			$registrar_company=$this->guardarDatos("company",$producto_datos_reg);

			if($registrar_company->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Company registrado",
					"texto"=>"El item de codigo ".$producto_name." se registro con exito",
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
		public function listarTodosProductoControlador($busqueda){	
			$busqueda=$this->limpiarCadena($busqueda);
			if(isset($busqueda) && $busqueda!="*"){
				$consulta_datos="SELECT * FROM company WHERE ( 
				producto_phone LIKE '%$busqueda%'
				OR producto_name LIKE '%$busqueda%' 
				OR producto_description LIKE '%$busqueda%'
				OR producto_rif LIKE '%$busqueda%' 
				OR producto_email LIKE '%$busqueda%' 
				OR producto_address LIKE '%$busqueda%' 
				) 
				ORDER BY producto_type, producto_name ASC";
			}else{
				$consulta_datos="SELECT * FROM company WHERE producto_estatus=1 
				ORDER BY producto_type, producto_name ASC";
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
				$consulta_datos="SELECT * FROM company WHERE producto_type = '$busqueda' 
				ORDER BY producto_type";
			}
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			return $datos;
			exit();
		}

		/*----------  Controlador eliminar company  ----------*/
		public function eliminarProductoControlador(){

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

		    $eliminarCompany=$this->eliminarRegistro("company","control_id",$id);

		    if($eliminarCompany->rowCount()==1){

		    	if(is_file("../views/fotos/company/".$datos['control_foto'])){
		            chmod("../views/fotos/company/".$datos['control_foto'],0777);
		            unlink("../views/fotos/company/".$datos['control_foto']);
		        }

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Item de la tabla de Company eliminado",
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
		public function actualizarProductoControlador(){
			# Almacenando datos#
			$producto_id=$this->limpiarCadena($_POST['producto_id']);
		    $producto_email = $this->limpiarCadena($_POST['producto_email']);
			$producto_name = $this->limpiarCadena($_POST['producto_name']);
		    $producto_type = $this->limpiarCadena($_POST['producto_type']);
			$producto_user = $this->limpiarCadena($_POST['producto_user']);
			$producto_membresia = $this->limpiarCadena($_POST['producto_membresia']);
			$producto_market_cat = $this->limpiarCadena($_POST['producto_market_cat']);
		    $producto_description = $this->limpiarCadena($_POST['producto_description']);
		    $producto_address = $this->limpiarCadena($_POST['producto_address']);
		    $producto_country = $this->limpiarCadena($_POST['producto_country']);
		    $producto_state = $this->limpiarCadena($_POST['producto_state']);
			$producto_city = $this->limpiarCadena($_POST['producto_city']);
			$producto_email = $this->limpiarCadena($_POST['producto_email']);
			$producto_estatus = $this->limpiarCadena($_POST['producto_estatus']);
			$producto_phone = $this->limpiarCadena($_POST['producto_phone']);
			$producto_rif = $this->limpiarCadena($_POST['producto_rif']);
			//$producto_city = 0;
			
		    # Verificando campos obligatorios 
		    if($producto_name=="" || $producto_type=="" || $producto_email=="" || $producto_description=="" 
			|| $producto_address=="" || $producto_country=="" || $producto_id == "" 
			|| $producto_state=="" || $producto_city=="" || $producto_estatus=="" || $producto_phone=="" 
			|| $producto_rif=="" || $producto_membresia == "" || $producto_market_cat == ""
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

			if($this->verificarDatos("[0-9$-]{7,100}",$producto_phone)){
		    	$alerta=[
				"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El TELEFONO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			
			if(!filter_var($producto_email, FILTER_VALIDATE_EMAIL)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error en la entrada de datos",
					"texto"=>"Ha ingresado un correo electrónico no valido",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			} 
			
		    $producto_datos_reg=[
				[
					"campo_nombre"=>"producto_name",
					"campo_marcador"=>":Producto_name",
					"campo_valor"=>$producto_name
				],
				[
					"campo_nombre"=>"producto_email",
					"campo_marcador"=>":Producto_email",
					"campo_valor"=>$producto_email
				],
				[
					"campo_nombre"=>"producto_description",
					"campo_marcador"=>":Producto_description",
					"campo_valor"=>$producto_description
				],
				[
					"campo_nombre"=>"producto_address",
					"campo_marcador"=>":Producto_address",
					"campo_valor"=>$producto_address
				],
				[
					"campo_nombre"=>"producto_membresia",
					"campo_marcador"=>":Producto_membresia",
					"campo_valor"=>$producto_membresia
				],
				[
					"campo_nombre"=>"producto_membresia",
					"campo_marcador"=>":Producto_membresia",
					"campo_valor"=>$producto_membresia
				],
				[
					"campo_nombre"=>"producto_market_cat",
					"campo_marcador"=>":Producto_market_cat",
					"campo_valor"=>$producto_market_cat
				],
				[
					"campo_nombre"=>"producto_phone",
					"campo_marcador"=>":Producto_phone",
					"campo_valor"=>$producto_phone
				],
				[
					"campo_nombre"=>"producto_rif",
					"campo_marcador"=>":Producto_rif",
					"campo_valor"=>$producto_rif
				],
				[
					"campo_nombre"=>"producto_country",
					"campo_marcador"=>":Producto_country",
					"campo_valor"=>$producto_country
				],
				[
					"campo_nombre"=>"producto_state",
					"campo_marcador"=>":Producto_state",
					"campo_valor"=>$producto_state
				],
				[
					"campo_nombre"=>"producto_city",
					"campo_marcador"=>":Producto_city",
					"campo_valor"=>$producto_city
				],
				[
					"campo_nombre"=>"producto_user",
					"campo_marcador"=>":Producto_user",
					"campo_valor"=>$producto_user
				]
			];
			$condicion=[
				"condicion_campo"=>"producto_id",
				"condicion_marcador"=>":Producto_id",
				"condicion_valor"=>$producto_id
			];

			//return json_encode($producto_datos_reg);
			//exit();

			if($this->actualizarDatos("company", $producto_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Company actualizado",
				"texto"=>"Los datos de la tabla de control ".$producto_name." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de la tabla de control ".$producto_name.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}

		/*----------  Controlador actualizar company  ----------*/
		public function actualizarMasInformacionControlador(){
			# Almacenando datos#
			$producto_id=$this->limpiarCadena($_POST['producto_id']);
			$producto_iva = $this->limpiarCadena($_POST['producto_iva']);
			$producto_red1 = $this->limpiarCadena($_POST['producto_red1']);
			$producto_red_valor1 = $this->limpiarCadena($_POST['producto_red_valor1']);
			$producto_red2 = $this->limpiarCadena($_POST['producto_red2']);
			$producto_red_valor2 = $this->limpiarCadena($_POST['producto_red_valor2']);
			$producto_red3 = $this->limpiarCadena($_POST['producto_red3']);
			$producto_red_valor3 = $this->limpiarCadena($_POST['producto_red_valor3']);
		    $producto_slogan = $this->limpiarCadena($_POST['producto_slogan']);
		    $producto_web = $this->limpiarCadena($_POST['producto_web']);
		    $producto_servicio_email = $this->limpiarCadena($_POST['producto_servicio_email']);
			$producto_servicio_email_envio = $this->limpiarCadena($_POST['producto_servicio_email_envio']);
			$producto_servicio_email_password = $this->limpiarCadena($_POST['producto_servicio_email_password']);
			$producto_servicio_email_puerto = $this->limpiarCadena($_POST['producto_servicio_email_puerto']);
			$producto_youtube_index = $this->limpiarCadena($_POST['producto_youtube_index']);
		    $producto_logo_witdh= $this->limpiarCadena($_POST['producto_logo_witdh']);
			$producto_logo_height= $this->limpiarCadena($_POST['producto_logo_height']);
			# Verificando campos obligatorios 
		    if($producto_red1=="" || $producto_red_valor1=="" || $producto_red2=="" || $producto_iva=="" 
			|| $producto_red_valor2=="" || $producto_red3=="" || $producto_red_valor3==""
			|| $producto_web=="" || $producto_slogan=="" || $producto_youtube_index=="" 
			|| $producto_logo_witdh==""|| $producto_logo_height=="" 
			|| $producto_servicio_email=="" || $producto_servicio_email_envio=="" 
			|| $producto_servicio_email_password=="" || $producto_servicio_email_puerto=="" 
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
			
			if(!filter_var($producto_servicio_email_envio, FILTER_VALIDATE_EMAIL)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error en la entrada de datos",
					"texto"=>"Ha ingresado un correo electrónico no valido",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			} 
			
			//return json_encode($producto_iva);
			//exit();

		    $producto_datos_reg=[
				[
					"campo_nombre"=>"producto_red1",
					"campo_marcador"=>":Producto_red1",
					"campo_valor"=>$producto_red1
				],
				[
					"campo_nombre"=>"producto_iva",
					"campo_marcador"=>":Producto_iva",
					"campo_valor"=>$producto_iva
				],
				[
					"campo_nombre"=>"producto_red2",
					"campo_marcador"=>":Producto_red2",
					"campo_valor"=>$producto_red2
				],
				[
					"campo_nombre"=>"producto_red3",
					"campo_marcador"=>":Producto_red3",
					"campo_valor"=>$producto_red3
				],
				[
					"campo_nombre"=>"producto_red_valor1",
					"campo_marcador"=>":Producto_red_valor1",
					"campo_valor"=>$producto_red_valor1
				],
				[
					"campo_nombre"=>"producto_red_valor2",
					"campo_marcador"=>":Producto_valor2",
					"campo_valor"=>$producto_red_valor2
				],
				[
					"campo_nombre"=>"producto_red_valor3",
					"campo_marcador"=>":Producto_red_valor3",
					"campo_valor"=>$producto_red_valor3
				],
				[
					"campo_nombre"=>"producto_web",
					"campo_marcador"=>":Producto_web",
					"campo_valor"=>$producto_web
				],
				[
					"campo_nombre"=>"producto_slogan",
					"campo_marcador"=>":Producto_slogan",
					"campo_valor"=>$producto_slogan
				],
				[
					"campo_nombre"=>"producto_logo_witdh",
					"campo_marcador"=>":Producto_logo_witdh",
					"campo_valor"=>$producto_logo_witdh
				],
				[
					"campo_nombre"=>"producto_logo_height",
					"campo_marcador"=>":Producto_logo_height",
					"campo_valor"=>$producto_logo_height
				],
				[
					"campo_nombre"=>"producto_youtube_index",
					"campo_marcador"=>":Producto_youtube_index",
					"campo_valor"=>$producto_youtube_index
				],
				[
					"campo_nombre"=>"producto_servicio_email",
					"campo_marcador"=>":Producto_servicio_email",
					"campo_valor"=>$producto_servicio_email
				],
				[
					"campo_nombre"=>"producto_servicio_email_envio",
					"campo_marcador"=>":Producto_servicio_email_envio",
					"campo_valor"=>$producto_servicio_email_envio
				],
				[
					"campo_nombre"=>"producto_servicio_email_password",
					"campo_marcador"=>":Producto_servicio_email_password",
					"campo_valor"=>$producto_servicio_email_password
				],
				[
					"campo_nombre"=>"producto_servicio_email_puerto",
					"campo_marcador"=>":Producto_servicio_email_puerto",
					"campo_valor"=>$producto_servicio_email_puerto
				]
			];
			$condicion=[
				"condicion_campo"=>"producto_id",
				"condicion_marcador"=>":Producto_id",
				"condicion_valor"=>$producto_id
			];

			if($this->actualizarDatos("company", $producto_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Company actualizado",
				"texto"=>"Los datos de información adicional ".$producto_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de información adicional ".$producto_id.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}

		/*----------  Controlador actualizar company  ----------*/
		public function actualizarZonaHorariaControlador(){
			$producto_id=$this->limpiarCadena($_POST['producto_id']);
			$dia_semana = $this->limpiarCadena($_POST['dia_semana']);
			$hora_desde = $this->limpiarCadena($_POST['hora_desde']);
			$hora_hasta = $this->limpiarCadena($_POST['hora_hasta']);
			$aplica_submit = $this->limpiarCadena($_POST['submit']);
			$producto_horario_desde = explode("|", $this->limpiarCadena($_POST['producto_horario_desde']));
			$producto_horario_hasta = explode("|", $this->limpiarCadena($_POST['producto_horario_hasta']));
			//return json_encode($producto_horario_hasta);
		    //exit();
			$vector_desde = [];
			$vector_hasta = [];
			//
			if($dia_semana=="" || $hora_desde=="" || $hora_hasta=="" 
			|| $producto_horario_desde=="" || $producto_horario_hasta=="") {
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
						$vector_desde[$i] = $producto_horario_desde[$i];
						$vector_hasta[$i] = $producto_horario_hasta[$i];
					}
					$cadena_desde = $cadena_desde . "|". $vector_desde[$i];
					$cadena_hasta = $cadena_hasta . "|". $vector_hasta[$i];
				}
				$cadena_desde = substr($cadena_desde, 1, 100);
				$cadena_hasta = substr($cadena_hasta, 1, 100);
				//echo $cadena; //retorna 1,5,9,6,8
				$producto_datos_reg=[
					[
						"campo_nombre"=>"producto_horario_desde",
						"campo_marcador"=>":Producto_horario_desde",
						"campo_valor"=>$cadena_desde
					],
					[
						"campo_nombre"=>"producto_horario_hasta",
						"campo_marcador"=>":Producto_horario_hasta",
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
				$producto_datos_reg=[
					[
						"campo_nombre"=>"producto_horario_desde",
						"campo_marcador"=>":Producto_horario_desde",
						"campo_valor"=>$cadena_desde
					],
					[
						"campo_nombre"=>"producto_horario_hasta",
						"campo_marcador"=>":Producto_horario_hasta",
						"campo_valor"=>$cadena_hasta
					]
				];
			}

			$condicion=[
				"condicion_campo"=>"producto_id",
				"condicion_marcador"=>":Producto_id",
				"condicion_valor"=>$producto_id
			];

			if($this->actualizarDatos("company", $producto_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Company actualizado",
				"texto"=>"Los datos de información adicional ".$producto_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de información adicional ".$producto_id.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}

		/*----------  Controlador actualizar company  ----------*/
		public function actualizarMarketControlador(){
			$producto_id=$this->limpiarCadena($_POST['producto_id']);
			$market_cat = $_POST['market_cat'];
			$aplica_submit = $this->limpiarCadena($_POST['submit']);
			$cadena="";
			
			if($market_cat=="" || $producto_id=="" || $aplica_submit=="" ) {
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al actualizar registro",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			if($aplica_submit != "agregar"){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error en la entrada de datos",
					"texto"=>"Debe presioar el button tipo de acción actualizar",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}
			for ($i=0;$i<count($market_cat);$i++)
			{
				$cadena = $cadena . "|". $market_cat[$i];
			}
			
			$cadena = substr($cadena, 1, 100);
			//echo $cadena; //retorna 1,5,9,6,8
			$producto_datos_reg=[
				[
					"campo_nombre"=>"producto_market_cat",
					"campo_marcador"=>":Producto_market_cat",
					"campo_valor"=>$cadena
				]
			];

			$condicion=[
				"condicion_campo"=>"producto_id",
				"condicion_marcador"=>":Producto_id",
				"condicion_valor"=>$producto_id
			];

			if($this->actualizarDatos("company", $producto_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Company actualizado",
				"texto"=>"Los datos de Categoria de market ".$producto_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de categoria de market ".$producto_id.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}
		/*----------  Controlador actualizar company  ----------*/
		public function actualizarUbicacionControlador(){
			$producto_id=$this->limpiarCadena($_POST['producto_id']);
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

			$producto_datos_reg=[
				[
					"campo_nombre"=>"producto_latitude",
					"campo_marcador"=>":Producto_latitude",
					"campo_valor"=>$latitude
				],
				[
					"campo_nombre"=>"producto_longitude",
					"campo_marcador"=>":Producto_longitude",
					"campo_valor"=>$longitude
				]
			];

			$condicion=[
				"condicion_campo"=>"producto_id",
				"condicion_marcador"=>":Producto_id",
				"condicion_valor"=>$producto_id
			];

			if($this->actualizarDatos("company", $producto_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Company actualizado",
				"texto"=>"Los datos de ubicación ".$producto_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de información adicional ".$producto_id.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}

		/*----------  Controlador eliminar foto company  ----------*/
		public function eliminarFotoProductoControlador(){

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
		public function actualizarFotoProductoControlador(){
			$id = $this->limpiarCadena($_POST['producto_id']);
			$producto_tipo = $this->limpiarCadena($_POST['producto_tipo']);

			# Verificando company #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company WHERE producto_id='$id'");
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
    		if($_FILES['producto_logo']['name']!="" && $_FILES['producto_logo']['size']>0){
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
		        if(mime_content_type($_FILES['producto_logo']['tmp_name'])!="image/jpeg" 
				&& mime_content_type($_FILES['producto_logo']['tmp_name'])!="image/png"){
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
		        if(($_FILES['producto_logo']['size']/1024)>5120){
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
		        $foto=str_ireplace(" ","_",$producto_tipo."-".$id);
		        
				$foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['producto_logo']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }
		        
				chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['producto_logo']['tmp_name'],$img_dir.$foto)){
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
					"campo_nombre"=>$producto_tipo,
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				]
			];

			$condicion=[
				"condicion_campo"=>"producto_id",
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
			$id = $this->limpiarCadena($_POST['producto_id']);
			# Verificando company #
			
			$datos=$this->ejecutarConsulta("SELECT * FROM company WHERE producto_id='$id'");
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
						$array[$i] = "producto_card";
					}elseif($i == 1){
						$array[$i] = "producto_banner1";
					}elseif($i == 2){
						$array[$i] = "producto_banner2";
					}elseif($i == 3){	
						$array[$i] = "producto_banner3";
					}elseif($i == 4){	
						$array[$i] = "producto_pdf";
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
						if(($i==4 && $_FILES['archivo']['size'][$i]/1024)>150120){
							$alerta=[
								"tipo"=>"simple",
								"titulo"=>"Ocurrió un error inesperado",
								"texto"=>"El archivo PDF supera el peso permitido (hasta 1500K)",
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
						"condicion_campo"=>"producto_id",
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