<!-- ============================================================== -->
<!-- BASE DE DATOS PARA AJAX -->
<!-- ============================================================== -->
<?php
$mysqli = new mysqli("localhost", "root", "", "multimarket");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
// <?php echo $fila['city'] == "" ? "Seleccione Ciudad" : $fila['city']; 
?>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <?php
            $product_id = $insLogin->limpiarCadena($url[1]);
            $datos = $insLogin->seleccionarDatos("Unico", "company_products", "product_id", $product_id);
            if ($datos->rowCount() == 1) {
                $datos = $datos->fetch();
                $product_modelo = $datos['product_modelo'];
                $company_id = $datos['company_id'];
                $product_name   = $datos['product_name'];
                $product_description   = $datos['product_description'];
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
            if (!isset($_SESSION["tab"])) {
                $_SESSION["tab"] = "";
            }
            
            if ($pasa == 1) {
            ?>
                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card mt-n6">
                            <div class="card-body p-1">
                                <div class="text-center">
                                    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/productAjax.php"
                                    method="POST" autocomplete="off" enctype="multipart/form-data">
                                        <input type="hidden" name="modulo_product" value="actualizarFoto">
                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                        <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                            <img src="
                                            <?php
                                            echo $product_logo == "nophoto.jpg" || $product_logo=="" 
                                                ? APP_URL."app/views/fotos/nophoto.jpg"
                                                : APP_URL."app/views/fotos/company/$company_id/productos/" . $product_logo;
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
                    if (!isset($_SESSION["tab"])) {
                        $_SESSION["tab"] = "personaldetails";
                    }
                    if ($_SESSION["tab"] == "personaldetails") {
                        $tab1 = "active";
                        ?><script>location.href = "#personaldetails";</script><?php

                    } else if ($_SESSION["tab"] == "multimedia") {
                        $tab2 = "active";
                        ?><script>location.href = "#multimedia";</script><?php

                    } else if ($_SESSION["tab"] == "masinformacion") {
                        $tab3 = "active";
                        ?><script>location.href = "#masinformacion";</script><?php

                    } else if ($_SESSION["tab"] == "horario") {
                        $tab4 = "active";
                        ?><script>location.href = "#horario";</script><?php
                    } else if ($_SESSION["tab"] == "ubicacion") {
                        $tab5 = "active";
                        ?><script>location.href = "#ubicacion";</script><?php
                    } else {
                        $tab1 = "active";
                        ?><script>location.href = "#personaldetails";</script><?php
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
                                        <a class="nav-link <?= $tab4 ?>" id="tab-header-4" data-bs-toggle="tab" href="#horario" role="tab">
                                            <i class="far fa-user"></i> Horario
                                        </a>
                                    </li>

                                    <li li class="nav-item">
                                        <a class="nav-link <?= $tab5 ?>" id="tab-header-5" data-bs-toggle="tab" href="#ubicacion" role="tab">
                                            <i class="far fa-user"></i> Ubicación
                                        </a>
                                    </li>
                                </ul>
                            </div>
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
                                                    <input name="product_codigo" type="text" class="form-control" 
                                                    value="<?php echo $datos['product_codigo']?>" 
                                                    id="product_codigo" placeholder="Codigo del Producto" required 
                                                    />
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="product_name" class="form-label">Nombre del producto</label>
                                                    <input name="product_name" type="text" class="form-control" 
                                                    id="codigo" placeholder="Entre el nombre oficial" 
                                                    pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{5,80}" 
                                                    value="<?php echo $datos['product_name']?>" 
                                                    maxlength="80" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3 pb-2">
                                                    <label for="location" class="form-label">Descripción del producto</label><textarea name="product_description" class="form-control" id="product_description"  placeholder="Breve descripción del producto" rows="3"><?php echo $datos['product_description']?></textarea>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="product_precio" class="form-label">Precio del producto</label>
                                                    <input class="form-control" name="product_precio" type="number" placeholder="0.00" required min="0" value="<?php echo $datos['product_precio'];?>" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'"
                                                    >
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="product_anterior" class="form-label">Precio anterior a la oferta</label>
                                                    <input class="form-control" name="product_anterior" type="number" placeholder="0.00" min="0" value="<?php echo $datos['product_anterior'];?>" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$"
                                                    <?php echo $datos['product_anterior']?>
                                                    >
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
                                                                <?=$datos['product_unidad'] == $unidad['control_id'] ?"selected":""?>
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
                                                        <option value="0"
                                                        <?=$datos['product_inventariable'] == "0" ?"selected":""?>
                                                        >No inventariable</option>
                                                        <option value="1" 
                                                        <?=$datos['product_inventariable'] == "1" ?"selected":""?>
                                                        >Si Maneja inventario</option>
                                                        <option value="2" 
                                                        <?=$datos['product_inventariable'] == "2" ?"selected":""?>
                                                        >Es producto digital</option>
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
                                                        <option value="1"
                                                        <?=$datos['product_estatus'] == "1" ?"selected":""?>
                                                        >Activo</option>
                                                        <option value="0"
                                                        <?=$datos['product_estatus'] == "0" ?"selected":""?>
                                                        >Inactivo</option>
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
                                                            <option value="<?=$proveedor['proveedor_id'];?>"
                                                            <?=$datos['product_proveedor'] == $proveedor['proveedor_id'] ?"selected":""?>
                                                            ><?=$proveedor['proveedor_name'];?>
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
                                                        <option value="1" 
                                                        <?=$datos['product_usado'] == "1" ?"selected":""?>
                                                        >Es Usado</option>
                                                        <option value="0" 
                                                        <?=$datos['product_usado'] == "0" ?"selected":""?>
                                                        >Es nuevo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="product_marca" class="form-label">Marca</label>
                                                    <select name="product_marca" 
                                                    language="javascript:void(0)" 
                                                    onchange="loadAjaxMarcaModelo(this.value, <?=$product_modelo?>)"
                                                    class="form-control" data-choices data-choices-text-unique-true id="state">
                                                    <option value="">Escoja una opción</option>
                                                    <?php
                                                    if(is_array($marcas)){
                                                        foreach($marcas as $marca){
                                                            ?>
                                                            <option value="<?=$marca['marca_id'];?>"
                                                            <?=$datos['product_marca'] == $marca['marca_id'] ?"selected":""?>
                                                            ><?=$marca['nombre'];?>
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
                                                        $sql = "SELECT * FROM company_marcas WHERE unidad= ".$datos['product_marca']." AND company_id=$company_id AND estatus=1 ORDER BY nombre";
                                                        //echo $sql;
                                                        if ($res = $mysqli->query("SELECT * FROM company_marcas WHERE unidad= ".$datos['product_marca']." AND company_id=$company_id AND estatus=1 ORDER BY nombre")) {
                                                        ?>
                                                            <?php while ($fila = mysqli_fetch_array($res)) { ?>
                                                                <option value="<?php echo $fila['marca_id']; ?>" 
                                                                <?php if ($fila['marca_id'] == $datos["product_modelo"]) echo "selected"; ?>>
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
                                                    <input name="product_year" type="number" class="form-control" 
                                                    value="<?=$datos['product_year']?>"
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
                                                            <option value="<?=$categoria['categoria_id'];?>"
                                                            <?=$datos['product_categoria'] == $categoria['categoria_id'] ?"selected":""?>
                                                            ><?=$categoria['nombre'];?>
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
                                                            $sql = "SELECT * FROM company_categorias WHERE unidad= ".$datos['product_categoria']." AND company_id=$company_id AND estatus=1 ORDER BY nombre";
                                                            //echo $sql;
                                                            if ($res = $mysqli->query("SELECT * FROM company_categorias WHERE unidad= ".$datos['product_categoria']." AND company_id=$company_id AND estatus=1 ORDER BY nombre")) {
                                                            ?>
                                                                <?php while ($fila = mysqli_fetch_array($res)) { ?>
                                                                    <option value="<?php echo $fila['categoria_id']; ?>" 
                                                                    <?php if ($fila['categoria_id'] == $datos["product_subcat"]) echo "selected"; ?>>
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
                                            //echo $createdAt; ?>
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Actualizar el Producto</button>
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
                                        </form>
                                    </div>
                                    <!--end tab-pane-->
                                    <div class="tab-pane <?= $tab2 ?>" id="multimedia" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <form class="FormularioAjax" name="<?php echo $product_tipo; ?>" 
                                                action="<?php echo APP_URL; ?>app/ajax/productAjax.php" method="POST" 
                                                autocomplete="off" enctype="multipart/form-data">
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
                                                                            ? APP_URL."app/views/fotos/nophoto.jpg"
                                                                            : APP_URL."app/views/fotos/company/$company_id/productos/".$product_card;
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
                                                                            ? APP_URL."app/views/fotos/nophoto.jpg"
                                                                            : APP_URL."app/views/fotos/company/$company_id/productos/".$product_banner1;
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
                                                                            ? APP_URL."app/views/fotos/nophoto.jpg"
                                                                            : APP_URL."app/views/fotos/company/$company_id/productos/". $product_banner2;
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
                                                                ? APP_URL."app/views/fotos/nophoto.jpg"
                                                                : APP_URL."app/views/fotos/company/$company_id/productos/".$product_banner3;
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
                                            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/proveedorAjax.php" 
                                            method="POST" autocomplete="off">
                                                <input type="hidden" name="modulo_product" value="actualizarMasInformacion">
                                                <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                                                <input type="hidden" name="tab" value="masinformacion">
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
                                                    <?php
                                                    $vector = [1, 2, 3];
                                                    for ($i = 0; $i < 3; $i++) {
                                                    ?>
                                                        <div class="col-lg-2">
                                                            <div class="mb-3">
                                                                <label for="product_red" class="form-label">
                                                                    <?php if ($i == 0) {
                                                                        echo "<strong>";
                                                                    } ?>
                                                                    Red Social #
                                                                    <?php if ($i == 0) {
                                                                        echo "</strong>";
                                                                    } ?>
                                                                </label>
                                                                <select name="product_red<?= $i + 1 ?>" class="form-control" required data-choices data-choices-text-unique-true id="product_red<?= $i + 1; ?>">
                                                                    <option value="facebook" <?php if ($datos['product_red' . ($i + 1)] == 'facebook') echo "selected" ?>>facebook</option>
                                                                    <option value="instagram" <?php if ($datos['product_red' . ($i + 1)] == 'instagram') echo "selected" ?>>instagram</option>
                                                                    <option value="twitterx" <?php if ($datos['product_red' . ($i + 1)] == 'twitterx') echo "selected" ?>>twitterx</option>
                                                                    <option value="tiktok" <?php if ($datos['product_red' . ($i + 1)] == 'tiktok') echo "selected" ?>>tiktok</option>
                                                                    <option value="youtube" <?php if ($datos['product_red' . ($i + 1)] == 'youtube') echo "selected" ?>>youtube</option>
                                                                    <option value="pinterest" <?php if ($datos['product_red' . ($i + 1)] == 'pinterest') echo "selected" ?>>pinterest</option>
                                                                    <option value="linkedin" <?php if ($datos['product_red' . ($i + 1)] == 'linkedin') echo "selected" ?>>linkedin</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-2">
                                                            <div class="mb-3">
                                                                <label for="product_red_valor<?= $i + 1; ?>" class="form-label">URL Red Social <?= $i + 1; ?></label>
                                                                <input name="product_red_valor<?= $i + 1; ?>" type="text" class="form-control" value="<?= $datos["product_red_valor" . ($i + 1)] ?>" id="product_red_valor<?= $i + 1; ?>" placeholder="Red<?= $i + 1; ?> selección" required />
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                    <?php
                                                    }
                                                    ?>
                                                    <hr>
                                                    <div class="col-lg-5">
                                                        <div class="mb-3">
                                                            <label for="product_web" class="form-label">Página Web del negocio</label>
                                                            <input name="product_web" type="text" class="form-control" value="<?= $datos["product_web"] ?>" id="product_web" placeholder="Entre Pagina web del negocio" maxlength="240">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="product_youtube_index" class="form-label">
                                                                <strong>Video de Youtube</strong></label>
                                                            <input name="product_youtube_index" type="text" class="form-control" value="<?= $datos["product_youtube_index"] ?>" id="product_youtube_index" placeholder="Valor indice del video" />
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="product_logo_witdh" class="form-label">Ancho del Logo </label>
                                                            <input name="product_logo_witdh" type="number" class="form-control" value="<?= $datos["product_logo_witdh"] ?>" id="product_logo_witdh" placeholder="Coloque el ancho del logo" maxlength="10" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="product_logo_height" class="form-label">Alto del Logo </label>
                                                            <input name="product_logo_height" type="number" class="form-control" value="<?= $datos["product_logo_height"] ?>" id="product_logo_height" placeholder="Coloque el alto del logo" maxlength="10" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <hr>
                                                    <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="submit" class="btn btn-primary">Actualizar Mas Información</button>
                                                            <a href="<?php echo APP_URL; ?>proveedorList/" class="btn btn-soft-success">Regresar</a>

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

                                    <div class="tab-pane <?= $tab4 ?>" id="horario" role="tabpanel">
                                        <div class="row">
                                            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/proveedorAjax.php" 
                                                method="POST" autocomplete="off">
                                                <input type="hidden" name="modulo_product" value="actualizarZonaHoraria">
                                                <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                                                <input type="hidden" name="tab" value="horario">
                                                <input type="hidden" name="product_horario_desde" value="<?= $datos['product_horario_desde'] ?>">
                                                <input type="hidden" name="product_horario_hasta" value="<?= $datos['product_horario_hasta'] ?>">

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
                                                                <?php
                                                                $tabla_horas = [];
                                                                $tabla_minutos = ["00", "15", "30", "45"];
                                                                $k = 0;
                                                                for ($i = 0; $i <= 23; $i++) {
                                                                    if ($i < 10) {
                                                                        $i_text = "0" . $i;
                                                                    } else {
                                                                        $i_text = "" . $i;
                                                                    };
                                                                    for ($j = 0; $j <= 3; $j++) {
                                                                        $k++;
                                                                        $tabla_horas[$k] = $i_text . ":" . $tabla_minutos[$j];
                                                                    ?>
                                                                        <option value="<?= $tabla_horas[$k] ?>" <?= $tabla_horas[$k] == "08:00" ? "selected" : ""; ?>><?= "Entrando: " . $tabla_horas[$k] ?></option><?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label for="hora_hasta" class="form-label">
                                                                <strong>Hora Hasta</strong></label>
                                                            <select name="hora_hasta" class="form-control" data-choices data-choices-text-unique-true id="tipo">
                                                                <?php
                                                                $tabla_horas = [];
                                                                $tabla_minutos = ["00", "15", "30", "45"];
                                                                $k = 0;
                                                                for ($i = 0; $i <= 23; $i++) {
                                                                    if ($i < 10) {
                                                                        $i_text = "0" . $i;
                                                                    } else {
                                                                        $i_text = "" . $i;
                                                                    };
                                                                    for ($j = 0; $j <= 3; $j++) {
                                                                        $k++;
                                                                        $tabla_horas[$k] = $i_text . ":" . $tabla_minutos[$j];
                                                                ?>
                                                                        <option value="<?= $tabla_horas[$k] ?>" <?= $tabla_horas[$k] == "18:00" ? "selected" : ""; ?>><?= "Saliendo: " . $tabla_horas[$k] ?></option><?php
                                                                    }
                                                                }

                                                                $desdehora=[];
                                                                $hastahora=[];
                                                                $desdehora=explode("|", $datos['product_horario_desde']);
                                                                $hastahora=explode("|", $datos['product_horario_hasta']);

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="accion" class="form-label">
                                                                <strong>Acción</strong></label><br>
                                                            <button type="submit" name="submit" value="dia" class="btn btn-info">Aplica al dia</button>
                                                            <button type="submit" name="submit" value="semana" class="btn btn-danger">Aplica a semana</button>
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
                                                                    <th scope="row">Entrada</th>
                                                                    <?php
                                                                    for ($i=0; $i <=6 ; $i++) { 
                                                                        ?><td><?=$desdehora[$i];?></td><?php
                                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr>
                                                                <th scope="row">Salida</th>
                                                                    <?php
                                                                    for ($i=0; $i <=6 ; $i++) { 
                                                                        ?><td><?=$hastahora[$i];?></td><?php
                                                                    }
                                                                    ?>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <a href="<?php echo APP_URL; ?>proveedorList/" class="btn btn-soft-success">Regresar</a>
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
                                    <div class="tab-pane <?= $tab5 ?>" id="ubicacion" role="tabpanel">
                                        <div class="row">
                                            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/proveedorAjax.php" 
                                                method="POST" autocomplete="off">
                                                <input type="hidden" name="modulo_product" value="actualizarUbicacion">
                                                <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                                                <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                                                <input type="hidden" name="tab" value="ubicacion">
                                                
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
                                                    <?php 
                                                    require_once "./app/views/inc/ubicacionGeograficaProv.php";
                                                    ?>
                                                    <hr>
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <a href="<?php echo APP_URL; ?>proveedorList/" class="btn btn-soft-success">Regresar</a>
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