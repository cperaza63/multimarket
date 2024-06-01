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
            use app\controllers\ubicacionController;
            $ubicacionController = new ubicacionController();
            use app\controllers\controlController;
            $controlController = new controlController();
            use app\controllers\clienteController;
            $clienteController = new clienteController();
            if (!isset($_SESSION["tab"])) {
                $_SESSION["tab"] = "";
            }
            $cliente_id = $insLogin->limpiarCadena($url[1]);
            $datos = $insLogin->seleccionarDatos("Unico", "company_clientes", "cliente_id", $cliente_id);
            if ($datos->rowCount() == 1) {

                $datos = $datos->fetch();
                $company_id = $datos['company_id'];
                $cliente_name   = $datos['cliente_name'];
                $accion = "actualizar";
                $boton_accion = "Actualizar";
                $cliente_logo = $datos['cliente_logo'];
                if ($datos['cliente_logo'] == "") {
                    $cliente_logo = "nophoto.jpg";
                }
                $cliente_card = $datos['cliente_card'];
                if ($datos['cliente_card'] == "") {
                    $cliente_card = "nophoto.jpg";
                }
                $cliente_banner1 = $datos['cliente_banner1'];
                if ($datos['cliente_banner1'] == "") {
                    $cliente_banner1 = "nophoto.jpg";
                }
                $cliente_banner2 = $datos['cliente_banner2'];
                if ($datos['cliente_banner2'] == "") {
                    $cliente_banner2 = "nophoto.jpg";
                }
                $cliente_banner3 = $datos['cliente_banner3'];
                if ($datos['cliente_banner3'] == "") {
                    $cliente_banner3 = "nophoto.jpg";
                }
                $cliente_pdf = $datos['cliente_pdf'];
                if ($datos['cliente_pdf'] == "") {
                    $cliente_pdf = "nophoto.jpg";
                }
                $country_cliente = $datos['cliente_country'];
                $state_cliente = $datos['cliente_state'];
                $city_cliente = $datos['cliente_city'];
                $pasa = 1;
            } else {
                // registro es nuevo
                $accion = "registrar";
                $boton_accion = "Agregar";
                $pasa = 0;
            }
            // busco paises
            $paises = $ubicacionController->obtenerPaisControlador();
            // busco estados
            if (isset($_POST['cliente_country'])) {
                $estados = $ubicacionController->obtenerEstadosControlador($_POST['cliente_country']);
            } else {
                if ($country_cliente > 0) {
                    $estados = $ubicacionController->obtenerEstadosControlador($country_cliente);
                } else {
                    $estados = $ubicacionController->obtenerEstadosControlador(APP_COUNTRY);
                }
            }
            // Parametros para el ajax de Ciudad
            if (isset($_POST['cliente_state'])) {
                $q = $_POST['cliente_state'];
                $c = $_POST['cliente_city'];
            } else {
                $q = $state_cliente;
                $c = $city_cliente;
            }
            //print_r($cliente_logo);
            //exit();
            if ($pasa == 1) {
            ?>
                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card mt-n6">
                            <div class="card-body p-1">
                                <div class="text-center">
                                    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/clienteAjax.php"
                                    method="POST" autocomplete="off" enctype="multipart/form-data">
                                        <!--    Campos parametros     -->
                                        <input type="hidden" name="modulo_cliente" value="actualizarFoto">
                                        <input type="hidden" name="cliente_id" value="<?php echo $cliente_id; ?>">
                                        <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
                                        <input type="hidden" name="cliente_tipo" value="cliente_logo">

                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">

                                            <img src="
                                            <?php
                                            echo $cliente_logo == "nophoto.jpg"
                                                ? "<?php echo APP_URL; ?>app/views/fotos/nophoto.jpg"
                                                : "<?php echo APP_URL; ?>app/views/fotos/company/$company_id/clientes/" . $cliente_logo;
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
                                                            <input id="profile-img-file-input" name="cliente_logo" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">

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
                                    <h5 class="fs-16 mb-1"><?php echo "ACTUALIZANDO PROVEEDOR " . $datos['cliente_name']; ?></h5>
                                    <p class="text-muted mb-0"><?php echo "Item # " . $datos['cliente_id']; ?></p>
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
                                        <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/clienteAjax.php" 
                                        method="POST" autocomplete="off">
                                            <input type="hidden" name="modulo_cliente" value="<?= $accion; ?>">
                                            <input type="hidden" name="cliente_id" value="<?= $cliente_id; ?>">
                                            <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                                            <input type="hidden" name="tab" value="personaldetails">
                                            <input type="hidden" name="cliente_user" value="<?= $_SESSION['id'] ?>">

                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <div class="mb-3">
                                                        <label for="codigo" class="form-label">Código</label>
                                                        <input name="codigo" type="text" class="form-control" name="codigo" id="cliente_id" value="<?php echo $datos['cliente_id']; ?>" maxlength="40" disabled>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="cliente_name" class="form-label">Nombre de Negocio</label>
                                                        <input name="cliente_name" type="text" class="form-control" id="cliente_name" placeholder="Entre el nombre del negocio" value="<?php echo $datos['cliente_name']; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\-]{3,80}" maxlength="40" required>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3 pb-2">
                                                        <label for="cliente_description" class="form-label">Breve descripción</label>
                                                        <textarea name="cliente_description" class="form-control" id="cliente_description" placeholder="Breve descripción del negocio" rows="3"><?= trim($datos["cliente_description"]); ?></textarea>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3 pb-2">
                                                        <label for="location" class="form-label">Dirección</label>
                                                        <textarea name="cliente_address" class="form-control" id="cliente_address" placeholder="Dirección del negocio" rows="3"><?= $datos["cliente_address"] ?></textarea>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="countryInput" class="form-label">País</label>
                                                        <?php

                                                        if (is_array($paises)) {
                                                            foreach ($paises as $pais) {
                                                        ?>
                                                                <select name="cliente_country" class="form-control" data-choices data-choices-text-unique-true id="country">
                                                                    <option value="<?= $pais['country']; ?>" <?php if ($pais['country'] == $datos["cliente_country"]) echo "selected"; ?>><?= $pais['country']; ?>
                                                                    </option>
                                                                </select>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="cliente_state" class="form-label">Estado/Provincia</label>
                                                        <select name="cliente_state" language="javascript:void(0)" onchange="loadAjaxCiudadHive(this.value, <?= $city_cliente ?>)" class="form-control" data-choices data-choices-text-unique-true id="cliente_state">
                                                            <?php
                                                            if (is_array($estados)) {
                                                                foreach ($estados as $estado) {
                                                            ?>
                                                                    <option value="<?= $estado['state_abbreviation']; ?>" <?php if ($estado['state_abbreviation'] == $datos["cliente_state"]) echo "selected"; ?>><?= $estado['state_name']; ?>
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
                                                        <label for="cliente_city" class="form-label">Ciudades</label>
                                                        <select name="cliente_city" class="form-control" data-choices data-choices-text-unique-true id="city">
                                                            <?php
                                                            if ($res = $mysqli->query("SELECT * FROM ubicacion WHERE state_abbreviation<>'' AND 
                                                                state_abbreviation='$q' ORDER BY city")) {
                                                            ?>
                                                                <?php while ($fila = mysqli_fetch_array($res)) { ?>
                                                                    <option value="<?php echo $fila['id']; ?>" <?php if ($fila['id'] == $datos["cliente_city"]) echo "selected"; ?>>
                                                                        <?php echo $fila['city'] == "" ? "Seleccione Ciudad" : $fila['city']; ?>
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
                                                        <label for="cliente_email" class="form-label">Email del cliente</label>
                                                        <input name="cliente_email" type="email" class="form-control" value="<?= $datos["cliente_email"] ?>" id="cliente_email" placeholder="Email de la empresa" required />
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label for="cliente_phone" class="form-label">Teléfono contacto</label>
                                                        <input name="cliente_phone" type="number" class="form-control" value="<?= $datos["cliente_phone"] ?>" id="codigo" placeholder="Entre su numero de contacto" maxlength="80" required>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label for="cliente_rif" class="form-label">Número de Rif</label>
                                                        <input name="cliente_rif" type="text" class="form-control" value="<?= $datos["cliente_rif"] ?>" id="codigo" placeholder="Entre su numero de rif, ejemplo: J12304567890" maxlength="20" required>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-2">
                                                    <div class="mb-3">
                                                        <label for="cliente_estatus" class="form-label">Estatus Actual</label>
                                                        <select name="cliente_estatus" class="form-control" required data-choices data-choices-text-unique-true id="tipo">
                                                            <option value="1" <?php if ($datos["cliente_estatus"] == 1) echo "selected"; ?>>Activo</option>
                                                            <option value="0" <?php if ($datos["cliente_estatus"] == 0) echo "selected"; ?>>Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <?php
                                                $createdAt = date("Y-m-d");
                                                //echo $createdAt; 
                                                ?>

                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-primary">Actualizar el Cliente</button>
                                                        <a href="<?php echo APP_URL; ?>clienteList/" class="btn btn-soft-success">Regresar</a>

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
                                                <form class="FormularioAjax" name="<?php echo $cliente_tipo; ?>" 
                                                action="<?php echo APP_URL; ?>app/ajax/clienteAjax.php" method="POST" 
                                                autocomplete="off" enctype="multipart/form-data">
                                                    <input type="hidden" name="modulo_cliente" value="actualizarFotoMasa">
                                                    <input type="hidden" name="cliente_id" value="<?php echo $datos['cliente_id']; ?>">
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
                                                        <a href="<?php echo APP_URL; ?>clienteList/" class="btn btn-soft-success">Regresar</a>
                                                    </div>
                                                </form>
                                                <hr class="my-4">
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">
                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                            <img src="<?php echo $cliente_card == "nophoto.jpg"
                                                                            ? "<?php echo APP_URL; ?>app/views/fotos/nophoto.jpg"
                                                                            : "<?php echo APP_URL; ?>app/views/fotos/company/$company_id/clientes/".$cliente_card;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="cliente_card" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>
                                                        <strong>
                                                            <h4 class="fs-16 mb-1">Tarjeta - Card</h4>
                                                        </strong>
                                                        <p class="text-muted mb-0"><?php echo $datos['cliente_card'] . " Item # " . $datos['cliente_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">
                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                            <img src="<?php echo $cliente_card == "nophoto.jpg"
                                                                            ? "<?php echo APP_URL; ?>app/views/fotos/nophoto.jpg"
                                                                            : "<?php echo APP_URL; ?>app/views/fotos/company/$company_id/clientes/".$cliente_banner1;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="cliente_banner1" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>

                                                        <h5 class="fs-16 mb-1">Banner #1</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['cliente_banner1'] . " Item # " . $datos['cliente_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">

                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">

                                                            <img src="<?php echo $cliente_banner2 == "nophoto.jpg"
                                                                            ? "<?php echo APP_URL; ?>app/views/fotos/nophoto.jpg"
                                                                            : "<?php echo APP_URL; ?>app/views/fotos/company/$company_id/clientes/". $cliente_banner2;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="cliente_banner2" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>

                                                        <h5 class="fs-16 mb-1">Banner #2</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['cliente_banner2'] . " Item # " . $datos['cliente_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">
                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                            <img src="<?php echo $cliente_banner3 == "nophoto.jpg"
                                                                            ? "<?php echo APP_URL; ?>app/views/fotos/nophoto.jpg"
                                                                            : "<?php echo APP_URL; ?>app/views/fotos/company/$company_id/clientes/".$cliente_banner3;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="cliente_banner3" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>

                                                        <h5 class="fs-16 mb-1">Banner #3</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['cliente_banner3'] . " Item # " . $datos['cliente_id']; ?></p>
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
                                                                <input id="profile-img-file-input" name="cliente_pdf" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>

                                                        <h5 class="fs-16 mb-1">Archivo PDF</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['cliente_pdf'] . " Item # " . $datos['cliente_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                        </div>
                                    </div>
                                    <!--end tab-pane-->

                                    <div class="tab-pane <?= $tab3 ?>" id="masinformacion" role="tabpanel">
                                        <div class="row">
                                            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/clienteAjax.php" 
                                            method="POST" autocomplete="off">
                                                <input type="hidden" name="modulo_cliente" value="actualizarMasInformacion">
                                                <input type="hidden" name="cliente_id" value="<?= $cliente_id; ?>">
                                                <input type="hidden" name="tab" value="masinformacion">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <div class="mb-">
                                                            <label for="codigo" class="form-label">Código Negocio</label>
                                                            <input name="codigo" type="text" class="form-control" name="codigo" id="cliente_id" value="<?php echo $datos['cliente_id']; ?>" maxlength="40" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="cliente_name" class="form-label">Nombre del Negocio</label>
                                                            <input name="cliente_name" type="text" class="form-control" id="cliente_name" value="<?php echo $datos['cliente_name']; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <?php
                                                    $vector = [1, 2, 3];
                                                    for ($i = 0; $i < 3; $i++) {
                                                    ?>
                                                        <div class="col-lg-2">
                                                            <div class="mb-3">
                                                                <label for="cliente_red" class="form-label">
                                                                    <?php if ($i == 0) {
                                                                        echo "<strong>";
                                                                    } ?>
                                                                    Red Social #
                                                                    <?php if ($i == 0) {
                                                                        echo "</strong>";
                                                                    } ?>
                                                                </label>
                                                                <select name="cliente_red<?= $i + 1 ?>" class="form-control" required data-choices data-choices-text-unique-true id="cliente_red<?= $i + 1; ?>">
                                                                    <option value="facebook" <?php if ($datos['cliente_red' . ($i + 1)] == 'facebook') echo "selected" ?>>facebook</option>
                                                                    <option value="instagram" <?php if ($datos['cliente_red' . ($i + 1)] == 'instagram') echo "selected" ?>>instagram</option>
                                                                    <option value="twitterx" <?php if ($datos['cliente_red' . ($i + 1)] == 'twitterx') echo "selected" ?>>twitterx</option>
                                                                    <option value="tiktok" <?php if ($datos['cliente_red' . ($i + 1)] == 'tiktok') echo "selected" ?>>tiktok</option>
                                                                    <option value="youtube" <?php if ($datos['cliente_red' . ($i + 1)] == 'youtube') echo "selected" ?>>youtube</option>
                                                                    <option value="pinterest" <?php if ($datos['cliente_red' . ($i + 1)] == 'pinterest') echo "selected" ?>>pinterest</option>
                                                                    <option value="linkedin" <?php if ($datos['cliente_red' . ($i + 1)] == 'linkedin') echo "selected" ?>>linkedin</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-2">
                                                            <div class="mb-3">
                                                                <label for="cliente_red_valor<?= $i + 1; ?>" class="form-label">URL Red Social <?= $i + 1; ?></label>
                                                                <input name="cliente_red_valor<?= $i + 1; ?>" type="text" class="form-control" value="<?= $datos["cliente_red_valor" . ($i + 1)] ?>" id="cliente_red_valor<?= $i + 1; ?>" placeholder="Red<?= $i + 1; ?> selección" />
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                    <?php
                                                    }
                                                    ?>
                                                    <hr>
                                                    <div class="col-lg-5">
                                                        <div class="mb-3">
                                                            <label for="cliente_web" class="form-label">Página Web del negocio</label>
                                                            <input name="cliente_web" type="text" class="form-control" value="<?= $datos["cliente_web"] ?>" id="cliente_web" placeholder="Entre Pagina web del negocio" maxlength="240">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="cliente_youtube_index" class="form-label">
                                                                <strong>Video de Youtube</strong></label>
                                                            <input name="cliente_youtube_index" type="text" class="form-control" value="<?= $datos["cliente_youtube_index"] ?>" id="cliente_youtube_index" placeholder="Valor indice del video" />
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="cliente_logo_witdh" class="form-label">Ancho del Logo </label>
                                                            <input name="cliente_logo_witdh" type="number" class="form-control" value="<?= $datos["cliente_logo_witdh"] ?>" id="cliente_logo_witdh" placeholder="Coloque el ancho del logo" maxlength="10" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="cliente_logo_height" class="form-label">Alto del Logo </label>
                                                            <input name="cliente_logo_height" type="number" class="form-control" value="<?= $datos["cliente_logo_height"] ?>" id="cliente_logo_height" placeholder="Coloque el alto del logo" maxlength="10" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <hr>
                                                    <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="submit" class="btn btn-primary">Actualizar Mas Información</button>
                                                            <a href="<?php echo APP_URL; ?>clienteList/" class="btn btn-soft-success">Regresar</a>

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
                                            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/clienteAjax.php" 
                                                method="POST" autocomplete="off">
                                                <input type="hidden" name="modulo_cliente" value="actualizarZonaHoraria">
                                                <input type="hidden" name="cliente_id" value="<?= $cliente_id; ?>">
                                                <input type="hidden" name="tab" value="horario">
                                                <input type="hidden" name="cliente_horario_desde" value="<?= $datos['cliente_horario_desde'] ?>">
                                                <input type="hidden" name="cliente_horario_hasta" value="<?= $datos['cliente_horario_hasta'] ?>">

                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <div class="mb-">
                                                            <label for="codigo" class="form-label">Código Negocio</label>
                                                            <input name="codigo" type="text" class="form-control" name="codigo" id="cliente_id" value="<?php echo $datos['cliente_id']; ?>" maxlength="40" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="cliente_name" class="form-label">Nombre del Negocio</label>
                                                            <input name="cliente_name" type="text" class="form-control" id="cliente_name" value="<?php echo $datos['cliente_name']; ?>" disabled>
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
                                                                $desdehora=explode("|", $datos['cliente_horario_desde']);
                                                                $hastahora=explode("|", $datos['cliente_horario_hasta']);

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
                                                            <a href="<?php echo APP_URL; ?>clienteList/" class="btn btn-soft-success">Regresar</a>
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
                                            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/clienteAjax.php" 
                                                method="POST" autocomplete="off">
                                                <input type="hidden" name="modulo_cliente" value="actualizarUbicacion">
                                                <input type="hidden" name="cliente_id" value="<?= $cliente_id; ?>">
                                                <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                                                <input type="hidden" name="tab" value="ubicacion">
                                                
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <div class="mb-">
                                                            <label for="codigo" class="form-label">Código Negocio</label>
                                                            <input name="codigo" type="text" class="form-control" name="codigo" id="cliente_id" value="<?php echo $datos['cliente_id']; ?>" maxlength="40" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="cliente_name" class="form-label">Nombre del Negocio</label>
                                                            <input name="cliente_name" type="text" class="form-control" id="cliente_name" value="<?php echo $datos['cliente_name']; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <?php 
                                                    require_once "./app/views/inc/ubicacionGeograficaClte.php";
                                                    ?>
                                                    <hr>
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <a href="<?php echo APP_URL; ?>clienteList/" class="btn btn-soft-success">Regresar</a>
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