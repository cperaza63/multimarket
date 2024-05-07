<?php

	namespace app\controllers;
	use app\models\mainModel; 

	class companyController extends mainModel{

		/*----------  Controlador registrar company  ----------*/
		public function registrarCompanyControlador(){

			//return json_encode("regstrar company");
			
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
			$clave1=$this->limpiarCadena($_POST['new_password']);
			$clave2=$this->limpiarCadena($_POST['repeat_password']);
			$dateofbirth=$this->limpiarCadena($_POST['dateofbirth']);
			$created_at = date("Y-m-d");

		    # Verificando campos obligatorios #
		    if($firstname=="" || $lastname=="" || $email=="" || $tcarea=="" || $tcnumber=="" 
			|| $tipo=="" || $city==""|| $state==""|| $country=="" || $departamento=="" || $company_id=="" 
			|| $tcarea=="" || $tcnumber==""|| $location ==""|| $country=="" || $gender=="" || $rif=="" 
			|| $clave1=="" || $clave2=="" || $dateofbirth==""
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
					"titulo"=>"Error en la entrada de datos",
					"texto"=>"Ha ingresado un correo electrónico no valido",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}
			
			$check_email=$this->ejecutarConsulta("SELECT email FROM company WHERE email='$email'");
			if($check_email->rowCount()>0){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El EMAIL que acaba de ingresar ya se encuentra registrado en el sistema, por favor utilice otro correo",
					"icono"=>"error"
					];
				return json_encode($alerta);
				exit();
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

            # Verificando company #
		    $check_company=$this->ejecutarConsulta("SELECT login FROM company WHERE login='$email'");
		    if($check_company->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El USUARIO ingresado ya se encuentra registrado, por favor cambie su email",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/fotos/companys/";

    		# Comprobar si se selecciono una imagen #
    		if($_FILES['company_foto']['name']!="" && $_FILES['company_foto']['size']>0){

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
		        if(mime_content_type($_FILES['company_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['company_foto']['tmp_name'])!="image/png"){
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
		        if(($_FILES['company_foto']['size']/1024)>5120){
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
		        $foto=str_ireplace(" ","_",$company_id."_".$firstname.$lastname);
		        $foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['company_foto']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }

		        chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['company_foto']['tmp_name'],$img_dir.$foto)){
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
			
		    $company_datos_reg=[
				[
					"campo_nombre"=>"login",
					"campo_marcador"=>":Login",
					"campo_valor"=>$email
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
					"campo_nombre"=>"nombre_completo",
					"campo_marcador"=>":Nombre_completo",
					"campo_valor"=>$firstname." ".$lastname
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
				],
				[
					"campo_nombre"=>"password",
					"campo_marcador"=>":Password",
					"campo_valor"=>$clave
				],
				[
					"campo_nombre"=>"company_foto",
					"campo_marcador"=>":Company_foto",
					"campo_valor"=>$foto
				],
				[
					"campo_nombre"=>"created_at",
					"campo_marcador"=>":Created_at",
					"campo_valor"=>$created_at
				],
				[
					"campo_nombre"=>"dateofbirth",
					"campo_marcador"=>":Dateofbirth",
					"campo_valor"=>$dateofbirth
				]

			];

			//return json_encode("regstrar company");

			$registrar_company=$this->guardarDatos("company",$company_datos_reg);

			if($registrar_company->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Company registrado",
					"texto"=>"El company ".$firstname." ".$lastname." se registro con exito",
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
					"texto"=>"No se pudo registrar el company, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}

		/*----------  Controlador registrar company  ----------*/
		public function actualizarPasswordControlador(){
		# Almacenando datos#
		$login=$this->limpiarCadena($_POST['login']);
		$user_id=$this->limpiarCadena($_POST['user_id']);
		$clave= $this->limpiarCadena($_POST['old_password']);
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
		if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"1 Ocurrió un error inesperado",
				"texto"=>"La CLAVE actual no coincide con el formato solicitado",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}

		# Verificando company #
		$check_company=$this->ejecutarConsulta("SELECT * FROM company WHERE login='$login'");
		if($check_company->rowCount()==1){
			$check_company=$check_company->fetch();
			if($check_company['login']==$login && password_verify($clave,$check_company['password'])){
				// pasa 
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"2 Ocurrió un error inesperado",
					"texto"=>"Company o clave incorrectos al momento de validar",
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
			$clave = password_hash($clave1,PASSWORD_BCRYPT,["cost"=>10]);
		}
		

		$check_company=$this->ejecutarConsulta("SELECT login FROM company WHERE user_id = $user_id");
		if($check_company->rowCount() == 0){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"4 Ocurrió un error al validar al company",
				"texto"=>"El USUARIO no fue encontrado, por favor revise",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}
		
		$tabla="company";
		$company_datos_reg=[
			[
				"campo_nombre"=>"password",
				"campo_marcador"=>":Password",
				"campo_valor"=>$clave
			]
		];
		$condicion=[
			"condicion_campo"=>"user_id",
			"condicion_marcador"=>":User_id",
			"condicion_valor"=>$user_id
		];
		
		$registrar_company=$this->actualizarDatos($tabla, $company_datos_reg, $condicion);

		if($registrar_company->rowCount()==1){
			$alerta=[
				"tipo"=>"limpiar",
				"titulo"=>"Clave del Company registrado",
				"texto"=>"El company se registro con exito",
				"icono"=>"success"
			];
		}else{
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No se pudo cambiar la clave el company, por favor intente nuevamente",
				"icono"=>"error"
			];
		}
		return json_encode($alerta);
	}

		/*----------  Controlador listar company  ----------*/
		public function listarCompanyControlador($pagina,$registros,$url,$busqueda){

			$pagina=$this->limpiarCadena($pagina);
			$registros=$this->limpiarCadena($registros);

			$url=$this->limpiarCadena($url);
			$url=APP_URL.$url."/";

			$busqueda=$this->limpiarCadena($busqueda);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){

				$consulta_datos="SELECT * FROM company WHERE ((company_id!='".$_SESSION['id']."' AND company_id!='1') AND (company_nombre LIKE '%$busqueda%' OR company_apellido LIKE '%$busqueda%' OR company_email LIKE '%$busqueda%' OR login LIKE '%$busqueda%')) ORDER BY company_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(company_id) FROM company WHERE ((company_id!='".$_SESSION['id']."' AND company_id!='1') AND (company_nombre LIKE '%$busqueda%' OR company_apellido LIKE '%$busqueda%' OR company_email LIKE '%$busqueda%' OR login LIKE '%$busqueda%'))";

			}else{

				$consulta_datos="SELECT * FROM company WHERE company_id!='".$_SESSION['id']."' AND company_id!='1' ORDER BY company_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(company_id) FROM company WHERE company_id!='".$_SESSION['id']."' AND company_id!='1'";

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
		                    <th class="has-text-centered">Company</th>
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
							<td>'.$rows['company_nombre'].' '.$rows['company_apellido'].'</td>
							<td>'.$rows['login'].'</td>
							<td>'.$rows['company_email'].'</td>
							<td>
			                    <a href="'.APP_URL.'userPhoto/'.$rows['company_id'].'/" class="button is-info is-rounded is-small">
			                    	<i class="fas fa-camera fa-fw"></i>
			                    </a>
			                </td>
			                <td>
			                    <a href="'.APP_URL.'userUpdate/'.$rows['company_id'].'/" class="button is-success is-rounded is-small">
			                    	<i class="fas fa-sync fa-fw"></i>
			                    </a>
			                </td>
			                <td>
			                	<form class="FormularioAjax" action="'.APP_URL.'app/ajax/companyAjax.php" method="POST" autocomplete="off" >

			                		<input type="hidden" name="modulo_company" value="eliminar">
			                		<input type="hidden" name="company_id" value="'.$rows['company_id'].'">

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
				$tabla.='<p class="has-text-right">Mostrando companys <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';

				$tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7);
			}

			return $tabla;
		}
		
		
		/*----------  Controlador listar company  ----------*/
		public function listarTodosCompanyControlador($busqueda){

			$busqueda=$this->limpiarCadena($busqueda);

			if(isset($busqueda) && $busqueda!="*"){
				$consulta_datos="SELECT * FROM company 
				WHERE ((user_id!='".$_SESSION['id']."' AND user_id!='1') 
				AND (
				concat(firstname, ' ', lastname) LIKE '%$busqueda%'
				OR concat(lastname, ' ', firstname) LIKE '%$busqueda%' 
				OR firstname LIKE '%$busqueda%' 
				OR lastname LIKE '%$busqueda%' OR email LIKE '%$busqueda%' 
				OR login LIKE '%$busqueda%')) 
				ORDER BY lastname, firstname ASC";
			}else{
				$consulta_datos="SELECT * FROM company 
				WHERE user_id!='".$_SESSION['id']."' AND user_id!='1' ORDER BY lastname ASC limit 300";
			}

			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();

			return $datos;
			exit();
		}

		/*----------  Controlador eliminar company  ----------*/
		public function eliminarCompanyControlador(){

			$id=$this->limpiarCadena($_POST['user_id']);

			//return json_encode($id);
			//exit();

			if($id==1){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar el company principal del sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			# Verificando company #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company WHERE user_id='$id' and estatus<>1");
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

		    # Verificando ventas #
		    $check_ventas=$this->ejecutarConsulta("SELECT company_id FROM venta WHERE company_id='$id' LIMIT 1");
		    if($check_ventas->rowCount()>0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar el company del sistema ya que tiene ventas asociadas",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $eliminarCompany=$this->eliminarRegistro("company","user_id",$id);

		    if($eliminarCompany->rowCount()==1){

		    	if(is_file("../views/fotos/".$datos['company_foto'])){
		            chmod("../views/fotos/".$datos['company_foto'],0777);
		            unlink("../views/fotos/".$datos['company_foto']);
		        }

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Company eliminado",
					"texto"=>"El company ".$datos['firstname']." ".$datos['lastname']." ha sido eliminado del sistema correctamente",
					"icono"=>"success"
				];

		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar el company ".$datos['firstname']." ".$datos['lastname']." del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }

		    return json_encode($alerta);
		}

		/*----------  Controlador actualizar company  ----------*/
		public function actualizarCompanyControlador(){

			$user_id=$this->limpiarCadena($_POST['user_id']);
			$login = $this->limpiarCadena($_POST['login']);

			# Verificando company #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company WHERE user_id='$user_id'");
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
		    
			if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$login)){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al registrar Company",
					"texto"=>"El login $login no coincide con el formato solicitado",
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
			$dateofbirth=$this->limpiarCadena($_POST['dateofbirth']);
			$created_at = date("Y-m-d");

		    # Verificando campos obligatorios #
		    if($firstname=="" || $lastname=="" || $email=="" || $tcarea=="" || $tcnumber=="" 
			|| $tipo=="" || $city==""|| $state==""|| $country=="" || $departamento=="" || $company_id=="" 
			|| $tcarea=="" || $tcnumber==""|| $location ==""|| $country=="" || $gender=="" || $rif=="" 
			|| $dateofbirth=="" 
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
					"titulo"=>"Error en la entrada de datos",
					"texto"=>"Ha ingresado un correo electrónico no valido",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}
			if($email!="" && $datos['email']!=$email){
				$check_email=$this->ejecutarConsulta("SELECT email FROM company WHERE email='$email'");
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

            $company_datos_up=[
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
					"campo_nombre"=>"nombre_completo",
					"campo_marcador"=>":Nombre_completo",
					"campo_valor"=>$firstname." ".$lastname
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
				],
				[
					"campo_nombre"=>"dateofbirth",
					"campo_marcador"=>":Dateofbirth",
					"campo_valor"=>$dateofbirth
				]
			];

			$condicion=[
				"condicion_campo"=>"user_id",
				"condicion_marcador"=>":User_id",
				"condicion_valor"=>$user_id
			];

			if($this->actualizarDatos("company", $company_datos_up, $condicion)){

				if($user_id == $_SESSION['id']){
					$_SESSION['nombre']=$firstname;
					$_SESSION['apellido']=$lastname;
					$_SESSION['company']=$login;
			}

			$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Company actualizado",
				"texto"=>"Los datos del company ".$datos['firstname']." ".$datos['lastname']." se actualizaron correctamente",
				"icono"=>"success"
			];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos del company ".$datos['firstname']." ".$datos['lastname'].", por favor intente nuevamente",
				"icono"=>"error"
			];
			}

			return json_encode($alerta);
		}

		/*----------  Controlador eliminar foto company  ----------*/
		public function eliminarFotoCompanyControlador(){

			$id=$this->limpiarCadena($_POST['company_id']);

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
    		$img_dir="../views/fotos/companys/";

    		chmod($img_dir,0777);

    		if(is_file($img_dir.$datos['company_foto'])){

		        chmod($img_dir.$datos['company_foto'],0777);

		        if(!unlink($img_dir.$datos['company_foto'])){
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

		    $company_datos_up=[
				[
					"campo_nombre"=>"company_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>""
				]
			];

			$condicion=[
				"condicion_campo"=>"company_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("company",$company_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']="";
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"La foto del company ".$datos['company_nombre']." ".$datos['company_apellido']." se elimino correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"No hemos podido actualizar algunos datos del company ".$datos['company_nombre']." ".$datos['company_apellido'].", sin embargo la foto ha sido eliminada correctamente",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}

		/*----------  Controlador actualizar foto company  ----------*/
		public function actualizarFotoCompanyControlador(){

			//return json_encode($_POST['company_id']);
			//exit;

			$id = $this->limpiarCadena($_POST['user_id']);

			# Verificando company #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company WHERE user_id='$id'");
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
    		$img_dir="../views/fotos/companys/";


    		# Comprobar si se selecciono una imagen #
    		if($_FILES['company_foto']['name']=="" && $_FILES['company_foto']['size']<=0){
    			$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No ha seleccionado una foto para el company",
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
	        if(mime_content_type($_FILES['company_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['company_foto']['tmp_name'])!="image/png"){
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
	        if(($_FILES['company_foto']['size']/1024)>5120){
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
	        if($datos['company_foto']!=""){
		        $foto=explode(".", $datos['company_foto']);
		        $foto=$foto[0];
	        }else{
	
			$foto=str_ireplace(" ","_",$datos['company_id']."_".$datos['firstname'].$datos['lastname']);
			$foto=$foto."_".rand(0,100);
	        }
	        

	        # Extension de la imagen #
	        switch(mime_content_type($_FILES['company_foto']['tmp_name'])){
	            case 'image/jpeg':
	                $foto=$foto.".jpg";
	            break;
	            case 'image/png':
	                $foto=$foto.".png";
	            break;
	        }

	        chmod($img_dir,0777);

	        # Moviendo imagen al directorio #
	        if(!move_uploaded_file($_FILES['company_foto']['tmp_name'],$img_dir.$foto)){
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
	        if(is_file($img_dir.$datos['company_foto']) && $datos['company_foto']!=$foto){
		        chmod($img_dir.$datos['company_foto'], 0777);
		        unlink($img_dir.$datos['company_foto']);
		    }

		    $company_datos_up=[
				[
					"campo_nombre"=>"company_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				]
			];

			$condicion=[
				"condicion_campo"=>"user_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("company",$company_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']=$foto;
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"La foto del company ".$datos['firstname']." ".$datos['lastname']." se actualizo correctamente",
					"icono"=>"success"
				];
			}else{

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"No hemos podido actualizar algunos datos del company ".$datos['firstname']." ".$datos['lastname']." , sin embargo la foto ha sido actualizada",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}

	}