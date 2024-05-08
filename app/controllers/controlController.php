<?php

	namespace app\controllers;
	use app\models\mainModel; 

	class controlController extends mainModel{

		/*----------  Controlador registrar usuario  ----------*/
		public function registrarControlControlador(){

			//return json_encode("regstrar usuario");
			
			# Almacenando datos#
		    $codigo=$this->limpiarCadena($_POST['codigo']);
		    $nombre=$this->limpiarCadena($_POST['nombre']);
		    $tipo=$this->limpiarCadena($_POST['tipo']);

		    # Verificando campos obligatorios #
		    if($codigo=="" || $nombre=="" || $tipo=="" )
			{
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al actualizar registro",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($codigo);
		        exit();
		    } 

		    # Verificando integridad de los datos #
		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,45}",$codigo)){
		         $alerta=[
			 		"tipo"=>"simple",
			 		"titulo"=>"Ocurrió un error inesperado",
			 		"texto"=>"El CODIGO ASIGNADO no coincide con el formato solicitado",
			 		"icono"=>"error"
			 	];
			 	return json_encode($alerta);
		         exit();
		    }

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,80}",$nombre)){
		         $alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"El NOMBRE ASIGNADO no coincide con el formato solicitado",
				"icono"=>"error"
				];
				return json_encode($alerta);
		    	exit();
		    }
			
			if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,20}",$tipo)){
		    	$alerta=[
				"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El TIPO de tabla asiGnado no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

            # Verificando usuario #
		    #$check_usuario=$this->ejecutarConsulta("SELECT login FROM usuario WHERE login='$email'");
		    #if($check_usuario->rowCount()>0){
		   	# 	$alerta=[
			#		"tipo"=>"simple",
			#		"titulo"=>"Ocurrió un error inesperado",
			#		"texto"=>"El USUARIO ingresado ya se encuentra registrado, por favor cambie su email",
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
				]
			];

			//return json_encode("regstrar usuario");

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

		
		/*----------  Controlador listar usuario  ----------*/
		public function listarControlControlador($pagina,$registros,$url,$busqueda){

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
		                    <th class="has-text-centered">Control</th>
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
		
		
		/*----------  Controlador listar usuario  ----------*/
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

		/*----------  Controlador eliminar usuario  ----------*/
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

			# Verificando usuario #
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
		            chmod("../views/fotos/control/".$datos['usuario_foto'],0777);
		            unlink("../views/fotos/control/".$datos['usuario_foto']);
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

		/*----------  Controlador actualizar usuario  ----------*/
		public function actualizarControlControlador(){

			$control_id=$this->limpiarCadena($_POST['control_id']);
			$codigo = $this->limpiarCadena($_POST['codigo']);
			$nombre = $this->limpiarCadena($_POST['nombre']);
			$tipo=$this->limpiarCadena($_POST['tipo']);
			$estatus=$this->limpiarCadena($_POST['estatus']);
			
			//return json_encode($estatus);
			# Verificando usuario #
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

		/*----------  Controlador eliminar foto usuario  ----------*/
		public function eliminarFotoControlControlador(){

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
    		$img_dir="../views/fotos/usuarios/";

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
		public function actualizarFotoControlControlador(){

			//return json_encode($_POST['usuario_id']);
			//exit;

			$id = $this->limpiarCadena($_POST['user_id']);

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
    		$img_dir="../views/fotos/usuarios/";


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
	
			$foto=str_ireplace(" ","_",$datos['company_id']."_".$datos['firstname'].$datos['lastname']);
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
		
		/*----------  Controlador registrar usuario  ----------*/
		public function actualizarPasswordControlador(){
		# Almacenando datos#
		$login=	$this->limpiarCadena($_POST['login']);
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

		# Verificando usuario #
		$check_usuario=$this->ejecutarConsulta("SELECT * FROM usuario WHERE login='$login'");
		if($check_usuario->rowCount()==1){
			$check_usuario=$check_usuario->fetch();
			if($check_usuario['login']==$login && password_verify($clave,$check_usuario['password'])){
				// pasa 
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"2 Ocurrió un error inesperado",
					"texto"=>"Control o clave incorrectos al momento de validar",
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
		

		$check_usuario=$this->ejecutarConsulta("SELECT login FROM usuario WHERE user_id = $user_id");
		if($check_usuario->rowCount() == 0){
			$alerta=[
				"tipo"=>"simple",
				"titulo"=>"4 Ocurrió un error al validar al usuario",
				"texto"=>"El USUARIO no fue encontrado, por favor revise",
				"icono"=>"error"
			];
			return json_encode($alerta);
			exit();
		}
		
		$tabla="usuario";
		$usuario_datos_reg=[
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
		
		$registrar_usuario=$this->actualizarDatos($tabla, $usuario_datos_reg, $condicion);

		if($registrar_usuario->rowCount()==1){
			$alerta=[
				"tipo"=>"limpiar",
				"titulo"=>"Clave del Control registrado",
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


	}