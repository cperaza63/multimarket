<?php

	namespace app\controllers;
	use app\models\mainModel; 

	class userController extends mainModel{

		/*----------  Controlador registrar usuario  ----------*/
		public function registrarUsuarioControlador(){

			return json_encode("regstrar usuario");
			
			# Almacenando datos#
		    $nombre=$this->limpiarCadena($_POST['usuario_nombre']);
		    $apellido=$this->limpiarCadena($_POST['usuario_apellido']);

		    $usuario=$this->limpiarCadena($_POST['login']);
		    $email=$this->limpiarCadena($_POST['usuario_email']);
		    $clave1=$this->limpiarCadena($_POST['usuario_clave_1']);
		    $clave2=$this->limpiarCadena($_POST['usuario_clave_2']);

		    $caja=$this->limpiarCadena($_POST['usuario_caja']);


		    # Verificando campos obligatorios #
		    if($nombre=="" || $apellido=="" || $usuario=="" || $clave1=="" || $clave2==""){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificando integridad de los datos #
		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El APELLIDO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-Z0-9]{4,20}",$usuario)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El USUARIO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave1) || $this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave2)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Las CLAVES no coinciden con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificando email #
		    if($email!=""){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$check_email=$this->ejecutarConsulta("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
					if($check_email->rowCount()>0){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"2 que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
							"icono"=>"error"
						];
						return json_encode($alerta);
						exit();
					}
				}else{
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Ha ingresado un correo electrónico no valido",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}
            }

            # Verificando claves #
            if($clave1!=$clave2){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Las contraseñas que acaba de ingresar no coinciden, por favor verifique e intente nuevamente",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}else{
				$clave=password_hash($clave1,PASSWORD_BCRYPT,["cost"=>10]);
            }

            # Verificando usuario #
		    $check_usuario=$this->ejecutarConsulta("SELECT login FROM usuario WHERE login='$usuario'");
		    if($check_usuario->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El USUARIO ingresado ya se encuentra registrado, por favor elija otro",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificando caja #
		    $check_caja=$this->ejecutarConsulta("SELECT caja_id FROM caja WHERE caja_id='$caja'");
		    if($check_caja->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La caja seleccionada no existe en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/fotos/";

    		# Comprobar si se selecciono una imagen #
    		if($_FILES['usuario_foto']['name']!="" && $_FILES['usuario_foto']['size']>0){

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
		        if(mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/png"){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La imagen que ha seleccionado es de un formato no permitido",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }

		        # Verificando peso de imagen #
		        if(($_FILES['usuario_foto']['size']/1024)>5120){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La imagen que ha seleccionado supera el peso permitido",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }

		        # Nombre de la foto #
		        $foto=str_ireplace(" ","_",$nombre);
		        $foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['usuario_foto']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }

		        chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['usuario_foto']['tmp_name'],$img_dir.$foto)){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"No podemos subir la imagen al sistema en este momento",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }

    		}else{
    			$foto="";
    		}


		    $usuario_datos_reg=[
				[
					"campo_nombre"=>"usuario_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"usuario_apellido",
					"campo_marcador"=>":Apellido",
					"campo_valor"=>$apellido
				],
				[
					"campo_nombre"=>"login",
					"campo_marcador"=>":Usuario",
					"campo_valor"=>$usuario
				],
				[
					"campo_nombre"=>"usuario_email",
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				[
					"campo_nombre"=>"usuario_clave",
					"campo_marcador"=>":Clave",
					"campo_valor"=>$clave
				],
				[
					"campo_nombre"=>"usuario_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				],
				[
					"campo_nombre"=>"caja_id",
					"campo_marcador"=>":Caja",
					"campo_valor"=>$caja
				]
			];

			$registrar_usuario=$this->guardarDatos("usuario",$usuario_datos_reg);

			if($registrar_usuario->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Usuario registrado",
					"texto"=>"El usuario ".$nombre." ".$apellido." se registro con exito",
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
					"texto"=>"No se pudo registrar el usuario, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}

				/*----------  Controlador registrar usuario  ----------*/
		public function actualizarPasswordControlador(){
		# Almacenando datos#
		
		$user_id=$this->limpiarCadena($_POST['user_id']);
		$clave=$this->limpiarCadena($_POST['old_password']);
		$clave1=$this->limpiarCadena($_POST['new_password']);
		$clave2=$this->limpiarCadena($_POST['repeat_password']);
		# Verificando campos obligatorios #
		if( $clave=="" || $clave1=="" || $clave2==""){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No has llenado todos los campos que son obligatorios",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}
		# Verificando usuario #
		$check_usuario=$this->ejecutarConsulta("SELECT login FROM usuario WHERE user_id = $user_id and password = '$clave'");
		if($check_usuario->rowCount()>0){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"El USUARIO ingresado ya se encuentra registrado, por favor elija otro",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}
		
		# Verificando integridad de los datos #
		if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$clave1)){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"El nueva clave no coincide con el formato solicitado",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}

		if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$clave2)){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"El clave confirmacion no coincide con el formato solicitado",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}

		# Verificando claves #
		if($clave1!=$clave2){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"Las contraseñas que acaba de ingresar no coinciden, por favor verifique e intente nuevamente",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}else{
			$clave=password_hash($clave1,PASSWORD_BCRYPT,["cost"=>10]);
		}

		$usuario_datos_reg=[
			[
				"campo_nombre"=>"usuario_nombre",
				"campo_marcador"=>":Nombre",
				"campo_valor"=>$clave
			],
			[
				"campo_nombre"=>"password",
				"campo_marcador"=>":Apellido",
				"campo_valor"=>$clave1
			]
		];

		$registrar_usuario=$this->guardarDatos("usuario",$usuario_datos_reg);

		if($registrar_usuario->rowCount()==1){
			$alerta=[
				"tipo"=>"limpiar",
				"titulo"=>"Usuario registrado",
				"texto"=>"El usuario se registro con exito",
				"icono"=>"success"
			];
		}else{
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No se pudo cambiar la clave el usuario, por favor intente nuevamente",
				"icono"=>"error"
			];
		}

		return json_encode($alerta);
	}

		/*----------  Controlador listar usuario  ----------*/
		public function listarUsuarioControlador($pagina,$registros,$url,$busqueda){

			$pagina=$this->limpiarCadena($pagina);
			$registros=$this->limpiarCadena($registros);

			$url=$this->limpiarCadena($url);
			$url=APP_URL.$url."/";

			$busqueda=$this->limpiarCadena($busqueda);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){

				$consulta_datos="SELECT * FROM usuario WHERE ((usuario_id!='".$_SESSION['id']."' AND usuario_id!='1') AND (usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_email LIKE '%$busqueda%' OR login LIKE '%$busqueda%')) ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(usuario_id) FROM usuario WHERE ((usuario_id!='".$_SESSION['id']."' AND usuario_id!='1') AND (usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_email LIKE '%$busqueda%' OR login LIKE '%$busqueda%'))";

			}else{

				$consulta_datos="SELECT * FROM usuario WHERE usuario_id!='".$_SESSION['id']."' AND usuario_id!='1' ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(usuario_id) FROM usuario WHERE usuario_id!='".$_SESSION['id']."' AND usuario_id!='1'";

			}
            
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();

			$total = $this->ejecutarConsulta($consulta_total);
			$total = (int) $total->fetchColumn();

			$numeroPaginas =ceil($total/$registros);

			$tabla.='
		        <div class="table-container">
		        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
		            <thead>
		                <tr>
		                    <th class="has-text-centered">#</th>
		                    <th class="has-text-centered">Nombre</th>
		                    <th class="has-text-centered">Usuario</th>
		                    <th class="has-text-centered">Email</th>
		                    <th class="has-text-centered">Foto</th>
		                    <th class="has-text-centered">Actualizar</th>
		                    <th class="has-text-centered">Eliminar</th>
		                </tr>
		            </thead>
		            <tbody>
		    ';

		    if($total>=1 && $pagina<=$numeroPaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){
					$tabla.='
						<tr class="has-text-centered" >
							<td>'.$contador.'</td>
							<td>'.$rows['usuario_nombre'].' '.$rows['usuario_apellido'].'</td>
							<td>'.$rows['login'].'</td>
							<td>'.$rows['usuario_email'].'</td>
							<td>
			                    <a href="'.APP_URL.'userPhoto/'.$rows['usuario_id'].'/" class="button is-info is-rounded is-small">
			                    	<i class="fas fa-camera fa-fw"></i>
			                    </a>
			                </td>
			                <td>
			                    <a href="'.APP_URL.'userUpdate/'.$rows['usuario_id'].'/" class="button is-success is-rounded is-small">
			                    	<i class="fas fa-sync fa-fw"></i>
			                    </a>
			                </td>
			                <td>
			                	<form class="FormularioAjax" action="'.APP_URL.'app/ajax/usuarioAjax.php" method="POST" autocomplete="off" >

			                		<input type="hidden" name="modulo_usuario" value="eliminar">
			                		<input type="hidden" name="usuario_id" value="'.$rows['usuario_id'].'">

			                    	<button type="submit" class="button is-danger is-rounded is-small">
			                    		<i class="far fa-trash-alt fa-fw"></i>
			                    	</button>
			                    </form>
			                </td>
						</tr>
					';
					$contador++;
				}
				$pag_final=$contador-1;
			}else{
				if($total>=1){
					$tabla.='
						<tr class="has-text-centered" >
			                <td colspan="7">
			                    <a href="'.$url.'1/" class="button is-link is-rounded is-small mt-4 mb-4">
			                        Haga clic acá para recargar el listado
			                    </a>
			                </td>
			            </tr>
					';
				}else{
					$tabla.='
						<tr class="has-text-centered" >
			                <td colspan="7">
			                    No hay registros en el sistema
			                </td>
			            </tr>
					';
				}
			}

			$tabla.='</tbody></table></div>';

			### Paginacion ###
			if($total>0 && $pagina<=$numeroPaginas){
				$tabla.='<p class="has-text-right">Mostrando usuarios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';

				$tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7);
			}

			return $tabla;
		}

		/*----------  Controlador eliminar usuario  ----------*/
		public function eliminarUsuarioControlador(){

			$id=$this->limpiarCadena($_POST['usuario_id']);

			if($id==1){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar el usuario principal del sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Verificando ventas #
		    $check_ventas=$this->ejecutarConsulta("SELECT usuario_id FROM venta WHERE usuario_id='$id' LIMIT 1");
		    if($check_ventas->rowCount()>0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar el usuario del sistema ya que tiene ventas asociadas",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $eliminarUsuario=$this->eliminarRegistro("usuario","usuario_id",$id);

		    if($eliminarUsuario->rowCount()==1){

		    	if(is_file("../views/fotos/".$datos['usuario_foto'])){
		            chmod("../views/fotos/".$datos['usuario_foto'],0777);
		            unlink("../views/fotos/".$datos['usuario_foto']);
		        }

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Usuario eliminado",
					"texto"=>"El usuario ".$datos['usuario_nombre']." ".$datos['usuario_apellido']." ha sido eliminado del sistema correctamente",
					"icono"=>"success"
				];

		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar el usuario ".$datos['usuario_nombre']." ".$datos['usuario_apellido']." del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }

		    return json_encode($alerta);
		}

		/*----------  Controlador actualizar usuario  ----------*/
		public function actualizarUsuarioControlador(){

			$user_id=$this->limpiarCadena($_POST['user_id']);
			$login = $this->limpiarCadena($_POST['login']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM usuario WHERE user_id='$user_id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
			}
		    
			if($this->verificarDatos("[a-zA-Z0-9]{4,20}",$login)){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al registrar Usuario",
					"texto"=>"El login no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			# Almacenando datos#
		    $firstname=$this->limpiarCadena($_POST['firstname']);
		    $lastname=$this->limpiarCadena($_POST['lastname']);
		    $email=$this->limpiarCadena($_POST['email']);
		    $tcarea=$this->limpiarCadena($_POST['tcarea']);
		    $tcnumber=$this->limpiarCadena($_POST['tcnumber']);
		    $tipo=$this->limpiarCadena($_POST['tipo']);
			$city=$this->limpiarCadena($_POST['city']);
			$state=$this->limpiarCadena($_POST['state']);
			$country=$this->limpiarCadena($_POST['country']);
			$departamento=$this->limpiarCadena($_POST['departamento']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			$location=$this->limpiarCadena($_POST['location']);
			$gender=$this->limpiarCadena($_POST['gender']);
			$rif=$this->limpiarCadena($_POST['rif']);

		    # Verificando campos obligatorios #
		    if($firstname=="" || $lastname=="" || $email=="" || $tcarea=="" || $tcnumber=="" 
			|| $tipo=="" || $city==""|| $state==""|| $country=="" || $departamento=="" || $company_id=="" 
			|| $tcarea=="" || $tcnumber==""|| $location ==""|| $country=="" || $gender=="" || $rif=="" 
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

			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error el la entrada de datos",
					"texto"=>"Ha ingresado un correo electrónico no valido",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}
			if($email!="" && $datos['email']!=$email){
				$check_email=$this->ejecutarConsulta("SELECT email FROM usuario WHERE email='$email'");
				if($check_email->rowCount()>0){
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El EMAIL 1 que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
						"icono"=>"error"
						];
					return json_encode($alerta);
					exit();
				}
			} 

		    # Verificando integridad de los datos #
		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$firstname)){
		         $alerta=[
			 		"tipo"=>"simple",
			 		"titulo"=>"Ocurrió un error inesperado",
			 		"texto"=>"El NOMBRE no coincide con el formato solicitado",
			 		"icono"=>"error"
			 	];
			 	return json_encode($alerta);
		         exit();
		    }

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$lastname)){
		         $alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"El APELLIDO no coincide con el formato solicitado",
				"icono"=>"error"
				];
				return json_encode($alerta);
		    	exit();
		    }

			if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,80}",$departamento)){
		    	$alerta=[
				"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El DEPARTAMENTO... no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

            $usuario_datos_up=[
				[
					"campo_nombre"=>"login",
					"campo_marcador"=>":Login",
					"campo_valor"=>$login
				],
				[
					"campo_nombre"=>"email",
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				[
					"campo_nombre"=>"firstname",
					"campo_marcador"=>":Firstname",
					"campo_valor"=>$firstname
				],
				[
					"campo_nombre"=>"lastname",
					"campo_marcador"=>":Lastname",
					"campo_valor"=>$lastname
				],
				[
					"campo_nombre"=>"tcarea",
					"campo_marcador"=>":Tcarea",
					"campo_valor"=>$tcarea
				],
				[
					"campo_nombre"=>"tcnumber",
					"campo_marcador"=>":Tcnumber",
					"campo_valor"=>$tcnumber
				],
				[
					"campo_nombre"=>"tipo",
					"campo_marcador"=>":Tipo",
					"campo_valor"=>$tipo
				],
				[
					"campo_nombre"=>"city",
					"campo_marcador"=>":City",
					"campo_valor"=>$city
				],

				[
					"campo_nombre"=>"state",
					"campo_marcador"=>":State",
					"campo_valor"=>$state
				],
				[
					"campo_nombre"=>"country",
					"campo_marcador"=>":Country",
					"campo_valor"=>$country
				],
				[
					"campo_nombre"=>"departamento",
					"campo_marcador"=>":Departamento",
					"campo_valor"=>$departamento
				],
				[
					"campo_nombre"=>"company_id",
					"campo_marcador"=>":Company_id",
					"campo_valor"=>$company_id
				],
				[
					"campo_nombre"=>"country",
					"campo_marcador"=>":Country",
					"campo_valor"=>$country
				],
				[
					"campo_nombre"=>"location",
					"campo_marcador"=>":Location",
					"campo_valor"=>$location
				],
				[
					"campo_nombre"=>"gender",
					"campo_marcador"=>":Gender",
					"campo_valor"=>$gender
				],
				[
					"campo_nombre"=>"rif",
					"campo_marcador"=>":Rif",
					"campo_valor"=>$rif
				]
			];

			$condicion=[
				"condicion_campo"=>"user_id",
				"condicion_marcador"=>":User_id",
				"condicion_valor"=>$user_id
			];

			if($this->actualizarDatos("usuario", $usuario_datos_up, $condicion)){

				if($user_id == $_SESSION['id']){
					$_SESSION['nombre']=$firstname;
					$_SESSION['apellido']=$lastname;
					$_SESSION['usuario']=$login;
			}

			$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Usuario actualizado",
				"texto"=>"Los datos del usuario ".$datos['firstname']." ".$datos['lastname']." se actualizaron correctamente",
				"icono"=>"success"
			];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos del usuario ".$datos['firstname']." ".$datos['lastname'].", por favor intente nuevamente",
				"icono"=>"error"
			];
			}

			return json_encode($alerta);
		}

		/*----------  Controlador eliminar foto usuario  ----------*/
		public function eliminarFotoUsuarioControlador(){

			$id=$this->limpiarCadena($_POST['usuario_id']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/fotos/";

    		chmod($img_dir,0777);

    		if(is_file($img_dir.$datos['usuario_foto'])){

		        chmod($img_dir.$datos['usuario_foto'],0777);

		        if(!unlink($img_dir.$datos['usuario_foto'])){
		            $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Error al intentar eliminar la foto del usuario, por favor intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        	exit();
		        }
		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la foto del usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $usuario_datos_up=[
				[
					"campo_nombre"=>"usuario_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>""
				]
			];

			$condicion=[
				"condicion_campo"=>"usuario_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("usuario",$usuario_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']="";
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"La foto del usuario ".$datos['usuario_nombre']." ".$datos['usuario_apellido']." se elimino correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"No hemos podido actualizar algunos datos del usuario ".$datos['usuario_nombre']." ".$datos['usuario_apellido'].", sin embargo la foto ha sido eliminada correctamente",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}

		/*----------  Controlador actualizar foto usuario  ----------*/
		public function actualizarFotoUsuarioControlador(){

			//return json_encode($_POST['usuario_id']);
			//exit;

			$id = $this->limpiarCadena($_POST['usuario_id']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM usuario WHERE user_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

			# Directorio de imagenes #
    		$img_dir="../views/fotos/";

    		# Comprobar si se selecciono una imagen #
    		if($_FILES['usuario_foto']['name']=="" && $_FILES['usuario_foto']['size']<=0){
    			$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No ha seleccionado una foto para el usuario",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
    		}

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
	        if(mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/png"){
	            $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La imagen que ha seleccionado es de un formato no permitido",
					"icono"=>"error"
				];
				return json_encode($alerta);
	            exit();
	        }

	        # Verificando peso de imagen #
	        if(($_FILES['usuario_foto']['size']/1024)>5120){
	            $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La imagen que ha seleccionado supera el peso permitido",
					"icono"=>"error"
				];
				return json_encode($alerta);
	            exit();
	        }

	        # Nombre de la foto #
	        if($datos['usuario_foto']!=""){
		        $foto=explode(".", $datos['usuario_foto']);
		        $foto=$foto[0];
	        }else{
	        	$foto=str_ireplace(" ","_",$datos['firstname']);
	        	$foto=$foto."_".rand(0,100);
	        }
	        

	        # Extension de la imagen #
	        switch(mime_content_type($_FILES['usuario_foto']['tmp_name'])){
	            case 'image/jpeg':
	                $foto=$foto.".jpg";
	            break;
	            case 'image/png':
	                $foto=$foto.".png";
	            break;
	        }

	        chmod($img_dir,0777);

	        # Moviendo imagen al directorio #
	        if(!move_uploaded_file($_FILES['usuario_foto']['tmp_name'],$img_dir.$foto)){
	            $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos subir la imagen al sistema en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
	            exit();
	        }

	        # Eliminando imagen anterior #
	        if(is_file($img_dir.$datos['usuario_foto']) && $datos['usuario_foto']!=$foto){
		        chmod($img_dir.$datos['usuario_foto'], 0777);
		        unlink($img_dir.$datos['usuario_foto']);
		    }

		    $usuario_datos_up=[
				[
					"campo_nombre"=>"usuario_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				]
			];

			$condicion=[
				"condicion_campo"=>"user_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("usuario",$usuario_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']=$foto;
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"La foto del usuario ".$datos['firstname']." ".$datos['lastname']." se actualizo correctamente",
					"icono"=>"success"
				];
			}else{

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"No hemos podido actualizar algunos datos del usuario ".$datos['firstname']." ".$datos['lastname']." , sin embargo la foto ha sido actualizada",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}

	}