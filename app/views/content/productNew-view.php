<!-- ============================================================== -->
<!-- BASE DE DATOS PARA AJAX -->
<!-- ============================================================== -->
<?php
$mysqli = new mysqli("localhost","root","","multimarket");
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
}
$company_id = $_SESSION['user_company_id'];

use app\controllers\proveedorController;
use app\controllers\controlController;
use app\controllers\marcaController;
use app\controllers\categoryController;

$proveedorController = new proveedorController();
$proveedores = $proveedorController->listarTodosProveedorControlador($company_id, "*");
//
$controlController = new controlController();
$unidades = $controlController->obtenerListaMarketControlador("unidades");
//
$marcaController = new marcaController();
$marcas = $marcaController->listarTodosMarcaControlador($company_id, "*");
//
$categoryController = new categoryController();
$categorias = $categoryController->listarTodosCategoryControlador($company_id, "*");
?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid"> 
            <div class="row">
                <!-- 
                    FORMULARIO  
                                -->
                <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" 
                    method="POST" autocomplete="off" enctype="multipart/form-data" >
                    <input type="hidden" name="modulo_product" value="registrar">
                    <input type="hidden" name="product_id" value="0">
                    <input type="hidden" name="product_user" value="<?=$_SESSION['id']?>">
                    <input type="hidden" name="company_id" value="<?=$_SESSION['user_company_id']?>">
                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                   |<li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#companyDetalis" role="tab">
                                            <i class="fas fa-home"></i> CREACIóN DE PRODUCTOD del Negocio/Tienda
                                        </a>
                                    </li>
                                </ul>
                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="productDetails" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label for="product_codigo" class="form-label">Código del producto</label>
                                                    <input name="product_codigo" type="text" class="form-control" 
                                                    id="product_email" placeholder="Codigo del Producto" required 
                                                    />
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="product_name" class="form-label">Nombre del producto</label>
                                                    <input name="product_name" type="text" class="form-control" 
                                                    id="codigo" placeholder="Entre el nombre oficial" 
                                                    pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{5,80}" 
                                                    maxlength="80" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3 pb-2">
                                                    <label for="location" class="form-label">Descripción del producto</label>
                                                    <textarea name="product_description" class="form-control" 
                                                    id="exampleFormControlTextarea" 
                                                    placeholder="Breve descripción del negocio" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="product_precio" class="form-label">Precio del producto</label>
                                                    <input class="form-control" name="product_precio" type="number" placeholder="0.00" required min="0" value="0.00" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'">
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="product_anterior" class="form-label">Precio anterior a la oferta</label>
                                                    <input class="form-control" name="product_anterior" type="number" placeholder="0.00" min="0" value="0.00" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$">
                                                </div>
                                            </div>

                                            <!--end col-->
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="countryInput" class="form-label">Unidad/Medida</label>
                                                        <select name="product_unidad" class="form-control" data-choices data-choices-text-unique-true id="product_unidad">
                                                        <option value="">Seleccione unidad/medida</option>
                                                            <?php
                                                            if(is_array($unidades)){
                                                                foreach($unidades as $unidad){
                                                                ?>
                                                                <option value="<?=$unidad['control_id'];?>"
                                                                    ><?=$unidad['nombre'];?>
                                                                </option>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="product_inventariable" class="form-label">Es inventariable?</label>
                                                    <select name="product_inventariable" class="form-control" required 
                                                        data-choices data-choices-text-unique-true id="tipo">
                                                        <option value="">Escoja una opción</option>
                                                        <option value="0">No inventariable</option>
                                                        <option value="1">Si Maneja inventario</option>
                                                        <option value="2">No, es producto digital</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="product_estatus" class="form-label">Estatus Actual</label>
                                                    <select name="product_estatus" class="form-control" required 
                                                        data-choices data-choices-text-unique-true id="tipo">
                                                        <option value="">Escoja una opción</option>
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="product_proveedor" class="form-label">Seleccione Proveedor</label>
                                                    <select name="product_proveedor" 
                                                    language="javascript:void(0)" class="form-control" 
                                                    data-choices data-choices-text-unique-true id="product_proveedor">
                                                    <option value="">Seleccione proveedor</option>
                                                    <?php
                                                    if(is_array($proveedores)){
                                                        foreach($proveedores as $proveedor){
                                                            ?>
                                                            <option value="<?=$proveedor['proveedor_id'];?>"><?=$proveedor['proveedor_name'];?>
                                                            </option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="product_usado" class="form-label">Es usado o nuevo?</label>
                                                    <select name="product_usado" class="form-control" required 
                                                        data-choices data-choices-text-unique-true id="product_usado">
                                                        <option value="">Escoja una opción</option>
                                                        <option value="1">Es Usado</option>
                                                        <option value="0">Es nuevo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="product_marca" class="form-label">Marca</label>
                                                    <select name="product_marca" 
                                                    language="javascript:void(0)" 
                                                    onchange="loadAjaxMarcaModelo(this.value, '')"
                                                    class="form-control" data-choices data-choices-text-unique-true id="state">
                                                    <option value="">Escoja una opción</option>
                                                    <?php
                                                    if(is_array($marcas)){
                                                        foreach($marcas as $marca){
                                                            ?>
                                                            <option value="<?=$marca['marca_id'];?>"><?=$marca['nombre'];?>
                                                            </option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="product_modelo" class="form-label">Modelo</label>
                                                    <select name="product_modelo" class="form-control" data-choices data-choices-text-unique-true id="product_modelo">
                                                        <option value="">Escoja una opción</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="product_year" class="form-label">Año de marca/modelo</label>
                                                    <input name="product_year" type="number" class="form-control" 
                                                    id="product_year" placeholder="Año de Marca/Modelo" 
                                                    />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="product_categoria" class="form-label">Categorias</label>
                                                    <select name="product_categoria" 
                                                    language="javascript:void(0)" 
                                                    onchange="loadAjaxCatSubcat(this.value, '')"
                                                    class="form-control" data-choices data-choices-text-unique-true id="product_categoria">
                                                    <option value="">Escoja una opción</option>
                                                    <?php
                                                    if(is_array($categorias)){
                                                        foreach($categorias as $categoria){
                                                            ?>
                                                            <option value="<?=$categoria['categoria_id'];?>"><?=$categoria['nombre'];?>
                                                            </option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="product_subcat" class="form-label">Subcategorías</label>
                                                    <select name="product_subcat" class="form-control" data-choices data-choices-text-unique-true id="product_subcat">
                                                    </select>
                                                </div>
                                            </div>
                                            <?php
                                            $createdAt = date("Y-m-d");
                                            //echo $createdAt; ?>
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Agregar el Producto</button>
                                                    <a href="<?php echo APP_URL; ?>productList/" 
                                                    class="btn btn-soft-success">Regresar</a>
                                                    
                                                </div>
                                                <p class="has-text-centered pt-6">
                                                    <small>Los campos marcados con 
                                                    <strong><?php echo CAMPO_OBLIGATORIO; ?></strong> son obligatorios</small>
                                                </p>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                </form>

            </div>
            <!--end row-->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
