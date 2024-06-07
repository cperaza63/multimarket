<?php

	namespace app\controllers;
	use app\models\mainModel; 
	class productController extends mainModel{
		/*----------  Controlador registrar proveedor  ----------*/
		public function registrarProductControlador(){
			# Almacenando datos#
			$product_id = $this->limpiarCadena($_POST['product_id']);
		    $product_name = $this->limpiarCadena($_POST['product_name']);
			$company_id = $this->limpiarCadena($_POST['company_id']);
		    $product_description = $this->limpiarCadena($_POST['product_description']);
		    $product_codigo = $this->limpiarCadena($_POST['product_codigo']);
		    $product_precio = $this->limpiarCadena($_POST['product_precio']);
		    $product_inventariable = $this->limpiarCadena($_POST['product_inventariable']);
			$product_proveedor = $this->limpiarCadena($_POST['product_proveedor']);
			$product_estatus = $this->limpiarCadena($_POST['product_estatus']);
			$product_precio = $this->limpiarCadena($_POST['product_precio']);
			$product_anterior = $this->limpiarCadena($_POST['product_anterior']);
			$product_unidad = $this->limpiarCadena($_POST['product_unidad']);
			$product_usado = $this->limpiarCadena($_POST['product_usado']);
			$product_marca = $this->limpiarCadena($_POST['product_marca']);
			$product_modelo = $this->limpiarCadena($_POST['product_modelo']);
			$product_year = $this->limpiarCadena($_POST['product_year']);
			$product_categoria = $this->limpiarCadena($_POST['product_categoria']);
			$product_subcat = $this->limpiarCadena($_POST['product_subcat']);
			
			$created_at = date("Y-m-d");
			//$product_city = 0;

		    # Verificando campos obligatorios 
		    if($product_name=="" || $company_id=="" || $product_codigo=="" || $product_description=="" 
			|| $product_precio=="" || $product_inventariable=="" || $product_proveedor=="" 
			|| $product_estatus=="" || $product_anterior=="" || $product_unidad=="" || $product_usado==""
			|| $product_marca=="" || $product_modelo=="" || $product_year=="" || $product_categoria=="" 
			|| $product_subcat=="" || $product_id ==""
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
			if ($product_id =="0"){
				$product_datos_reg=[
				[
					"campo_nombre"=>"product_name",
					"campo_marcador"=>":Product_name",
					"campo_valor"=>$product_name
				],
				[
					"campo_nombre"=>"company_id",
					"campo_marcador"=>":Company_id",
					"campo_valor"=>$company_id
				],
				[
					"campo_nombre"=>"product_codigo",
					"campo_marcador"=>":Product_codigo",
					"campo_valor"=>$product_codigo
				],
				[
					"campo_nombre"=>"product_description",
					"campo_marcador"=>":Product_description",
					"campo_valor"=>$product_description
				],
				[
					"campo_nombre"=>"product_precio",
					"campo_marcador"=>":Product_precio",
					"campo_valor"=>$product_precio
				],
				[
					"campo_nombre"=>"product_estatus",
					"campo_marcador"=>":Product_estatus",
					"campo_valor"=>$product_estatus
				],
				[
					"campo_nombre"=>"product_inventariable",
					"campo_marcador"=>":Product_inventariable",
					"campo_valor"=>$product_inventariable
				],
				[
					"campo_nombre"=>"product_anterior",
					"campo_marcador"=>":Product_anterior",
					"campo_valor"=>$product_anterior
				],
				[
					"campo_nombre"=>"product_unidad",
					"campo_marcador"=>":Product_unidad",
					"campo_valor"=>$product_unidad
				],
				[
					"campo_nombre"=>"product_usado",
					"campo_marcador"=>":Product_usado",
					"campo_valor"=>$product_usado
				],
				[
					"campo_nombre"=>"product_marca",
					"campo_marcador"=>":Product_marca",
					"campo_valor"=>$product_marca
				],
				[
					"campo_nombre"=>"product_modelo",
					"campo_marcador"=>":Product_modelo",
					"campo_valor"=>$product_modelo
				],
				[
					"campo_nombre"=>"product_year",
					"campo_marcador"=>":Product_year",
					"campo_valor"=>$product_year
				],
				[
					"campo_nombre"=>"product_categoria",
					"campo_marcador"=>":Product_categoria",
					"campo_valor"=>$product_categoria
				],
				[
					"campo_nombre"=>"product_subcat",
					"campo_marcador"=>":Product_subcat",
					"campo_valor"=>$product_subcat
				],
				[
					"campo_nombre"=>"product_proveedor",
					"campo_marcador"=>":Product_proveedor",
					"campo_valor"=>$product_proveedor
				],
				[
					"campo_nombre"=>"created_at",
					"campo_marcador"=>":Created_at",
					"campo_valor"=>$created_at
				]
				];
				$registrar_product=$this->guardarDatos("company_products",$product_datos_reg);
				if($registrar_product->rowCount()==1){
					$alerta=[
						"tipo"=>"limpiar",
						"titulo"=>"Producto registrado",
						"texto"=>"El item de codigo ".$product_name." se registro con exito",
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
			}else{
				$product_datos_reg=[
					[
						"campo_nombre"=>"product_name",
						"campo_marcador"=>":Product_name",
						"campo_valor"=>$product_name
					],
					[
						"campo_nombre"=>"product_codigo",
						"campo_marcador"=>":Product_codigo",
						"campo_valor"=>$product_codigo
					],
					[
						"campo_nombre"=>"product_description",
						"campo_marcador"=>":Product_description",
						"campo_valor"=>$product_description
					],
					[
						"campo_nombre"=>"product_precio",
						"campo_marcador"=>":Product_precio",
						"campo_valor"=>$product_precio
					],
					[
						"campo_nombre"=>"product_estatus",
						"campo_marcador"=>":Product_estatus",
						"campo_valor"=>$product_estatus
					],
					[
						"campo_nombre"=>"product_inventariable",
						"campo_marcador"=>":Product_inventariable",
						"campo_valor"=>$product_inventariable
					],
					[
						"campo_nombre"=>"product_anterior",
						"campo_marcador"=>":Product_anterior",
						"campo_valor"=>$product_anterior
					],
					[
						"campo_nombre"=>"product_unidad",
						"campo_marcador"=>":Product_unidad",
						"campo_valor"=>$product_unidad
					],
					[
						"campo_nombre"=>"product_usado",
						"campo_marcador"=>":Product_usado",
						"campo_valor"=>$product_usado
					],
					[
						"campo_nombre"=>"product_marca",
						"campo_marcador"=>":Product_marca",
						"campo_valor"=>$product_marca
					],
					[
						"campo_nombre"=>"product_modelo",
						"campo_marcador"=>":Product_modelo",
						"campo_valor"=>$product_modelo
					],
					[
						"campo_nombre"=>"product_year",
						"campo_marcador"=>":Product_year",
						"campo_valor"=>$product_year
					],
					[
						"campo_nombre"=>"product_categoria",
						"campo_marcador"=>":Product_categoria",
						"campo_valor"=>$product_categoria
					],
					[
						"campo_nombre"=>"product_subcat",
						"campo_marcador"=>":Product_subcat",
						"campo_valor"=>$product_subcat
					],
					[
						"campo_nombre"=>"product_proveedor",
						"campo_marcador"=>":Product_proveedor",
						"campo_valor"=>$product_proveedor
					]
				];
				$condicion=[
					"condicion_campo"=>"product_id",
					"condicion_marcador"=>":Product_id",
					"condicion_valor"=>$product_id
				];
				//return json_encode($product_datos_reg);
				//exit();
				if($this->actualizarDatos("company_products", $product_datos_reg, $condicion)){
					$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Producto actualizado",
					"texto"=>"Los datos de la tabla de proveedor ".$product_name." se actualizaron correctamente",
					"icono"=>"success"
					];
				}else{
					$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido actualizar los datos de la tabla de control ".$product_name.", por favor intente nuevamente",
					"icono"=>"error"
				];
				}
			}
			return json_encode($alerta);
		}
		/*----------  Controlador listar proveedor  ----------*/
		public function listarTodosProductControlador($company_id, $busqueda){
			$company_id=$this->limpiarCadena($company_id); 
			$busqueda=$this->limpiarCadena($busqueda);

			if(isset($busqueda) && $busqueda!="*"){
				$consulta_datos="SELECT * FROM company_products WHERE company_id= $company_id AND ( 
				product_name LIKE '%$busqueda%'
				OR product_epi LIKE '%$busqueda%' 
				OR product_description LIKE '%$busqueda%'
				OR company_id LIKE '%$busqueda%' 
				OR product_id LIKE '%$busqueda%' 
				) 
				ORDER BY product_name ASC";
			}else{
				$consulta_datos="SELECT * FROM company_products WHERE company_id=$company_id 
				ORDER BY product_name ASC";
			}
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			return $datos;
			exit();
		}
		/*----------  Controlador listar proveedor  ----------*/
		public function listarCategoriasProductControlador($company_id, $categoria, $subcategoria){
			$company_id=$this->limpiarCadena($company_id); 
			$categoria=$this->limpiarCadena($categoria);
			$subcategoria=$this->limpiarCadena($subcategoria);
			if( $categoria!="*" && $subcategoria!="*" ){
				$consulta_datos="SELECT * FROM company_products WHERE company_id= $company_id AND product_categoria = $categoria AND product_subcat = $subcategoria ORDER BY product_name ASC";
			}else{
				if( $categoria!="*" ){
					$consulta_datos="SELECT * FROM company_products WHERE company_id=$company_id AND product_categoria = $categoria ORDER BY product_name ASC";
				}else{
					$consulta_datos="SELECT * FROM company_products WHERE company_id=$company_id ORDER BY product_name ASC";
				}
			}
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			return $datos;
			exit();
		}
		/*----------  Controlador eliminar proveedor  ----------*/
		public function eliminarProductControlador(){
			$id=$this->limpiarCadena($_POST['product_id']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			# Verificando proveedor #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company_products WHERE product_id='$id' and product_estatus<>1");
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

		    $eliminarProducto=$this->eliminarRegistro("company_products","product_id",$id);

		    if($eliminarProducto->rowCount()==1){

		    	if(is_file("../views/fotos/company/".$company_id."/productos/".$datos['product_foto'])){
		            chmod("../views/fotos/company/".$company_id."/productos/".$datos['product_foto'],0777);
		            unlink("../views/fotos/company/".$company_id."/productos/".$datos['product_foto']);
		        }

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Item de la tabla de Producto eliminado",
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
		public function actualizarMasInformacionControlador(){
			# Almacenando datos#
			$product_id=$this->limpiarCadena($_POST['product_id']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			$product_precio=$this->limpiarCadena($_POST['product_precio']);
			$product_costo = $this->limpiarCadena($_POST['product_costo']);
			$product_margen_utilidad = $this->limpiarCadena($_POST['product_margen_utilidad']);
			$product_stock = $this->limpiarCadena($_POST['product_stock']);
			$product_reorden = $this->limpiarCadena($_POST['product_reorden']);
			$product_pedido = $this->limpiarCadena($_POST['product_pedido']);
			$product_tax = $this->limpiarCadena($_POST['product_tax']);
		    $product_excento_tax = $this->limpiarCadena($_POST['product_excento_tax']);
		    $product_peso = $this->limpiarCadena($_POST['product_peso']);
		    $product_mostrar_web= $this->limpiarCadena($_POST['product_mostrar_web']);
			$product_mostrar_stock0= $this->limpiarCadena($_POST['product_mostrar_stock0']);
			$product_width= $this->limpiarCadena($_POST['product_width']);
			$product_height= $this->limpiarCadena($_POST['product_height']);
			# Verificando campos obligatorios 
		    if($product_id=="" || $company_id=="" || $product_costo=="" 
			|| $product_margen_utilidad=="" || $product_stock=="" || $product_reorden==""
			|| $product_pedido=="" || $product_tax==""|| $product_excento_tax=="" || $product_peso==""
			|| $product_mostrar_web=="" || $product_mostrar_stock0=="" || $product_width=="" || $product_height=="" 
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

			if($product_costo > 0 ){
				if($product_margen_utilidad > 0 ){
					$product_precio_final = $product_costo + 
					($product_costo * ($product_margen_utilidad/100));
				}else{
					$product_precio_final = $product_costo;
				}
			}else{
				$product_precio_final = $product_precio;
			}

			if( $product_excento_tax == 1 ){
				$product_tax = 0;
			}
			//return json_encode($product_iva);
			//exit();
		    $product_datos_reg=[
				[
					"campo_nombre"=>"product_costo",
					"campo_marcador"=>":Product_costo",
					"campo_valor"=>$product_costo
				],
				[
					"campo_nombre"=>"product_precio",
					"campo_marcador"=>":Product_precio",
					"campo_valor"=>$product_precio_final
				],
				[
					"campo_nombre"=>"product_margen_utilidad",
					"campo_marcador"=>":Product_margen_utilidad",
					"campo_valor"=>$product_margen_utilidad
				],
				[
					"campo_nombre"=>"product_stock",
					"campo_marcador"=>":Product_stock",
					"campo_valor"=>$product_stock
				],
				[
					"campo_nombre"=>"product_reorden",
					"campo_marcador"=>":Product_reorden",
					"campo_valor"=>$product_reorden
				],
				[
					"campo_nombre"=>"product_pedido",
					"campo_marcador"=>":Product_pedido",
					"campo_valor"=>$product_pedido
				],
				[
					"campo_nombre"=>"product_tax",
					"campo_marcador"=>":Product_tax",
					"campo_valor"=>$product_tax
				],
				[
					"campo_nombre"=>"product_excento_tax",
					"campo_marcador"=>":Product_excento_tax",
					"campo_valor"=>$product_excento_tax
				],
				[
					"campo_nombre"=>"product_peso",
					"campo_marcador"=>":Product_peso",
					"campo_valor"=>$product_peso
				],
				[
					"campo_nombre"=>"product_mostrar_web",
					"campo_marcador"=>":Product_mostrar_web",
					"campo_valor"=>$product_mostrar_web
				],
				[
					"campo_nombre"=>"product_mostrar_stock0",
					"campo_marcador"=>":Product_mostrar_stock0",
					"campo_valor"=>$product_mostrar_stock0
				],
				[
					"campo_nombre"=>"product_width",
					"campo_marcador"=>":Product_width",
					"campo_valor"=>$product_width
				],
				[
					"campo_nombre"=>"product_height",
					"campo_marcador"=>":Product_height",
					"campo_valor"=>$product_height
				]
			];
			$condicion=[
				"condicion_campo"=>"product_id",
				"condicion_marcador"=>":Product_id",
				"condicion_valor"=>$product_id
			];

			if($this->actualizarDatos("company_products", $product_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Control actualizado",
				"texto"=>"Los datos de información adicional ".$product_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de información adicional ".$product_id.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}
		/*----------  Controlador actualizar proveedor  ----------*/
		public function actualizarEtiquetasControlador(){
			$product_id=$this->limpiarCadena($_POST['product_id']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			//
			if($product_id=="" || $company_id=="" || !isset($_POST['etiqueta_list'])
			) {
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al actualizar registro",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			if(is_array($_POST['etiqueta_list'] )){
				foreach($_POST['etiqueta_list'] as $etiqueta){
					$consulta_datos="SELECT * FROM company_products_etiquetas WHERE company_id=$company_id AND product_id=$product_id and etiqueta_id = " . $etiqueta . " ORDER BY etiqueta ASC";
					//print_r($consulta_datos);
					$result = $this->ejecutarConsulta($consulta_datos);
					$row_count = $result->rowCount();
					if($row_count == 0 ){
						$product_datos_reg=[
							[
								"campo_nombre"=>"company_id",
								"campo_marcador"=>":Company_id",
								"campo_valor"=>$company_id
							],
							[
								"campo_nombre"=>"product_id",
								"campo_marcador"=>":Product_id",
								"campo_valor"=>$product_id
							],
							[
								"campo_nombre"=>"etiqueta",
								"campo_marcador"=>":Etiqueta",
								"campo_valor"=>$etiqueta
							]
						];
						$registrar_interes=$this->guardarDatos("company_products_etiquetas",$product_datos_reg);
					}
				}
			}
			$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Etiquetas actualizadas",
				"texto"=>"Se actualizó La relacion de este producto ".$product_id." y las etiquetas",
				"icono"=>"success"
				];
				return json_encode($alerta);
				exit();
		}
		/*----------  Controlador actualizar proveedor  ----------*/
		public function actualizarInteresControlador(){
			$product_id=$this->limpiarCadena($_POST['product_id']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			//
			if($product_id=="" || $company_id=="" || !isset($_POST['product_list'])
			) {
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al actualizar registro",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			if(is_array($_POST['product_list'] )){
				foreach($_POST['product_list'] as $producto){
					if ($product_id != $producto){
						$consulta_datos="SELECT a.*, b.product_codigo, b.product_name FROM company_productos_interes a inner join company_products b on (a.product_hijo = b.product_id) WHERE a.company_id=$company_id AND a.product_id=$product_id and a.product_hijo=$producto GROUP BY product_name ASC";
						$result = $this->ejecutarConsulta($consulta_datos);
						$row_count = $result->rowCount();
						if($row_count == 0 ){
							$product_datos_reg=[
								[
									"campo_nombre"=>"company_id",
									"campo_marcador"=>":Company_id",
									"campo_valor"=>$company_id
								],
								[
									"campo_nombre"=>"product_id",
									"campo_marcador"=>":Product_id",
									"campo_valor"=>$product_id
								],
								[
									"campo_nombre"=>"product_hijo",
									"campo_marcador"=>":Product_hijo",
									"campo_valor"=>$producto
								]
							];
							$resultado_accion= $this->guardarDatos("company_productos_interes",$product_datos_reg);
						}
					}
					
				}
			}
			$alerta=[
			"tipo"=>"recargar",
			"titulo"=>"Producto actualizado",
			"texto"=>"Los datos de la tabla de proveedor ".$product_id." se actualizaron correctamente",
			"icono"=>"success"
			];
			return json_encode($alerta);
			exit();
		}
		/*----------  Controlador actualizar proveedor  ----------*/
		public function listarInteresesControlador($company_id, $product_id){
			$product_id=$this->limpiarCadena($product_id);
			$company_id=$this->limpiarCadena($company_id);
			//
			if($product_id=="" || $company_id==""
			) {
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al actualizar registro",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			$consulta_datos="SELECT a.*, b.product_codigo, b.product_name FROM company_productos_interes a inner join company_products b on (a.product_hijo = b.product_id) WHERE a.company_id=$company_id AND a.product_id=$product_id GROUP BY product_name ASC";

			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			return $datos;
			exit();
		}
		/*----------  Controlador actualizar proveedor  ----------*/
		public function listarEtiquetasControlador($company_id, $product_id){
			$product_id=$this->limpiarCadena($product_id);
			$company_id=$this->limpiarCadena($company_id);
			//
			if($product_id=="" || $company_id==""
			) {
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error al actualizar registro",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }
			$consulta_datos="SELECT a.*, b.control_id, b.codigo, b.nombre FROM company_products_etiquetas a inner join control b on (a.etiqueta = b.control_id) WHERE a.company_id=$company_id ORDER BY a.etiqueta ASC";
			print_r ($consulta_datos);
			$datos = $this->ejecutarConsulta($consulta_datos);
			
			$datos = $datos->fetchAll();
			return $datos;
			exit();
		}
		/*----------  Controlador actualizar proveedor  ----------*/
		public function excluirInteresControlador(){
			if(is_array($_POST['product_relacionados'] )){
				foreach($_POST['product_relacionados'] as $interes){
					$excluir_interes=$this->eliminarRegistro("company_productos_interes","interes_id",$interes);
				}
			}
			$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Producto excluido",
				"texto"=>"Los productos marcados fueron excluidos",
				"icono"=>"success"
				];
				return json_encode($alerta);
				exit();
			exit();
		}
		/*----------  Controlador actualizar proveedor  ----------*/
		public function excluirEtiquetasControlador(){
			if(is_array($_POST['product_etiquetas'] )){
				foreach($_POST['product_etiquetas'] as $etiqueta){
					$excluir_etiquetas=$this->eliminarRegistro("company_products_etiquetas","etiqueta",$etiqueta);
				}
			}
			$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Etiquetas excluidas",
				"texto"=>"Las etiquetas relacionadas al producto fueron excluidas",
				"icono"=>"success"
				];
				return json_encode($alerta);
				exit();
			exit();
		}
		/*----------  Controlador actualizar proveedor  ----------*/
		public function actualizarUbicacionControlador(){
			$product_id=$this->limpiarCadena($_POST['product_id']);
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

			$product_datos_reg=[
				[
					"campo_nombre"=>"product_latitude",
					"campo_marcador"=>":Product_latitude",
					"campo_valor"=>$latitude
				],
				[
					"campo_nombre"=>"product_longitude",
					"campo_marcador"=>":Product_longitude",
					"campo_valor"=>$longitude
				]
			];

			$condicion=[
				"condicion_campo"=>"product_id",
				"condicion_marcador"=>":Product_id",
				"condicion_valor"=>$product_id
			];

			if($this->actualizarDatos("company_products", $product_datos_reg, $condicion)){
				$alerta=[
				"tipo"=>"recargar",
				"titulo"=>"Producto actualizado",
				"texto"=>"Los datos de ubicación ".$product_id." se actualizaron correctamente",
				"icono"=>"success"
				];
			}else{
				$alerta=[
				"tipo"=>"simple",
				"titulo"=>"Ocurrió un error inesperado",
				"texto"=>"No hemos podido actualizar los datos de información adicional ".$product_id.", por favor intente nuevamente",
				"icono"=>"error"
			];
			}
			return json_encode($alerta);
		}
		/*----------  Controlador eliminar foto proveedor  ----------*/
		public function eliminarFotoProductControlador(){
			$id=$this->limpiarCadena($_POST['product_id']);
			$company_id=$this->limpiarCadena($_POST['company_id']);
			# Verificando proveedor #
		    $datos=$this->ejecutarConsulta("SELECT * FROM company_products WHERE product_id='$id'");
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
    		$img_dir="../views/fotos/company/".$company_id."/productos/";

    		chmod($img_dir,0777);

    		if(is_file($img_dir.$datos['product_foto'])){

		        chmod($img_dir.$datos['product_foto'],0777);

		        if(!unlink($img_dir.$datos['product_foto'])){
		            $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Error al intentar eliminar la foto del producto, por favor intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        	exit();
		        }
		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la foto del producto en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $product_datos_up=[
				[
					"campo_nombre"=>"product_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>""
				]
			];

			$condicion=[
				"condicion_campo"=>"product_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("company_products",$product_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']="";
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"La foto del producto ".$datos['control_nombre']." ".$datos['control_apellido']." se elimino correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"No hemos podido actualizar algunos datos del producto ".$datos['control_nombre']." ".$datos['control_apellido'].", sin embargo la foto ha sido eliminada correctamente",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}
		/*----------  Controlador actualizar foto proveedor  ----------*/
		public function actualizarFotoProductControlador(){
			$id = $this->limpiarCadena($_POST['product_id']);
			$company_id =  $this->limpiarCadena($_POST['company_id']);
			# Verificando proveedor 
			$datos=$this->ejecutarConsulta("SELECT * FROM company_products WHERE company_id=$company_id AND product_id=$id");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el producto en la tienda",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }
			# Directorio de imagenes #
    		$img_dir="../views/fotos/company/$company_id/productos/";
			# Comprobar si se selecciono una imagen #
    		if($_FILES['product_logo']['name']!="" && $_FILES['product_logo']['size']>0){
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
		        if(mime_content_type($_FILES['product_logo']['tmp_name'])!="image/jpeg" 
				&& mime_content_type($_FILES['product_logo']['tmp_name'])!="image/png"){
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
		        if(($_FILES['product_logo']['size']/1024)>5120){
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
		        $foto=str_ireplace(" ","_","prod_". $company_id ."_".$id);
		        
				$foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['product_logo']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }
		        
				chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['product_logo']['tmp_name'],$img_dir.$foto)){
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

			$product_datos_up=[
				[
					"campo_nombre"=>'product_logo',
					"campo_marcador"=>":Product_logo",
					"campo_valor"=>$foto
				]
			];

			$condicion=[
				"condicion_campo"=>"product_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];
			
			

			if($this->actualizarDatos("company_products",$product_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']=$foto;
				}
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"La foto del producto $id se actualizo correctamente...",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"No hemos podido actualizar algunos datos del producto $id, sin embargo la foto ha sido actualizada",
					"icono"=>"warning"
				];
			}
			return json_encode($alerta);
		}
		// fin de rutina
		public function actualizarFotoMasaControlador(){
			$id = $this->limpiarCadena($_POST['product_id']);
			$company_id = $this->limpiarCadena($_POST['company_id']);
			# Verificando proveedor #
			
			$datos=$this->ejecutarConsulta("SELECT * FROM company_products WHERE company_id=$company_id AND product_id=$id");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el producto en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

			$img_dir="../views/fotos/company/".$company_id."/productos/";
			$array=[0,0,0,0,0];
			$foto_array=["","","","",""];
			for ($i=0; $i <= 4; $i++) {
				if($_FILES['archivo']['name'][$i]!="" && $_FILES['archivo']['size'][$i]>0){
					if( $i == 0 ){
						$array[$i] = "product_card";
					}elseif($i == 1){
						$array[$i] = "product_banner1";
					}elseif($i == 2){
						$array[$i] = "product_banner2";
					}elseif($i == 3){	
						$array[$i] = "product_banner3";
					}elseif($i == 4){	
						$array[$i] = "product_pdf";
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
					$foto_array[$i] = str_ireplace(" ","_","neg_". $company_id ."_".$array[$i]."_".$id);
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
					$product_datos_up=[
						[
							"campo_nombre"=>$array[$i],
							"campo_marcador"=>":Foto_$array[$i]",
							"campo_valor"=>$foto_array[$i]
						]
					];
					$condicion=[
						"condicion_campo"=>"product_id",
						"condicion_marcador"=>":ID",
						"condicion_valor"=>$id
					];
					$this->actualizarDatos("company_products",$product_datos_up,$condicion);
					
					// elimino la fot anterior
					if(is_file($img_dir.$datos[$array[$i]])){
						chmod($img_dir.$datos[$array[$i]],0777);
						if(!unlink($img_dir.$datos[$array[$i]])){
							$alerta=[
								"tipo"=>"simple",
								"titulo"=>"Ocurrió un error inesperado",
								"texto"=>"Error al intentar eliminar el archivo del producto, por favor intente nuevamente",
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