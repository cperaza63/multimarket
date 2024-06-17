<?php
$mysqli = new mysqli("localhost", "root", "", "multimarket");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if (isset($_POST['tab'])) {
    $_SESSION['tab'] = $_POST['tab'];
}

use app\controllers\proveedorController;
use app\controllers\productController;
use app\controllers\controlController;
use app\controllers\marcaController;
use app\controllers\categoryController;
use app\controllers\companyController;
use app\controllers\userController;
$product_list = "";
$product_id = $insLogin->limpiarCadena($url[1]);
$datos = $insLogin->seleccionarDatos("Unico", "company_products", "product_id", $product_id);
if ($datos->rowCount() == 1) {
    $datos = $datos->fetch();
    $product_modelo = $datos['product_modelo'];
    $company_id = $datos['company_id'];
    // busco el iva del a empresa
    $product_marca  = $datos['product_marca'];
    $company_iva = 0;
    $companyController = new companyController();
    $company_actual = $companyController->seleccionarDatos("Unico", "company", "company_id", $company_id);
    if ($company_actual->rowCount() == 1) {
        $datos_company = $company_actual->fetch();
        $company_iva = $datos_company['company_iva'];
    }
    $product_name   = $datos['product_name'];
    $product_precio   = $datos['product_precio'];
    $product_description   = $datos['product_description'];
    if ($datos['product_tax'] == 0) {
        $product_tax = $company_iva;
    } else {
        $product_tax = $datos['product_tax'];
    }
    $accion = "actualizar";
    $boton_accion = "Actualizar";

    $product_logo = $datos['product_logo'];

    if ($datos['product_logo'] == "") {
        $product_logo = "nophoto.jpg";
    }
    $product_card = $datos['product_card'];
    if ($datos['product_card'] == "") {
        $product_card = "nophoto.jpg";
    }
    $product_banner1 = $datos['product_banner1'];
    if ($datos['product_banner1'] == "") {
        $product_banner1 = "nophoto.jpg";
    }
    $product_banner2 = $datos['product_banner2'];
    if ($datos['product_banner2'] == "") {
        $product_banner2 = "nophoto.jpg";
    }
    $product_banner3 = $datos['product_banner3'];
    if ($datos['product_banner3'] == "") {
        $product_banner3 = "nophoto.jpg";
    }
    $product_pdf = $datos['product_pdf'];
    if ($datos['product_pdf'] == "") {
        $product_pdf = "nophoto.jpg";
    }
    $pasa = 1;
} else {
    // registro es nuevo
    $accion = "registrar";
    $boton_accion = "Agregar";
    $pasa = 0;
}
$userController = new userController();
$user = $userController->listarUsuarioTipoNegocioControlador($company_id, "ASISTENTE");

$proveedorController = new proveedorController();
$proveedores = $proveedorController->listarTodosProveedorControlador($company_id, "*");
//
$controlController = new controlController();
$unidades = $controlController->obtenerListaMarketControlador("unidades");
$unidad = $controlController->obtenerUnItemControlador($datos['product_unidad']);
$etiquetas = $controlController->obtenerListaMarketControlador("etiquetas");
//

$marcaController = new marcaController();
$marcas = $marcaController->listarTodosMarcaControlador($company_id, "*");
$marca_producto=$marcaController->obtenerUnItemControlador($product_marca);
//
$categoryController = new categoryController();
$categorias = $categoryController->listarTodosCategoryControlador($company_id, "*");
if (!isset($_SESSION["tab"])) {
    $_SESSION["tab"] = "";
}

$productController = new productController();
$product_relacionados = $productController->listarInteresesControlador($company_id,  $product_id);
$product_etiquetas = $productController->listarEtiquetasControlador($company_id,  $product_id);
$product_subproductos = $productController->listarSubproductosControlador($company_id,  $product_id);
$product_descuentos = $productController->listarDescuentosControlador($company_id,  $product_id);




