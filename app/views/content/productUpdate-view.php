<!-- ============================================================== -->
<!-- BASE DE DATOS PARA AJAX -->
<!-- ============================================================== -->
<?php
$mysqli = new mysqli("localhost", "root", "", "multimarket");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
?>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <?php
            if (isset($_POST['tab'])) {
                $_SESSION['tab'] = $_POST['tab'];
            }

            use app\controllers\proveedorController;
            use app\controllers\productController;
            use app\controllers\controlController;
            use app\controllers\marcaController;
            use app\controllers\categoryController;
            use app\controllers\companyController;
            $product_list = "";
            $product_id = $insLogin->limpiarCadena($url[1]);
            $datos = $insLogin->seleccionarDatos("Unico", "company_products", "product_id", $product_id);
            if ($datos->rowCount() == 1) {
                $datos = $datos->fetch();
                $product_modelo = $datos['product_modelo'];
                $company_id = $datos['company_id'];
                // busco el iva del a empresa
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
            // lleno la lista de intereses y etiquetas
            if ($pasa == 1) {
            ?>
                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card mt-n6">
                            <div class="card-body p-1">
                                <div class="text-center">
                                    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                                        <input type="hidden" name="modulo_product" value="actualizarFoto">
                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                        <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                            <img src="
                                            <?php
                                            echo $product_logo == "nophoto.jpg" || $product_logo == ""
                                                ? APP_URL . "app/views/fotos/nophoto.jpg"
                                                : APP_URL . "app/views/fotos/company/$company_id/productos/" . $product_logo;
                                            ?>" class="rounded-circle avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <button type="submit" class="avatar-title rounded-circle bg-light text-body shadow">
                                                            <i class="ri-upload-2-fill"></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <div class="avatar-xs p-0 rounded-circle ">
                                                            <input id="profile-img-file-input" name="product_logo" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">

                                                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                                <span class="avatar-title rounded-circle bg-light text-body shadow">
                                                                    <i class="ri-camera-fill"></i>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </td>

                                                </tr>
                                            </table>
                                        </div>
                                    </form>
                                    <h5 class="fs-16 mb-1"><?php echo "ACTUALIZANDO PRODUCTO " . $datos['product_name']; ?></h5>
                                    <p class="text-muted mb-0"><?php echo "Item # " . $datos['product_id']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <?php
                    //echo "==". $_SESSION["tab"]; 
                    $tab1 = "";
                    $tab2 = "";
                    $tab3 = "";
                    $tab4 = "";
                    $tab5 = "";
                    $tab6 = "";
                    $tab7 = "";
                    $tab8 = "";
                    if (!isset($_SESSION["tab"])) {
                        $_SESSION["tab"] = "personaldetails";
                    }
                    if ($_SESSION["tab"] == "personaldetails") {
                        $tab1 = "active";
                    ?><script>
                            location.href = "#personaldetails";
                        </script><?php

                                } else if ($_SESSION["tab"] == "multimedia") {
                                    $tab2 = "active";
                                    ?><script>
                            location.href = "#multimedia";
                        </script><?php

                                } else if ($_SESSION["tab"] == "masinformacion") {
                                    $tab3 = "active";
                                    ?><script>
                            location.href = "#masinformacion";
                        </script><?php

                                } else if ($_SESSION["tab"] == "interes") {
                                    $tab4 = "active";
                                    ?><script>
                            location.href = "#interes";
                        </script><?php
                                } else if ($_SESSION["tab"] == "etiquetas") {
                                    $tab5 = "active";
                                    ?><script>
                            location.href = "#etiquetas";
                        </script><?php
                                } else if ($_SESSION["tab"] == "subproductos") {
                                    $tab6 = "active";
                                    ?><script>
                            location.href = "#subproductos";
                        </script><?php
                                } else if ($_SESSION["tab"] == "descuentos") {
                                    $tab7 = "active";
                                    ?><script>
                            location.href = "#descuentos";
                        </script><?php
                                } else if ($_SESSION["tab"] == "cupones") {
                                    $tab8 = "active";
                                    ?><script>
                            location.href = "#cupones";
                        </script><?php
                                }else {
                                    $tab1 = "active";
                                    ?><script>
                            location.href = "#personaldetails";
                        </script><?php
                                }
                                    ?>
                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul id="myTab" class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">

                                    |<li class="nav-item">
                                        <a class="nav-link <?= $tab1; ?>" id="tab-header-1" data-bs-toggle="tab" href="#personaldetails" role="tab">
                                            <i class="fas fa-home"></i> Información
                                        </a>
                                    </li>

                                    <li li class="nav-item">
                                        <a class="nav-link <?= $tab2 ?>" id="tab-header-2" data-bs-toggle="tab" href="#multimedia" role="tab">
                                            <i class="far fa-user"></i> Multimedia
                                        </a>
                                    </li>

                                    <li li class="nav-item">
                                        <a class="nav-link <?= $tab3 ?>" id="tab-header-3" data-bs-toggle="tab" href="#masinformacion" role="tab">
                                            <i class="far fa-user"></i> Más información
                                        </a>
                                    </li>

                                    <li li class="nav-item">
                                        <a class="nav-link <?= $tab4 ?>" id="tab-header-4" data-bs-toggle="tab" href="#interes" role="tab">
                                            <i class="far fa-user"></i> De interés
                                        </a>
                                    </li>

                                    <li li class="nav-item">
                                        <a class="nav-link <?= $tab5 ?>" id="tab-header-5" data-bs-toggle="tab" href="#etiquetas" role="tab">
                                            <i class="far fa-user"></i> Etiquetas
                                        </a>
                                    </li>

                                    <li li class="nav-item">
                                        <a class="nav-link <?= $tab6 ?>" id="tab-header-6" data-bs-toggle="tab" href="#subproductos" role="tab">
                                            <i class="far fa-user"></i> Subproductos
                                        </a>
                                    </li>

                                    <li li class="nav-item">
                                        <a class="nav-link <?= $tab7 ?>" id="tab-header-7" data-bs-toggle="tab" href="#descuentos" role="tab">
                                            <i class="far fa-user"></i> Descuentos
                                        </a>
                                    </li>

                                    <li li class="nav-item">
                                        <a class="nav-link <?= $tab8 ?>" id="tab-header-8" data-bs-toggle="tab" href="#cupones" role="tab">
                                            <i class="far fa-user"></i> Cupones
                                        </a>
                                    </li>

                                </ul>
                            </div>
                            <a href="<?php echo APP_URL; ?>productList/" class="btn btn-soft-success">Regresar</a>
                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane <?= $tab1 ?>" id="personaldetails" role="tabpanel">
                                        <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" autocomplete="off">
                                            <input type="hidden" name="modulo_product" value="actualizar">
                                            <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                                            <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                                            <input type="hidden" name="tab" value="personaldetails">
                                            <input type="hidden" name="product_user" value="<?= $_SESSION['id'] ?>">
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <div class="mb-3">
                                                        <label for="product_codigo" class="form-label">Código del producto</label>
                                                        <input name="product_codigo" type="text" class="form-control" value="<?php echo $datos['product_codigo'] ?>" id="product_codigo" placeholder="Codigo del Producto" required />
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="product_name" class="form-label">Nombre del producto</label>
                                                        <input name="product_name" type="text" class="form-control" id="codigo" placeholder="Entre el nombre oficial" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{5,80}" value="<?php echo $datos['product_name'] ?>" maxlength="80" required>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3 pb-2">
                                                        <label for="location" class="form-label">Descripción del producto</label><textarea name="product_description" class="form-control" id="product_description" placeholder="Breve descripción del producto" rows="3"><?php echo $datos['product_description'] ?></textarea>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label for="product_precio" class="form-label">Precio del producto</label>
                                                        <input class="form-control" name="product_precio" type="number" placeholder="0.00" required min="0" value="<?php echo $datos['product_precio']; ?>" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'">
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label for="product_anterior" class="form-label">Precio anterior a la oferta</label>
                                                        <input class="form-control" name="product_anterior" type="number" placeholder="0.00" min="0" value="<?php echo $datos['product_anterior']; ?>" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" <?php echo $datos['product_anterior'] ?>>
                                                    </div>
                                                </div>

                                                <!--end col-->
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label for="countryInput" class="form-label">Unidad/Medida</label>
                                                        <select name="product_unidad" class="form-control" data-choices data-choices-text-unique-true id="product_unidad">
                                                            <option value="">Seleccione unidad/medida</option>
                                                            <?php
                                                            if (is_array($unidades)) {
                                                                foreach ($unidades as $unidad) {
                                                            ?>
                                                                    <option value="<?= $unidad['control_id']; ?>" <?= $datos['product_unidad'] == $unidad['control_id'] ? "selected" : "" ?>><?= $unidad['nombre']; ?>
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
                                                        <select name="product_inventariable" class="form-control" required data-choices data-choices-text-unique-true id="tipo">
                                                            <option value="">Escoja una opción</option>
                                                            <option value="0" <?= $datos['product_inventariable'] == "0" ? "selected" : "" ?>>No inventariable</option>
                                                            <option value="1" <?= $datos['product_inventariable'] == "1" ? "selected" : "" ?>>Si Maneja inventario</option>
                                                            <option value="2" <?= $datos['product_inventariable'] == "2" ? "selected" : "" ?>>Es producto digital</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="product_estatus" class="form-label">Estatus Actual</label>
                                                        <select name="product_estatus" class="form-control" required data-choices data-choices-text-unique-true id="tipo">
                                                            <option value="">Escoja una opción</option>
                                                            <option value="1" <?= $datos['product_estatus'] == "1" ? "selected" : "" ?>>Activo</option>
                                                            <option value="0" <?= $datos['product_estatus'] == "0" ? "selected" : "" ?>>Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="product_proveedor" class="form-label">Seleccione Proveedor</label>
                                                        <select name="product_proveedor" language="javascript:void(0)" class="form-control" data-choices data-choices-text-unique-true id="product_proveedor">
                                                            <option value="">Seleccione proveedor</option>
                                                            <?php
                                                            if (is_array($proveedores)) {
                                                                foreach ($proveedores as $proveedor) {
                                                            ?>
                                                                    <option value="<?= $proveedor['proveedor_id']; ?>" <?= $datos['product_proveedor'] == $proveedor['proveedor_id'] ? "selected" : "" ?>><?= $proveedor['proveedor_name']; ?>
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
                                                        <select name="product_usado" class="form-control" required data-choices data-choices-text-unique-true id="product_usado">
                                                            <option value="">Escoja una opción</option>
                                                            <option value="1" <?= $datos['product_usado'] == "1" ? "selected" : "" ?>>Es Usado</option>
                                                            <option value="0" <?= $datos['product_usado'] == "0" ? "selected" : "" ?>>Es nuevo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="product_marca" class="form-label">Marca</label>
                                                        <select name="product_marca" language="javascript:void(0)" onchange="loadAjaxMarcaModelo(this.value, <?= $product_modelo ?>)" class="form-control" data-choices data-choices-text-unique-true id="state">
                                                            <option value="">Escoja una opción</option>
                                                            <?php
                                                            if (is_array($marcas)) {
                                                                foreach ($marcas as $marca) {
                                                            ?>
                                                                    <option value="<?= $marca['marca_id']; ?>" <?= $datos['product_marca'] == $marca['marca_id'] ? "selected" : "" ?>><?= $marca['nombre']; ?>
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
                                                            <?php
                                                            $sql = "SELECT * FROM company_marcas WHERE unidad= " . $datos['product_marca'] . " AND company_id=$company_id AND estatus=1 ORDER BY nombre";
                                                            //echo $sql;
                                                            if ($res = $mysqli->query("SELECT * FROM company_marcas WHERE unidad= " . $datos['product_marca'] . " AND company_id=$company_id AND estatus=1 ORDER BY nombre")) {
                                                            ?>
                                                                <?php while ($fila = mysqli_fetch_array($res)) { ?>
                                                                    <option value="<?php echo $fila['marca_id']; ?>" <?php if ($fila['marca_id'] == $datos["product_modelo"]) echo "selected"; ?>>
                                                                        <?php echo $fila['marca_id'] == "" ? "Seleccione Modelo" : $fila['nombre']; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="product_year" class="form-label">Año de marca/modelo</label>
                                                        <input name="product_year" type="number" class="form-control" value="<?= $datos['product_year'] ?>" id="product_year" placeholder="Año de Marca/Modelo" />
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="product_categoria" class="form-label">Categorias</label>
                                                        <select name="product_categoria" language="javascript:void(0)" onchange="loadAjaxCatSubcat(this.value, '')" class="form-control" data-choices data-choices-text-unique-true id="product_categoria">
                                                            <option value="">Escoja una opción</option>
                                                            <?php
                                                            if (is_array($categorias)) {
                                                                foreach ($categorias as $categoria) {
                                                            ?>
                                                                    <option value="<?= $categoria['categoria_id']; ?>" <?= $datos['product_categoria'] == $categoria['categoria_id'] ? "selected" : "" ?>><?= $categoria['nombre']; ?>
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
                                                            <?php
                                                            $sql = "SELECT * FROM company_categorias WHERE unidad= " . $datos['product_categoria'] . " AND company_id=$company_id AND estatus=1 ORDER BY nombre";
                                                            //echo $sql;
                                                            if ($res = $mysqli->query("SELECT * FROM company_categorias WHERE unidad= " . $datos['product_categoria'] . " AND company_id=$company_id AND estatus=1 ORDER BY nombre")) {
                                                            ?>
                                                                <?php while ($fila = mysqli_fetch_array($res)) { ?>
                                                                    <option value="<?php echo $fila['categoria_id']; ?>" <?php if ($fila['categoria_id'] == $datos["product_subcat"]) echo "selected"; ?>>
                                                                        <?php echo $fila['categoria_id'] == "" ? "Seleccione Modelo" : $fila['nombre']; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php
                                                $createdAt = date("Y-m-d");
                                                //echo $createdAt; 
                                                ?>
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-primary">Actualizar el Producto</button>
                                                        <a href="<?php echo APP_URL; ?>productList/" class="btn btn-soft-success">Regresar</a>

                                                    </div>
                                                    <p class="has-text-centered pt-6">
                                                        <small>Los campos marcados con
                                                            <strong><?php echo CAMPO_OBLIGATORIO; ?></strong> son obligatorios</small>
                                                    </p>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                    <!--end tab-pane-->
                                    <div class="tab-pane <?= $tab2 ?>" id="multimedia" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <form class="FormularioAjax" name="productList" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                                                    <input type="hidden" name="modulo_product" value="actualizarFotoMasa">
                                                    <input type="hidden" name="product_id" value="<?php echo $datos['product_id']; ?>">
                                                    <input type="hidden" name="company_id" value="<?php echo $datos['company_id']; ?>">
                                                    <input type="hidden" name="tab" value="multimedia">
                                                    <div class="card-body p-4">
                                                        <label for="card">Card
                                                            <input class="form-control" type="file" name="archivo[0]"></label>
                                                        <label for="card">Banner1
                                                            <input class="form-control" type="file" name="archivo[1]"></label>
                                                        <label for="card">Banner2
                                                            <input class="form-control" type="file" name="archivo[2]"></label>
                                                        <label for="card">Banner3
                                                            <input class="form-control" type="file" name="archivo[3]"></label>
                                                        <label for="card">Pdf
                                                            <input class="form-control" type="file" name="archivo[4]"></label>
                                                        <br>
                                                        <button class="btn btn-success" type="submit">Enviar</button>
                                                        <a href="<?php echo APP_URL; ?>productList/" class="btn btn-soft-success">Regresar</a>
                                                    </div>
                                                </form>
                                                <hr class="my-4">
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">
                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                            <img src="<?php echo $product_card == "nophoto.jpg"
                                                                            ? APP_URL . "app/views/fotos/nophoto.jpg"
                                                                            : APP_URL . "app/views/fotos/company/$company_id/productos/" . $product_card;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="product_card" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>
                                                        <strong>
                                                            <h4 class="fs-16 mb-1">Tarjeta - Card</h4>
                                                        </strong>
                                                        <p class="text-muted mb-0"><?php echo $datos['product_card'] . " Item # " . $datos['product_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">
                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                            <img src="<?php echo $product_card == "nophoto.jpg"
                                                                            ? APP_URL . "app/views/fotos/nophoto.jpg"
                                                                            : APP_URL . "app/views/fotos/company/$company_id/productos/" . $product_banner1;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="product_banner1" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>
                                                        <h5 class="fs-16 mb-1">Banner #1</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['product_banner1'] . " Item # " . $datos['product_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">

                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">

                                                            <img src="<?php echo $product_banner2 == "nophoto.jpg"
                                                                            ? APP_URL . "app/views/fotos/nophoto.jpg"
                                                                            : APP_URL . "app/views/fotos/company/$company_id/productos/" . $product_banner2;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="product_banner2" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>

                                                        <h5 class="fs-16 mb-1">Banner #2</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['product_banner2'] . " Item # " . $datos['product_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">
                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                            <img src="<?php echo $product_banner3 == "nophoto.jpg"
                                                                            ? APP_URL . "app/views/fotos/nophoto.jpg"
                                                                            : APP_URL . "app/views/fotos/company/$company_id/productos/" . $product_banner3;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="product_banner3" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>

                                                        <h5 class="fs-16 mb-1">Banner #3</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['product_banner3'] . " Item # " . $datos['product_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">
                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                            <img src="<?php echo APP_URL; ?>app/views/fotos/pdf.jpg" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="product_pdf" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>
                                                        <h5 class="fs-16 mb-1">Archivo PDF</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['product_pdf'] . " Item # " . $datos['product_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                        </div>
                                    </div>
                                    <!--end tab-pane-->
                                    <div class="tab-pane <?= $tab3 ?>" id="masinformacion" role="tabpanel">
                                        <div class="row">
                                            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" autocomplete="off">
                                                <input type="hidden" name="modulo_product" value="actualizarMasInformacion">
                                                <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                                                <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                                                <input type="hidden" name="product_precio" value="<?= $product_precio; ?>">
                                                <input type="hidden" name="tab" value="masinformacion">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <div class="mb-">
                                                            <label for="codigo" class="form-label">Código Negocio</label>
                                                            <input name="codigo" type="text" class="form-control" name="codigo" id="product_id" value="<?php echo $datos['product_id']; ?>" maxlength="40" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="product_name" class="form-label">Nombre del Negocio</label>
                                                            <input name="product_name" type="text" class="form-control" id="product_name" value="<?php echo $datos['product_name']; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="product_unidad" class="form-label">Unidad de medida</label>
                                                            <input name="product_unidad" type="text" class="form-control" id="product_unidad" value="<?php echo $unidad['nombre']; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="product_margen_utilidad" class="form-label">Precio final</label>
                                                            <input name="product_precio_final" type="number" class="form-control" value="<?= $datos["product_precio"] ?>" id="product_precio" placeholder="Calculado $" maxlength="20" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="product_inventariable" class="form-label">Es inventariable?</label>
                                                            <select name="product_inventariable" class="form-control" disabled data-choices data-choices-text-unique-true id="tipo">
                                                                <option value="0" <?= $datos['product_inventariable'] == "0" ? "selected" : "" ?>>No inventariable</option>
                                                                <option value="1" <?= $datos['product_inventariable'] == "1" ? "selected" : "" ?>>Es inventariable</option>
                                                                <option value="2" <?= $datos['product_inventariable'] == "2" ? "selected" : "" ?> Producto digital</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <hr>
                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="product_costo" class="form-label">Costo del producto</label>
                                                            <input name="product_costo" type="number" class="form-control" value="<?= $datos["product_costo"] ?>" id="product_web" placeholder="Entre el costo $" maxlength="240">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="product_margen_utilidad" class="form-label">Margen de utilidad</label>
                                                            <input name="product_margen_utilidad" type="number" class="form-control" value="<?= $datos["product_margen_utilidad"] ?>" id="product_margen_utilidad" placeholder="Entre el margen de utilidad $" maxlength="20">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="product_stock" class="form-label">Stock atual</label>
                                                            <input name="product_stock" type="number" class="form-control" value="<?= $datos["product_stock"] ?>" id="product_stock" placeholder="Stock actual" maxlength="20">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="product_reorden" class="form-label">Punto de reorden</label>
                                                            <input name="product_reorden" type="number" class="form-control" value="<?= $datos["product_reorden"] ?>" id="product_reorden" placeholder="Reordenamiento" maxlength="20">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="product_pedido" class="form-label">Cantidad a reordenar</label>
                                                            <input name="product_pedido" type="number" class="form-control" value="<?= $datos["product_pedido"] ?>" id="product_pedido" placeholder="Entre cantidad" maxlength="20">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="product_tax" class="form-label">Aplicar impuesto %</label>
                                                            <input name="product_tax" type="number" class="form-control" value="<?= $product_tax ?>" id="product_pedido" placeholder="Entre porcentaje de impuesta IVA" maxlength="20">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="product_excento_tax" class="form-label">Excento de impuesto</label>
                                                            <select name="product_excento_tax" class="form-control" data-choices data-choices-text-unique-true id="product_excento_tax">
                                                                <option value="0" <?= $datos['product_excento_tax'] == "0" ? "selected" : "" ?>>No aplica</option>
                                                                <option value="1" <?= $datos['product_excento_tax'] == "1" ? "selected" : "" ?>>Si aplica</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="product_peso" class="form-label">Peso en kgs</label>
                                                            <input name="product_peso" type="number" class="form-control" value="<?= $datos["product_peso"] ?>" id="product_peso" placeholder="Peso en kgs" maxlength="20">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="product_mostrar_web" class="form-label">Mostrar en la web</label>
                                                            <select name="product_mostrar_web" class="form-control" required data-choices data-choices-text-unique-true id="product_mostrar_web">
                                                                <option value="1" <?= $datos['product_mostrar_web'] == "1" ? "selected" : "" ?>>Si</option>
                                                                <option value="0" <?= $datos['product_mostrar_web'] == "0" ? "selected" : "" ?>>No</option>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="product_mostrar_stock0" class="form-label">Mostrar con stock 0</label>
                                                            <select name="product_mostrar_stock0" class="form-control" data-choices data-choices-text-unique-true id="product_mostrar_stock0">
                                                                <option value="">Escoja una opción</option>
                                                                <option value="0" <?= $datos['product_mostrar_stock0'] == "0" ? "selected" : "" ?>>No aplica</option>
                                                                <option value="1" <?= $datos['product_mostrar_stock0'] == "1" ? "selected" : "" ?>>Si aplica</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="product_width" class="form-label">Ancho de imagenes </label>
                                                            <input name="product_width" type="number" class="form-control" value="<?= $datos["product_width"] ?>" id="product_witdh" placeholder="Coloque el ancho de imagen" maxlength="10" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="product_height" class="form-label">Alto de imagenes </label>
                                                            <input name="product_height" type="number" class="form-control" value="<?= $datos["product_height"] ?>" id="product_height" placeholder="Coloque el alto de imagen" maxlength="10" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <hr>
                                                    <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="submit" class="btn btn-primary">Actualizar Mas Información</button>
                                                            <a href="<?php echo APP_URL; ?>productList/" class="btn btn-soft-success">Regresar</a>

                                                        </div>
                                                        <p class="has-text-centered pt-6">
                                                            <small>Los campos marcados con
                                                                <strong><?php echo CAMPO_OBLIGATORIO; ?></strong> son obligatorios</small>
                                                        </p>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </form>
                                            <!--end tab-pane-->
                                        </div>
                                    </div>
                                    <!--<php echo APP_URL; ?>app/ajax/productAjax.php-->
                                    <div class="tab-pane <?= $tab4 ?>" id="interes" role="tabpanel">
                                        <div class="row">
                                            <form action="" method="POST">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <div class="mb-">
                                                            <label for="codigo" class="form-label">Código Negocio</label>
                                                            <input name="codigo" type="text" class="form-control" name="codigo" id="product_id" value="<?php echo $datos['product_id']; ?>" maxlength="40" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="product_name" class="form-label">Nombre del Negocio</label>
                                                            <input name="product_name" type="text" class="form-control" id="product_name" value="<?php echo $datos['product_name']; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="product_categoria" class="form-label">Categorias</label>
                                                            <select name="product_categoria" language="javascript:void(0)" onchange="loadAjaxCatSubcat(this.value, '')" class="form-control" data-choices data-choices-text-unique-true id="product_categoria">
                                                                <option value="">Escoja una opción</option>
                                                                <?php
                                                                if (is_array($categorias)) {
                                                                    foreach ($categorias as $categoria) {
                                                                ?>
                                                                        <option value="<?= $categoria['categoria_id']; ?>" <?= $datos['product_categoria'] == $categoria['categoria_id'] ? "selected" : "" ?>><?= $categoria['nombre']; ?>
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
                                                                <option value="">Escoja una opción</option>
                                                                <?php
                                                                $sql = "SELECT * FROM company_categorias WHERE unidad= " . $datos['product_categoria'] . " AND company_id=$company_id AND estatus=1 ORDER BY nombre";
                                                                //echo $sql;
                                                                if ($res = $mysqli->query("SELECT * FROM company_categorias WHERE unidad= " . $datos['product_categoria'] . " AND company_id=$company_id AND estatus=1 ORDER BY nombre")) {
                                                                ?>
                                                                    <?php while ($fila = mysqli_fetch_array($res)) { ?>
                                                                        <option value="<?php echo $fila['categoria_id']; ?>" <?php if ($fila['categoria_id'] == $datos["product_subcat"]) echo "selected"; ?>>
                                                                            <?php echo $fila['categoria_id'] == "" ? "Seleccione Modelo" : $fila['nombre']; ?>
                                                                        </option>
                                                                    <?php } ?>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="accion" class="form-label">Acción</label>
                                                        <div class="hstack gap-2">
                                                            <button name="buscar_productos" type="submit" class="btn btn-primary">Buscar Productos</button>
                                                        </div>
                                                    </div>
                                                    <hr>
                                            </form>

                                            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" autocomplete="off">
                                                <input type="hidden" name="modulo_product" value="actualizarInteres">
                                                <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                                                <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                                                <input type="hidden" name="tab" value="interes">
                                                <div class="col-lg-10">
                                                    <div class="mb-3">
                                                        <table width="100%" border="0" cellspacing="10">
                                                            <tr>
                                                                <td width="14%">
                                                                    <span class="texto">Seleccione los productos a incluir en la relación</span>:
                                                                </td>
                                                                <td width="86%">
                                                                    <select name="product_list[]" size="8" multiple="multiple" class="form-control" id="producto">
                                                                        <?php
                                                                        if (is_array($product_list)) {
                                                                            foreach ($product_list as $prod) {
                                                                                if($product_id != $prod['product_id']){
                                                                                ?>
                                                                                <option value="<?= $prod['product_id'] ?>">
                                                                                    <?= $prod['product_codigo'] . " - (" . $prod['product_name'] . ")"; ?>
                                                                                </option>
                                                                                <?php
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td><span class="form-control">
                                                                        <input name="Submit" type="submit" class="btn btn-success" id="Submit" value="Incluir" />
                                                                    </span></td>
                                                            </tr>
                                            </form>
                                            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" autocomplete="off">
                                                <input type="hidden" name="modulo_product" value="excluirInteres">
                                                <input type="hidden" name="tab" value="interes">
                                                <tr>
                                                    <td><span class="texto">Productos de interés seleccionados</span>:</td>
                                                    <td width="86%">
                                                        <select name="product_relacionados[]" size="8" multiple="multiple" class="form-control" id="producto_relacionados">
                                                            <?php
                                                            if (is_array($product_relacionados)) {
                                                                foreach ($product_relacionados as $relacion) {
                                                            ?>
                                                                    <option value="<?= $relacion['interes_id'] ?>">
                                                                        <?= $relacion['product_codigo'] . " - (" . $relacion['product_name'] . ")"; ?>
                                                                    </option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td><span class="form-control">
                                                            <input name="excluir_productos" type="submit" class="btn btn-danger" id="Submit" value="Excluir" />
                                                        </span></td>
                                                </tr>
                                                </table>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <!--end row-->
                                <!--end tab-pane-->
                            </div>
                        </div>
                        <!--end tab-pane-->

                        <div class="tab-pane <?= $tab6 ?>" id="subproductos" role="tabpanel">
                            <div class="row">
                                <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" 
                                    method="POST" autocomplete="off">
                                    <input type="hidden" name="modulo_product" value="actualizarSubproducto">
                                    <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                                    <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                                    <input type="hidden" name="tab" value="subproductos">
                                    
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <div class="mb-3">
                                                <label for="product_name" class="form-label">Nombre del Producto #<?php echo $product_id; ?></label>
                                                <input name="product_name" type="text" class="form-control" id="product_name" 
                                                value="<?=$product_name;?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="countryInput" class="form-label">Unidad/Medida</label>
                                                <select name="product_unidad" class="form-control" data-choices data-choices-text-unique-true id="product_unidad" disabled>
                                                    <?php
                                                    if (is_array($unidades)) {
                                                        foreach ($unidades as $unidad) {
                                                    ?>
                                                            <option value="<?= $unidad['control_id']; ?>" <?= $datos['product_unidad'] == $unidad['control_id'] ? "selected" : "" ?>><?= $unidad['nombre']; ?>
                                                            </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <label for="subproduct_precio" class="form-label">Precio US$</label>
                                                <input name="subproduct_precio" type="number" class="form-control" id="subproduct_precio" 
                                                value="<?=$product_precio;?>" disabled>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="subproduct_size" class="form-label">Atributo1 (ej. SIZE)</label>
                                                <input name="subproduct_size" type="text" class="form-control" 
                                                id="codigo" placeholder="Entre el Atributo #1" 
                                                value="SIZE" maxlength="80" required>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="subproduct_color" class="form-label">Atributo2 (ej. COLOR)</label>
                                                <input name="subproduct_color" type="text" class="form-control" 
                                                id="codigo" placeholder="Entre el Atributo #1" 
                                                value="COLOR" maxlength="80" required>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <label for="subproduct_costo" class="form-label">Costo Unitario $</label>
                                                <input name="subproduct_costo" type="number" class="form-control" 
                                                id="subproduct_costo" placeholder="Entre el costo del subproducto $" value="0.00" maxlength="80" required>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <label for="subproduct_stock" class="form-label">Stock Unidades</label>
                                                <input name="subproduct_stock" type="number" class="form-control" 
                                                id="subproduct_stock" placeholder="Entre el Stock inicial del subproducto" 
                                                value="0" required maxlength="80">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <label for="submitAccion" class="form-label">
                                                    <strong>Acción</strong></label><br>
                                                <button type="submit" name="submit" value="agregar" class="btn btn-info">Agregar</button>
                                            </div>
                                        </div>
                                        <hr>
                                </form>
                                        <div align="center" class="table-responsive-sm">
                                            <div class="col-lg-10">
                                                <table class="table table-sm table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>Atrib 1</td>
                                                            <td>Atrib 2</td>
                                                            <td>Precio</td>
                                                            <td>Stock</td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (is_array($product_subproductos)) {
                                                            foreach ($product_subproductos as $subproducto) {
                                                            ?>  
                                                            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" 
                                                            method="POST" autocomplete="off">
                                                            <input type="hidden" name="modulo_product" value="detalleSubproducto">
                                                            <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                                                            <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                                                            <input type="hidden" name="subproduct_id" value="<?= $subproducto['subproduct_id']; ?>">
                                                            <input type="hidden" name="tab" value="subproductos">
                                                                <tr>
                                                                    <td>
                                                                    <input name="subproduct_size" type="text" class="form-control" 
                                                                    id="subproduct_size" required
                                                                    value="<?= $subproducto['subproduct_size']; ?>" maxlength="80" >
                                                                    </td>
                                                                    
                                                                    <td>
                                                                    <input name="subproduct_color" type="text" class="form-control" 
                                                                    id="subproduct_color" required
                                                                    value="<?= $subproducto['subproduct_color']; ?>" maxlength="80" >
                                                                    </td>
                                                                    
                                                                    <td>
                                                                    <input name="subproduct_costo" type="text" class="form-control" 
                                                                    id="subproduct_costo" 
                                                                    value="<?= $subproducto['subproduct_costo']; ?>" maxlength="80" required>
                                                                    </td>
                                                                    
                                                                    <td>
                                                                    <input name="subproduct_stock" type="text" class="form-control" 
                                                                    id="subproduct_stock" 
                                                                    value="<?= $subproducto['subproduct_stock']; ?>" maxlength="80" required>
                                                                    </td>

                                                                    <td>
                                                                    <div class="col-lg-1">
                                                                        <div class="mb-3">
                                                                            <button type="submit" name="accion" value="update" class="btn btn-success"><i class="ri-edit-line"></i></button>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                    <div class="col-lg-1">
                                                                        <div class="mb-3">
                                                                            <button type="submit" name="accion" value="delete" class="btn btn-danger"><i class="ri-delete-bin-5-line"></i></button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </form>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <div class="hstack gap-2 justify-content-end">
                                                    <a href="<?php echo APP_URL; ?>productList/" class="btn btn-soft-success">Regresar</a>
                                                </div><br>
                                                <p class="has-text-centered pt-6">
                                                    <small>Los campos marcados con
                                                        <strong><?php echo CAMPO_OBLIGATORIO; ?></strong> son obligatorios</small>
                                                </p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                <!--end tab-pane-->
                            </div>
                        </div>
                        <!--end tab-pane-->

                        <div class="tab-pane <?= $tab7 ?>" id="descuentos" role="tabpanel">
                        <div class="row">
                                <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" 
                                    method="POST" autocomplete="off">
                                    <input type="hidden" name="modulo_product" value="actualizarDescuento">
                                    <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                                    <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                                    <input type="hidden" name="tab" value="descuentos">
                                    
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="product_name" class="form-label">Nombre del Producto #<?php echo $product_id; ?></label>
                                                <input name="product_name" type="text" class="form-control" id="product_name" 
                                                value="<?=$product_name;?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="countryInput" class="form-label">Unidad/Medida</label>
                                                <select name="product_unidad" class="form-control" data-choices data-choices-text-unique-true id="product_unidad" disabled>
                                                    <?php
                                                    if (is_array($unidades)) {
                                                        foreach ($unidades as $unidad) {
                                                    ?>
                                                            <option value="<?= $unidad['control_id']; ?>" <?= $datos['product_unidad'] == $unidad['control_id'] ? "selected" : "" ?>><?= $unidad['nombre']; ?>
                                                            </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <label for="product_precio" class="form-label">Precio</label>
                                                <input name="product_precio" type="number" class="form-control" id="product_precio" 
                                                value="<?=$product_precio;?>" disabled>
                                            </div>
                                        </div>

                                        <hr>
                                        
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="desde" class="form-label">Cantidad Unidades Desde</label>
                                                <input name="desde" type="number" class="form-control" id="desde" 
                                                value="0>" required placeholder="Cantidad minima del descuento">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="hasta" class="form-label">Cantidad  Unidades Hasta</label>
                                                <input name="hasta" type="text" class="form-control" 
                                                id="codigo" placeholder="Cantidad maxima del descuento" 
                                                value="0" maxlength="80" required>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="valor" class="form-label">% Descuento</label>
                                                <input name="valor" type="text" class="form-control" 
                                                id="codigo" placeholder="coloque descuento a aplicar" 
                                                value="0.00" maxlength="80" required>
                                            </div>
                                                </div>
                                        <!--end col-->
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="submitAccion" class="form-label">
                                                    <strong>Acción</strong></label><br>
                                                <button type="submit" name="submit" value="agregar" class="btn btn-info">Agregar</button>
                                            </div>
                                        </div>
                                        <hr>
                                </form>
                                        <div align="center" class="table-responsive-sm">
                                            <div class="col-lg-10">
                                                <table class="table table-sm table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>Cant Desde</td>
                                                            <td>Cant Hasta</td>
                                                            <td>% Descuento</td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (is_array($product_descuentos)) {
                                                            foreach ($product_descuentos as $descuento) {
                                                            ?>  
                                                            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" 
                                                            method="POST" autocomplete="off">
                                                            <input type="hidden" name="modulo_product" value="detalleDescuento">
                                                            <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                                                            <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                                                            <input type="hidden" name="descuento_id" value="<?= $descuento['descuento_id']; ?>">
                                                            <input type="hidden" name="tab" value="descuentos">
                                                                <tr>
                                                                    <td>
                                                                    <input name="desde" type="number" class="form-control" 
                                                                    id="desde" required
                                                                    value="<?= $descuento['desde']; ?>" maxlength="80" >
                                                                    </td>
                                                                    
                                                                    <td>
                                                                    <input name="hasta" type="number" class="form-control" 
                                                                    id="hasta" required
                                                                    value="<?= $descuento['hasta']; ?>" maxlength="80" >
                                                                    </td>
                                                                    
                                                                    <td>
                                                                    <input name="valor" type="number" step="any" class="form-control" 
                                                                    id="valor" step="0.01" 
                                                                    value="<?= $descuento['valor']; ?>" maxlength="80" required>
                                                                    </td>
                                                                    
                                                                    <td>
                                                                    <div class="col-lg-1">
                                                                        <div class="mb-3">
                                                                            <button type="submit" name="accion" value="update" class="btn btn-success"><i class="ri-edit-line"></i></button>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                    <div class="col-lg-1">
                                                                        <div class="mb-3">
                                                                            <button type="submit" name="accion" value="delete" class="btn btn-danger"><i class="ri-delete-bin-5-line"></i></button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </form>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <div class="hstack gap-2 justify-content-end">
                                                    <a href="<?php echo APP_URL; ?>productList/" class="btn btn-soft-success">Regresar</a>
                                                </div><br>
                                                <p class="has-text-centered pt-6">
                                                    <small>Los campos marcados con
                                                        <strong><?php echo CAMPO_OBLIGATORIO; ?></strong> son obligatorios</small>
                                                </p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                <!--end tab-pane-->
                            </div>
                        </div>
                        <!--end tab-pane-->

                        <div class="tab-pane <?= $tab8 ?>" id="cupones" role="tabpanel">
                            <div class="row">
                                <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/companyAjax.php" 
                                    method="POST" autocomplete="off">
                                    <input type="hidden" name="modulo_company" value="actualizarCupones">
                                    <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                                    <input type="hidden" name="producto_id" value="<?= $product_id ?>">
                                    <input type="hidden" name="tab" value="cupones">
                                    
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="mb-">
                                                <label for="codigo" class="form-label">Código Producto</label>
                                                <input name="product_id" type="text" class="form-control" id="product_id" value="<?php echo $product_id; ?>" maxlength="40" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="product_name" class="form-label">Nombre del Producto</label>
                                                <input name="product_name" type="text" class="form-control" id="product_name" 
                                                value="<?=$product_name;?>" disabled>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <label for="dia_semana" class="form-label"><strong>Dia de la semana</strong></label>
                                                <select name="dia_semana" class="form-control" data-choices data-choices-text-unique-true id="tipo">
                                                    <option value="0">Lunes</option>
                                                    <option value="1">Martes</option>
                                                    <option value="2">Miércoles</option>
                                                    <option value="3">Jueves</option>
                                                    <option value="4">Viernes</option>
                                                    <option value="5">Sábado</option>
                                                    <option value="6">Domingo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="hora_desde" class="form-label">
                                                    <strong>Hora Desde</strong></label>
                                                <select name="hora_desde" class="form-control" data-choices data-choices-text-unique-true id="tipo">
                                                   
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="hora_hasta" class="form-label">
                                                    <strong>Hora Hasta</strong></label>
                                                <select name="hora_hasta" class="form-control" data-choices data-choices-text-unique-true id="tipo">
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="company_slogan" class="form-label">
                                                    <strong>Acción</strong></label><br>
                                                <button type="submit" name="submit" value="dia" class="btn btn-info">Aplica al dia</button>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-lg-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="row">Horario</th>
                                                        <td>Lunes</td>
                                                        <td>Martes</td>
                                                        <td>Miercoles</td>
                                                        <td>Jueves</td>
                                                        <td>Viernes</td>
                                                        <td>Sábado</td>
                                                        <td>Domingo</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="hstack gap-2 justify-content-end">
                                                <a href="<?php echo APP_URL; ?>productList/" class="btn btn-soft-success">Regresar</a>
                                            </div>
                                            <p class="has-text-centered pt-6">
                                                <small>Los campos marcados con
                                                    <strong><?php echo CAMPO_OBLIGATORIO; ?></strong> son obligatorios</small>
                                            </p>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                                <!--end tab-pane-->
                            </div>
                        </div>
                        <!--end tab-pane-->
                        
                        <div class="tab-pane <?= $tab5 ?>" id="etiquetas" role="tabpanel">
                            <div class="row">
                                <form action="" method="POST">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="mb-">
                                                <label for="codigo" class="form-label">Código Negocio</label>
                                                <input name="codigo" type="text" class="form-control" name="codigo" id="product_id" value="<?php echo $datos['product_id']; ?>" maxlength="40" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="product_name" class="form-label">Nombre del Negocio</label>
                                                <input name="product_name" type="text" class="form-control" id="product_name" value="<?php echo $datos['product_name']; ?>" disabled>
                                            </div>
                                        </div>
                                        <hr>
                                </form>

                                <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" autocomplete="off">
                                    <input type="hidden" name="modulo_product" value="actualizarEtiquetas">
                                    <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                                    <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                                    <input type="hidden" name="tab" value="etiquetas">
                                    <div class="col-lg-10">
                                        <div class="mb-3">
                                            <table width="100%" border="0" cellspacing="10">
                                                <tr>
                                                    <td width="14%">
                                                        <span class="texto">Seleccione las etiquetas a incluir en el portal</span>:
                                                    </td>
                                                    <td width="86%">
                                                        <select name="etiqueta_list[]" size="8" multiple="multiple" class="form-control" id="etiqueta">
                                                            <?php
                                                            if (is_array($etiquetas)) {
                                                                foreach ($etiquetas as $etiqueta) {
                                                            ?>
                                                                    <option value="<?= $etiqueta['control_id'] ?>">
                                                                        <?= $etiqueta['nombre']; ?>
                                                                    </option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td><span class="form-control">
                                                            <input name="Submit" type="submit" class="btn btn-success" id="Submit" value="Incluir" />
                                                        </span></td>
                                                </tr>
                                </form>
                                <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" autocomplete="off">
                                    <input type="hidden" name="modulo_product" value="excluirEtiquetas">
                                    <input type="hidden" name="tab" value="etiquetas">
                                    <tr>
                                        <td><span class="texto">Etiquetas Seleccionadas</span>:</td>
                                        <td width="86%">
                                            <select name="product_etiquetas[]" size="8" multiple="multiple" class="form-control" id="product_etiquetas">
                                                <?php
                                                if (is_array($product_etiquetas)) {
                                                    foreach ($product_etiquetas as $etiqueta) {
                                                    ?>
                                                    <option value="<?= $etiqueta['etiqueta'] ?>">
                                                        <?= $etiqueta['nombre']; ?>
                                                    </option>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><span class="form-control">
                                                <input name="excluir_productos" type="submit" class="btn btn-danger" id="Submit" value="Excluir" />
                                            </span></td>
                                    </tr>
                                    </table>
                            </div>
                        </div>
                        </form>

                    </div>
                    <!--end row-->
                </div>
        </div>
        <!--end tab-pane-->

    </div>
    <!--end tab-pane-->
</div>
</div>
</div>
</div>
</div>
<!--end row-->
<?php
            }
?>
</div>
<!-- container-fluid -->
</div><!-- End Page-content -->
</div>