if (isset($_POST["buscar_productos"])) {
    if ($_POST['product_categoria'] != "" && $_POST['product_subcat'] != "") {
        $product_list = $productController->listarCategoriasProductControlador($company_id, $_POST['product_categoria'], $_POST['product_subcat']);
    } else {
        if ($_POST['product_categoria'] != "") {
            $product_list = $productController->listarCategoriasProductControlador($company_id, $_POST['product_categoria'], "*");
        } else {
            $product_list = $productController->listarCategoriasProductControlador($company_id, '*', '*');
        }
    }
}
?>
<div id="layout-wrapper">
    <!-- ========== App Menu ========== -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Detalles del Producto</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                        <li class="breadcrumb-item active">Detalle del Producto</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                <div class="col-sm-auto">
                                    <a href="<?php echo APP_URL; ?>productCompra/" class="link-primary text-decoration-underline">Seguir comprando</a>
                                </div>
                                    <div class="row gx-lg-5">
                                        <div class="col-xl-4 col-md-8 mx-auto">
                                            <div class="product-img-slider sticky-side-div">
                                                <div class="swiper product-thumbnail-slider p-2 rounded bg-light">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <img src="<?php
                                                                echo $product_logo == "nophoto.jpg" || $product_logo == ""
                                                                    ? APP_URL . "app/views/fotos/nophoto.jpg"
                                                                    : APP_URL . "app/views/fotos/company/$company_id/productos/" . $product_logo;
                                                                ?>" alt="" class="img-fluid d-block" />
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <img src="<?php
                                                            echo $product_banner1 == "nophoto.jpg" || $product_banner1 == ""
                                                                ? APP_URL . "app/views/fotos/nophoto.jpg"
                                                                : APP_URL . "app/views/fotos/company/$company_id/productos/" . $product_banner1;
                                                            ?>" alt="" class="img-fluid d-block" />
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <img src="<?php
                                                            echo $product_banner2 == "nophoto.jpg" || $product_banner2 == ""
                                                                ? APP_URL . "app/views/fotos/nophoto.jpg"
                                                                : APP_URL . "app/views/fotos/company/$company_id/productos/" . $product_banner2;
                                                            ?>" alt="" class="img-fluid d-block" />
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <img src="<?php
                                                            echo $product_banner3 == "nophoto.jpg" || $product_banner3 == ""
                                                                ? APP_URL . "app/views/fotos/nophoto.jpg"
                                                                : APP_URL . "app/views/fotos/company/$company_id/productos/" . $product_banner3;
                                                            ?>" alt="" class="img-fluid d-block" />
                                                        </div>
                                                    </div>
                                                    <div class="swiper-button-next bg-white shadow"></div>
                                                    <div class="swiper-button-prev bg-white shadow"></div>
                                                </div>
                                                <!-- end swiper thumbnail slide -->
                                                <div class="swiper product-nav-slider mt-2">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <div class="nav-slide-item">
                                                                <img src="<?php
                                                                echo $product_logo == "nophoto.jpg" || $product_logo == ""
                                                                    ? APP_URL . "app/views/fotos/nophoto.jpg"
                                                                    : APP_URL . "app/views/fotos/company/$company_id/productos/" . $product_logo;
                                                                ?>" alt="" class="img-fluid d-block" />
                                                            </div>
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <div class="nav-slide-item">
                                                                <img src="<?php
                                                                echo $product_banner1 == "nophoto.jpg" || $product_banner1 == ""
                                                                    ? APP_URL . "app/views/fotos/nophoto.jpg"
                                                                    : APP_URL . "app/views/fotos/company/$company_id/productos/" . $product_banner1;
                                                                ?>" alt="" class="img-fluid d-block" />
                                                            </div>
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <div class="nav-slide-item">
                                                                <img src="<?php
                                                                echo $product_banner2 == "nophoto.jpg" || $product_banner2 == ""
                                                                    ? APP_URL . "app/views/fotos/nophoto.jpg"
                                                                    : APP_URL . "app/views/fotos/company/$company_id/productos/" . $product_banner2;
                                                                ?>" alt="" class="img-fluid d-block" />
                                                            </div>
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <div class="nav-slide-item">
                                                                <img src="<?php
                                                                echo $product_banner3 == "nophoto.jpg" || $product_banner3 == ""
                                                                    ? APP_URL . "app/views/fotos/nophoto.jpg"
                                                                    : APP_URL . "app/views/fotos/company/$company_id/productos/" . $product_banner3;
                                                                ?>" alt="" class="img-fluid d-block" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end swiper nav slide -->

                                                <!-- Ratio Video 16:9 -->
                                                <div class="ratio ratio-16x9">
                                                    <iframe src="https://www.youtube.com/embed/1y_kfWUCFDQ" title="YouTube video" allowfullscreen></iframe>
                                                </div>

                                                <div class="row">
                                                    <div class="mt-4">
                                                        <h5 class="fs-14">Tamaños:</h5>
                                                        <div class="d-flex flex-wrap gap-2">
                                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock">
                                                                <input type="radio" class="btn-check" name="productsize-radio" id="productsize-radio1" disabled>
                                                                <label class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center" for="productsize-radio1">S</label>
                                                            </div>

                                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="04 Items Available">
                                                                <input type="radio" class="btn-check" name="productsize-radio" id="productsize-radio2">
                                                                <label class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center" for="productsize-radio2">M</label>
                                                            </div>
                                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="06 Items Available">
                                                                <input type="radio" class="btn-check" name="productsize-radio" id="productsize-radio3">
                                                                <label class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center" for="productsize-radio3">L</label>
                                                            </div>

                                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock">
                                                                <input type="radio" class="btn-check" name="productsize-radio" id="productsize-radio4" disabled>
                                                                <label class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center" for="productsize-radio4">XL</label>
                                                            </div>

                                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock">
                                                                <input type="radio" class="btn-check" name="productsize-radio" id="productsize-radio5" >
                                                                <label class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center" for="productsize-radio5">XXL</label>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!-- end col -->
                                                </div>
                                                <div class="row">
                                                    <div class="mt-4">
                                                    <h5 class="fs-14">Colores:</h5>
                                                        <div class="d-flex flex-wrap gap-2">

                                                        <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock" class="rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" >
                                                                <input type="radio" class="btn-check" name="productcolor-radio" id="productcolor-radio7">
                                                                <label class="btn btn-soft-light avatar-xs rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" style="background-color:black;" for="productcolor-radio7"><i class="ri-checkbox-blank-circle-fill rounded-circle"></i></label>
                                                            </div>

                                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock" class="rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" >
                                                                <input type="radio" class="btn-check" name="productcolor-radio" id="productcolor-radio10">
                                                                <label class="btn btn-soft-light avatar-xs rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" style="background-color:white;" for="productcolor-radio10"><i class="ri-checkbox-blank-circle-fill rounded-circle"></i></label>
                                                            </div>

                                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock" class="rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" >
                                                                <input type="radio" class="btn-check" name="productcolor-radio" id="productcolor-radio1">
                                                                <label class="btn btn-soft-light avatar-xs rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" style="background-color:purple;" for="productcolor-radio1"><i class="ri-checkbox-blank-circle-fill rounded-circle"></i></label>
                                                            </div>

                                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock" class="rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" >
                                                                <input type="radio" class="btn-check" name="productcolor-radio" id="productcolor-radio2">
                                                                <label class="btn btn-soft-light avatar-xs rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" style="background-color:blue;" for="productcolor-radio2"><i class="ri-checkbox-blank-circle-fill rounded-circle"></i></label>
                                                            </div>

                                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock" class="rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" >
                                                                <input type="radio" class="btn-check" name="productcolor-radio" id="productcolor-radio3">
                                                                <label class="btn btn-soft-light avatar-xs rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" style="background-color:red;" for="productcolor-radio3"><i class="ri-checkbox-blank-circle-fill rounded-circle"></i></label>
                                                            </div>

                                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock" class="rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" >
                                                                <input type="radio" class="btn-check" name="productcolor-radio" id="productcolor-radio4">
                                                                <label class="btn btn-soft-light avatar-xs rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" style="background-color:yellow;" for="productcolor-radio4"><i class="ri-checkbox-blank-circle-fill rounded-circle"></i></label>
                                                            </div>

                                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock" class="rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" >
                                                                <input type="radio" class="btn-check" name="productcolor-radio" id="productcolor-radio5">
                                                                <label class="btn btn-soft-light avatar-xs rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" style="background-color:orange;" for="productcolor-radio5"><i class="ri-checkbox-blank-circle-fill rounded-circle"></i></label>
                                                            </div>

                                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock" class="rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" >
                                                                <input type="radio" class="btn-check" name="productcolor-radio" id="productcolor-radio6">
                                                                <label class="btn btn-soft-light avatar-xs rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" style="background-color:gray;" for="productcolor-radio6"><i class="ri-checkbox-blank-circle-fill rounded-circle"></i></label>
                                                            </div>

                                                            

                                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock" class="rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" >
                                                                <input type="radio" class="btn-check" name="productcolor-radio" id="productcolor-radio9">
                                                                <label class="btn btn-soft-light avatar-xs rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" style="background-color:magenta;" for="productcolor-radio9"><i class="ri-checkbox-blank-circle-fill rounded-circle"></i></label>
                                                            </div>
                                                            
                                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock" class="rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" >
                                                                <input disabled type="radio" class="btn-check" name="productcolor-radio" id="productcolor-radio10">
                                                                <label class="btn btn-soft-light avatar-xs rounded-circle p-0 d-flex justify-content-center fs-20 align-items-center" style="background-color: brown;" for="productcolor-radio10"><i class="ri-checkbox-blank-circle-fill rounded-circle"></i></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->
                                            </div>
                                        </div>
                                        <!-- end col -->

                                        <div class="col-xl-8">
                                            <div class="mt-xl-0 mt-5">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <h4><?=ucfirst($product_name);?></h4>
                                                        <div class="hstack gap-3 flex-wrap">
                                                            <div><a href="#" class="text-primary d-block"><?=$marca_producto['nombre']?></a></div>
                                                            <div class="vr"></div>
                                                            <div class="text-muted">Vendedor : <span class="text-body fw-medium"><?=$user['nombre_completo']?></span></div>
                                                            
                                                            <div class="text-muted">Publicado : <span class="text-body fw-medium"><?=date("jS F, Y", strtotime( $datos['created_at']))?></span></div>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="row mt-4 pt-2">
                                                            <div class="d-flex flex-wrap align-items-start gap-2">
                                                                <div class="input-step step-primary">
                                                                    <button type="button" class="minus shadow">–</button>
                                                                    <input type="number" class="product-quantity" value="1" min="1" max="100" readonly>
                                                                    <button type="button" class="plus shadow">+</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div>
                                                                <a href="<?php echo APP_URL; ?>productShoppingcart/" class="btn btn-success" id="addproduct-btn"><i class="ri-add-line align-bottom me-1"></i> Agregar al carrito </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                                <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                                                    <div class="text-muted fs-16">
                                                        <span class="mdi mdi-star text-warning"></span>
                                                        <span class="mdi mdi-star text-warning"></span>
                                                        <span class="mdi mdi-star text-warning"></span>
                                                        <span class="mdi mdi-star text-warning"></span>
                                                        <span class="mdi mdi-star text-warning"></span>
                                                    </div>
                                                    <div class="text-muted">( 5.50k Customer Review )</div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-lg-3 col-sm-6">
                                                        <div class="p-2 border border-dashed rounded">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm me-2">
                                                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                                        <i class="ri-money-dollar-circle-fill"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <p class="text-muted mb-1">Precio:</p>
                                                                    <h5 class="mb-0">$<?=number_format($datos['product_precio'], 2, '.', '');?></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end col -->
                                                    <div class="col-lg-3 col-sm-6">
                                                        <div class="p-2 border border-dashed rounded">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm me-2">
                                                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                                        <i class="ri-file-copy-2-fill"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <p class="text-muted mb-1">Ordenes :</p>
                                                                    <h5 class="mb-0">24</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end col -->
                                                    <div class="col-lg-3 col-sm-6">
                                                        <div class="p-2 border border-dashed rounded">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm me-2">
                                                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                                        <i class="ri-stack-fill"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <p class="text-muted mb-1">Disponible:</p>
                                                                    <h5 class="mb-0"><?=$datos['product_stock']?></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end col -->
                                                    <div class="col-lg-3 col-sm-6">
                                                        <div class="p-2 border border-dashed rounded">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm me-2">
                                                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                                        <i class="ri-inbox-archive-fill"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <p class="text-muted mb-1">Vendido :</p>
                                                                    <h5 class="mb-0">$605,00</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end col -->
                                                </div>

                                                <div class="mt-4 text-muted">
                                                    <h5 class="fs-14">Descripción:</h5>
                                                    <p><?=$datos['product_description']?></p>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="mt-3">
                                                            <h5 class="fs-14">Features :</h5>
                                                            <ul class="list-unstyled">
                                                                <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Full Sleeve</li>
                                                                <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Cotton</li>
                                                                <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> All Sizes available</li>
                                                                <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> 4 Different Color</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="mt-3">
                                                            <h5 class="fs-14">Services :</h5>
                                                            <ul class="list-unstyled product-desc-list">
                                                                <li class="py-1">10 Days Replacement</li>
                                                                <li class="py-1">Cash on Delivery available</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="product-content mt-5">
                                                    <h5 class="fs-14 mb-3">Product Description :</h5>
                                                    <nav>
                                                        <ul class="nav nav-tabs nav-tabs-custom nav-success" id="nav-tab" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" id="nav-speci-tab" data-bs-toggle="tab" href="#nav-speci" role="tab" aria-controls="nav-speci" aria-selected="true">Especification</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="false">Detalles</a>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                    <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                                                        <div class="tab-pane fade show active" id="nav-speci" role="tabpanel" aria-labelledby="nav-speci-tab">
                                                            <div class="table-responsive">
                                                                <table class="table mb-0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px;">Category</th>
                                                                            <td>T-Shirt</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Brand</th>
                                                                            <td>Tommy Hilfiger</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Color</th>
                                                                            <td>Blue</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Material</th>
                                                                            <td>Cotton</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Weight</th>
                                                                            <td>140 Gram</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
                                                            <div>
                                                                <h5 class="font-size-16 mb-3">Tommy Hilfiger Sweatshirt for Men (Pink)</h5>
                                                                <p>Tommy Hilfiger men striped pink sweatshirt. Crafted with cotton. Material composition is 100% organic cotton. This is one of the world’s leading designer lifestyle brands and is internationally recognized for celebrating the essence of classic American cool style, featuring preppy with a twist designs.</p>
                                                                <div>
                                                                    <p class="mb-2"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Machine Wash</p>
                                                                    <p class="mb-2"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Fit Type: Regular</p>
                                                                    <p class="mb-2"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> 100% Cotton</p>
                                                                    <p class="mb-0"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Long sleeve</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- product-content -->

                                                <div class="mt-5">
                                                    <div>
                                                        <h5 class="fs-14 mb-3">Clasificación</h5>
                                                    </div>
                                                    <div class="row gy-4 gx-0">
                                                        <div class="col-lg-4">
                                                            <div>
                                                                <div class="pb-3">
                                                                    <div class="bg-light px-3 py-2 rounded-2 mb-2">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-grow-1">
                                                                                <div class="fs-16 align-middle text-warning">
                                                                                    <i class="ri-star-fill"></i>
                                                                                    <i class="ri-star-fill"></i>
                                                                                    <i class="ri-star-fill"></i>
                                                                                    <i class="ri-star-fill"></i>
                                                                                    <i class="ri-star-half-fill"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="flex-shrink-0">
                                                                                <h6 class="mb-0">4.5 out of 5</h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-center">
                                                                        <div class="text-muted">Total <span class="fw-medium">5.50k</span> opiniones
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="mt-3">
                                                                    <div class="row align-items-center g-2">
                                                                        <div class="col-auto">
                                                                            <div class="p-2">
                                                                                <h6 class="mb-0">5 estrellas</h6>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="p-2">
                                                                                <div class="progress bg-success-subtle animated-progress progress-sm">
                                                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 50.16%" aria-valuenow="50.16" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <div class="p-2">
                                                                                <h6 class="mb-0 text-muted">2758</h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end row -->

                                                                    <div class="row align-items-center g-2">
                                                                        <div class="col-auto">
                                                                            <div class="p-2">
                                                                                <h6 class="mb-0">4 etrellas</h6>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="p-2">
                                                                                <div class="progress bg-success-subtle animated-progress progress-sm">
                                                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 19.32%" aria-valuenow="19.32" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <div class="p-2">
                                                                                <h6 class="mb-0 text-muted">1063</h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end row -->

                                                                    <div class="row align-items-center g-2">
                                                                        <div class="col-auto">
                                                                            <div class="p-2">
                                                                                <h6 class="mb-0">3 estrellas</h6>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="p-2">
                                                                                <div class="progress bg-success-subtle animated-progress progress-sm">
                                                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 18.12%" aria-valuenow="18.12" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <div class="p-2">
                                                                                <h6 class="mb-0 text-muted">997</h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end row -->

                                                                    <div class="row align-items-center g-2">
                                                                        <div class="col-auto">
                                                                            <div class="p-2">
                                                                                <h6 class="mb-0">2 estrellas</h6>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="p-2">
                                                                                <div class="progress bg-warning-subtle animated-progress progress-sm">
                                                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 7.42%" aria-valuenow="7.42" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-auto">
                                                                            <div class="p-2">
                                                                                <h6 class="mb-0 text-muted">408</h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end row -->

                                                                    <div class="row align-items-center g-2">
                                                                        <div class="col-auto">
                                                                            <div class="p-2">
                                                                                <h6 class="mb-0">1 estrella</h6>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="p-2">
                                                                                <div class="progress bg-danger-subtle animated-progress progress-sm">
                                                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 4.98%" aria-valuenow="4.98" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <div class="p-2">
                                                                                <h6 class="mb-0 text-muted">274</h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end row -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end col -->

                                                        <div class="col-lg-8">
                                                            <div class="ps-lg-4">
                                                                <div class="d-flex flex-wrap align-items-start gap-3">
                                                                    <h5 class="fs-14">Opiniones: </h5>
                                                                </div>

                                                                <div class="me-lg-n3 pe-lg-4" data-simplebar style="max-height: 225px;">
                                                                    <ul class="list-unstyled mb-0">
                                                                        <li class="py-2">
                                                                            <div class="border border-dashed rounded p-3">
                                                                                <div class="d-flex align-items-start mb-3">
                                                                                    <div class="hstack gap-3">
                                                                                        <div class="badge rounded-pill bg-success mb-0">
                                                                                            <i class="mdi mdi-star"></i> 4.2
                                                                                        </div>
                                                                                        <div class="vr"></div>
                                                                                        <div class="flex-grow-1">
                                                                                            <p class="text-muted mb-0"> Superb sweatshirt. I loved it. It is for winter.</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="d-flex flex-grow-1 gap-2 mb-3">
                                                                                    <a href="#" class="d-block">
                                                                                        <img src="<?php echo APP_URL;?>app/views/images/small/img-12.jpg" alt="" class="avatar-sm shadow rounded object-fit-cover">
                                                                                    </a>
                                                                                    <a href="#" class="d-block">
                                                                                        <img src="<?php echo APP_URL;?>app/views/images/small/img-11.jpg" alt="" class="avatar-sm shadow rounded object-fit-cover">
                                                                                    </a>
                                                                                    <a href="#" class="d-block">
                                                                                        <img src="<?php echo APP_URL;?>app/views/images/small/img-10.jpg" alt="" class="avatar-sm shadow rounded object-fit-cover">
                                                                                    </a>
                                                                                </div>

                                                                                <div class="d-flex align-items-end">
                                                                                    <div class="flex-grow-1">
                                                                                        <h5 class="fs-14 mb-0">Henry</h5>
                                                                                    </div>

                                                                                    <div class="flex-shrink-0">
                                                                                        <p class="text-muted fs-13 mb-0">12 Jul, 21</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="py-2">
                                                                            <div class="border border-dashed rounded p-3">
                                                                                <div class="d-flex align-items-start mb-3">
                                                                                    <div class="hstack gap-3">
                                                                                        <div class="badge rounded-pill bg-success mb-0">
                                                                                            <i class="mdi mdi-star"></i> 4.0
                                                                                        </div>
                                                                                        <div class="vr"></div>
                                                                                        <div class="flex-grow-1">
                                                                                            <p class="text-muted mb-0"> Great at this price, Product quality and look is awesome.</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="d-flex align-items-end">
                                                                                    <div class="flex-grow-1">
                                                                                        <h5 class="fs-14 mb-0">Nancy</h5>
                                                                                    </div>

                                                                                    <div class="flex-shrink-0">
                                                                                        <p class="text-muted fs-13 mb-0">06 Jul, 21</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </li>

                                                                        <li class="py-2">
                                                                            <div class="border border-dashed rounded p-3">
                                                                                <div class="d-flex align-items-start mb-3">
                                                                                    <div class="hstack gap-3">
                                                                                        <div class="badge rounded-pill bg-success mb-0">
                                                                                            <i class="mdi mdi-star"></i> 4.2
                                                                                        </div>
                                                                                        <div class="vr"></div>
                                                                                        <div class="flex-grow-1">
                                                                                            <p class="text-muted mb-0">Good product. I am so happy.</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="d-flex align-items-end">
                                                                                    <div class="flex-grow-1">
                                                                                        <h5 class="fs-14 mb-0">Joseph</h5>
                                                                                    </div>

                                                                                    <div class="flex-shrink-0">
                                                                                        <p class="text-muted fs-13 mb-0">06 Jul, 21</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </li>

                                                                        <li class="py-2">
                                                                            <div class="border border-dashed rounded p-3">
                                                                                <div class="d-flex align-items-start mb-3">
                                                                                    <div class="hstack gap-3">
                                                                                        <div class="badge rounded-pill bg-success mb-0">
                                                                                            <i class="mdi mdi-star"></i> 4.1
                                                                                        </div>
                                                                                        <div class="vr"></div>
                                                                                        <div class="flex-grow-1">
                                                                                            <p class="text-muted mb-0">Nice Product, Good Quality.</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="d-flex align-items-end">
                                                                                    <div class="flex-grow-1">
                                                                                        <h5 class="fs-14 mb-0">Jimmy</h5>
                                                                                    </div>

                                                                                    <div class="flex-shrink-0">
                                                                                        <p class="text-muted fs-13 mb-0">24 Jun, 21</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </li>

                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end col -->
                                                    </div>
                                                    <!-- end Ratings & Reviews -->
                                                </div>
                                                <!-- end card body -->
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © Velzon.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by Themesbrand
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    <!--Swiper slider js-->
    <script src="<?php echo APP_URL; ?>app/views/libs/swiper/swiper-bundle.min.js"></script>
    <!-- ecommerce product details init -->
    <script src="<?php echo APP_URL; ?>app/views/js/pages/ecommerce-product-details.init.js"></script>
    <!-- App js -->
    <script src="<?php echo APP_URL; ?>app/views/js/app.js"></script>

    <!-- multi.js -->
    <script src="<?php echo APP_URL; ?>app/views/libs/multi.js/multi.min.js"></script>
    <!-- autocomplete js -->
    <script src="<?php echo APP_URL; ?>app/views/libs//@tarekraafat/autocomplete.js/autoComplete.min.js"></script>

    <!-- init js -->
    <script src="<?php echo APP_URL; ?>app/views/js/pages/form-advanced.init.js"></script>
    <!-- input spin init -->
    <script src="<?php echo APP_URL; ?>app/views/js/pages/form-input-spin.init.js"></script>
    <!-- input flag init -->
    <script src="<?php echo APP_URL; ?>app/views/js/pages/flag-input.init.js"></script>
