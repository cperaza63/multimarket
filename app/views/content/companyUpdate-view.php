
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
            // busco market
            use app\controllers\companyController;
            $companyController = new companyController();
            //print_r($mercados);
            // por ahora actualizamos datos del administrador
            $company_id = $insLogin->limpiarCadena($url[1]);
            $datos = $insLogin->seleccionarDatos("Unico", "company", "company_id", $company_id);
            if ($datos->rowCount() == 1) {

                $datos = $datos->fetch();
                $company_id = $datos['company_id'];
                $company_name   = $datos['company_name'];
                $accion = "actualizar";
                $boton_accion = "Actualizar";
                $company_logo = $datos['company_logo'];
                if ($datos['company_logo'] == "") {
                    $company_logo = "nophoto.jpg";
                }
                $company_card = $datos['company_card'];
                if ($datos['company_card'] == "") {
                    $company_card = "nophoto.jpg";
                }
                $company_banner1 = $datos['company_banner1'];
                if ($datos['company_banner1'] == "") {
                    $company_banner1 = "nophoto.jpg";
                }
                $company_banner2 = $datos['company_banner2'];
                if ($datos['company_banner2'] == "") {
                    $company_banner2 = "nophoto.jpg";
                }
                $company_banner3 = $datos['company_banner3'];
                if ($datos['company_banner3'] == "") {
                    $company_banner3 = "nophoto.jpg";
                }
                $company_pdf = $datos['company_pdf'];
                if ($datos['company_pdf'] == "") {
                    $company_pdf = "nophoto.jpg";
                }
                $country_company = $datos['company_country'];
                $state_company = $datos['company_state'];
                $city_company = $datos['company_city'];
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
            if (isset($_POST['company_country'])) {
                $estados = $ubicacionController->obtenerEstadosControlador($_POST['company_country']);
            } else {
                if ($country_company > 0) {
                    $estados = $ubicacionController->obtenerEstadosControlador($country_company);
                } else {
                    $estados = $ubicacionController->obtenerEstadosControlador(APP_COUNTRY);
                }
            }
            // Parametros para el ajax de Ciudad
            if (isset($_POST['company_state'])) {
                $q = $_POST['company_state'];
                $c = $_POST['company_city'];
            } else {
                $q = $state_company;
                $c = $city_company;
            }

            //print_r($company_logo);
            //exit();
            if ($pasa == 1) {
            ?>
                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card mt-n6">
                            <div class="card-body p-1">
                                <div class="text-center">
                                    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/companyAjax.php" 
                                        method="POST" autocomplete="off" enctype="multipart/form-data">
                                        <!--    Campos parametros     -->
                                        <input type="hidden" name="modulo_company" value="actualizarFoto">
                                        <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
                                        <input type="hidden" name="company_tipo" value="company_logo">

                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">

                                            <img src="
                                            <?php
                                            echo $company_logo == "nophoto.jpg"
                                                ? "http://localhost/multimarket/app/views/fotos/nophoto.jpg"
                                                : "http://localhost/multimarket/app/views/fotos/company/$company_id/" . $company_logo;
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
                                                            <input id="profile-img-file-input" name="company_logo" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">

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
                                    <h5 class="fs-16 mb-1"><?php echo "ACTUALIZANDO NEGOCIO " . $datos['company_name']; ?></h5>
                                    <p class="text-muted mb-0"><?php echo "Item # " . $datos['company_id']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <?php 
                    $tab1="";$tab2="";$tab3="";$tab4="";$tab5="";$tab6="";
                    if($_SESSION["tab"]=="personaldetails") {
                        $tab1 = "active";
                        ?><script>location.href="#personaldetails";</script><?php
                    }else if($_SESSION["tab"]=="multimedia"){
                        $tab2 = "active";
                        ?><script>location.href="#multimedia";</script><?php
                    }else if($_SESSION["tab"]=="masinformacion"){
                        $tab = "active";
                    }else if($_SESSION["tab"]=="preferencias"){
                        $tab4 = "active";
                    }else if($_SESSION["tab"]=="ubicacion"){
                        $tab5 = "active";
                    }else if($_SESSION["tab"]=="contratos"){
                        $tab6 = "active";
                    }else{
                        $tab1 = "active";
                        ?><script>location.href="#personaldetails";</script><?php
                    }
                    ?>
                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul id="myTab" class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                    |<li class="nav-item">
                                        <a class="nav-link <?=$tab1;?>" id="tab-header-1" data-bs-toggle="tab" href="#personaldetails" role="tab">
                                            <i class="fas fa-home"></i> Información
                                        </a>
                                    </li>

                                    <li li class="nav-item">
                                        <a class="nav-link <?=$tab2?>" id="tab-header-2" data-bs-toggle="tab" href="#multimedia" role="tab">
                                            <i class="far fa-user"></i> Multimedia
                                        </a>
                                    </li>

                                    <li li class="nav-item">
                                        <a class="nav-link <?=$tab3?>" id="tab-header-3" data-bs-toggle="tab" href="#masinformacion" role="tab">
                                            <i class="far fa-user"></i> Más información
                                        </a>
                                    </li>

                                    <li li class="nav-item">
                                        <a class="nav-link <?=$tab4?>" id="tab-header-4" data-bs-toggle="tab" href="#preferencias" role="tab">
                                            <i class="far fa-user"></i> Preferencias
                                        </a>
                                    </li>

                                    <li li class="nav-item">
                                        <a class="nav-link <?=$tab5?>" id="tab-header-5" data-bs-toggle="tab" href="#ubicacion" role="tab">
                                            <i class="far fa-user"></i> Ubicación
                                        </a>
                                    </li>

                                    <li li class="nav-item">
                                        <a class="nav-link <?=$tab6?>" id="tab-header-6" data-bs-toggle="tab" href="#contratos" role="tab">
                                            <i class="far fa-user"></i> Contratos
                                        </a>
                                    </li>


                                </ul>
                            </div>
                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane <?=$tab1?>" id="personaldetails" role="tabpanel">
                                        <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/companyAjax.php" 
                                        method="POST" autocomplete="off">
                                            <input type="hidden" name="modulo_company" value="<?= $accion; ?>">
                                            <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                                            <input type="hidden" name="tab" value="personaldetails">
                                            <input type="hidden" name="company_user" value="<?= $_SESSION['id'] ?>">

                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <div class="mb-3">
                                                        <label for="codigo" class="form-label">Código</label>
                                                        <input name="codigo" type="text" class="form-control" name="codigo" id="company_id" value="<?php echo $datos['company_id']; ?>" maxlength="40" disabled>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="company_name" class="form-label">Nombre de Negocio</label>
                                                        <input name="company_name" type="text" class="form-control" id="company_name" placeholder="Entre el nombre del negocio" value="<?php echo $datos['company_name']; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\-]{3,80}" maxlength="40" required>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="company_type" class="form-label">Tipo de Negocio</label>
                                                        <select name="company_type" class="form-control" required data-choices data-choices-text-unique-true id="tipo">
                                                            <option value="E" <?php if ($datos['company_type'] == 'E') echo "selected" ?>>Tienda de un Negocio</option>
                                                            <option value="U" <?php if ($datos['company_type'] == 'U') echo "selected" ?>>Mini Tienda de un Usuario</option>
                                                            <option value="C" <?php if ($datos['company_type'] == 'C') echo "selected" ?>>Corporación (Múltiples tiendas)</option>
                                                            <option value="D" <?php if ($datos['company_type'] == 'D') echo "selected" ?>>Servicio de Delivery a tiendas</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <?php
                                                ?>
                                                <div class="col-lg-6">
                                                    <div class="mb-3 pb-2">
                                                        <label for="company_description" class="form-label">Breve descripción</label>
                                                        <textarea name="company_description" class="form-control" id="company_description" placeholder="Breve descripción del negocio" rows="3"><?= trim($datos["company_description"]); ?></textarea>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3 pb-2">
                                                        <label for="location" class="form-label">Dirección</label>
                                                        <textarea name="company_address" class="form-control" id="company_address" placeholder="Dirección del negocio" rows="3"><?= $datos["company_address"] ?></textarea>
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
                                                                <select name="company_country" class="form-control" data-choices data-choices-text-unique-true id="country">
                                                                    <option value="<?= $pais['country']; ?>" <?php if ($pais['country'] == $datos["company_country"]) echo "selected"; ?>><?= $pais['country']; ?>
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
                                                        <label for="company_state" class="form-label">Estado/Provincia</label>
                                                        <select name="company_state" language="javascript:void(0)" onchange="loadAjaxCiudadHive(this.value, <?= $city_company ?>)" class="form-control" data-choices data-choices-text-unique-true id="state">
                                                            <?php
                                                            if (is_array($estados)) {
                                                                foreach ($estados as $estado) {
                                                            ?>
                                                                    <option value="<?= $estado['state_abbreviation']; ?>" <?php if ($estado['state_abbreviation'] == $datos["company_state"]) echo "selected"; ?>><?= $estado['state_name']; ?>
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
                                                        <label for="company_city" class="form-label">Ciudades</label>
                                                        <select name="company_city" class="form-control" data-choices data-choices-text-unique-true id="city">
                                                            <?php
                                                            if ($res = $mysqli->query("SELECT * FROM ubicacion WHERE state_abbreviation<>'' AND 
                                                                state_abbreviation='$q' ORDER BY city")) {
                                                            ?>
                                                                <?php while ($fila = mysqli_fetch_array($res)) { ?>
                                                                    <option value="<?php echo $fila['id']; ?>" <?php if ($fila['id'] == $datos["company_city"]) echo "selected"; ?>>
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
                                                        <label for="company_email" class="form-label">Email del negocio</label>
                                                        <input name="company_email" type="email" class="form-control" value="<?= $datos["company_email"] ?>" id="company_email" placeholder="Email de la empresa" required />
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label for="company_phone" class="form-label">Teléfono contacto</label>
                                                        <input name="company_phone" type="number" class="form-control" value="<?= $datos["company_phone"] ?>" id="codigo" placeholder="Entre su numero de contacto" maxlength="80" required>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label for="company_rif" class="form-label">Número de Rif</label>
                                                        <input name="company_rif" type="text" class="form-control" value="<?= $datos["company_rif"] ?>" id="codigo" placeholder="Entre su numero de rif, ejemplo: J12304567890" maxlength="20" required>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-2">
                                                    <div class="mb-3">
                                                        <label for="company_estatus" class="form-label">Estatus Actual</label>
                                                        <select name="company_estatus" class="form-control" required data-choices data-choices-text-unique-true id="tipo">
                                                            <option value="1" <?php if ($datos["company_estatus"] == 1) echo "selected"; ?>>Activo</option>
                                                            <option value="0" <?php if ($datos["company_estatus"] == 0) echo "selected"; ?>>Inactivo</option>
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
                                                        <button type="submit" class="btn btn-primary">Actualizar el Negocio</button>
                                                        <a href="<?php echo APP_URL; ?>companyList/" class="btn btn-soft-success">Cancelar</a>

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
                                    <div class="tab-pane <?=$tab2?>" id="multimedia" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <form class="FormularioAjax" name="<?php echo $company_tipo; ?>" action="<?php echo APP_URL; ?>app/ajax/companyAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                                                    <input type="hidden" name="modulo_company" value="actualizarFotoMasa">
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
                                                    </div>
                                                </form>
                                                <hr class="my-4">
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">
                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                            <img src="<?php echo $company_card == "nophoto.jpg"
                                                                            ? "http://localhost/multimarket/app/views/fotos/nophoto.jpg"
                                                                            : "http://localhost/multimarket/app/views/fotos/company/" . $datos['company_id'] . "/" . $company_card;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="company_card" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>
                                                        <strong>
                                                            <h4 class="fs-16 mb-1">Tarjeta - Card</h4>
                                                        </strong>
                                                        <p class="text-muted mb-0"><?php echo $datos['company_card'] . " Item # " . $datos['company_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">
                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                            <img src="<?php echo $company_card == "nophoto.jpg"
                                                                            ? "http://localhost/multimarket/app/views/fotos/nophoto.jpg"
                                                                            : "http://localhost/multimarket/app/views/fotos/company/" . $datos['company_id'] . "/" . $company_banner1;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="company_banner1" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>

                                                        <h5 class="fs-16 mb-1">Banner #1</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['company_banner1'] . " Item # " . $datos['company_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">

                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">

                                                            <img src="<?php echo $company_banner2 == "nophoto.jpg"
                                                                            ? "http://localhost/multimarket/app/views/fotos/nophoto.jpg"
                                                                            : "http://localhost/multimarket/app/views/fotos/company/" . $datos['company_id'] . "/" . $company_banner2;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="company_banner2" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>

                                                        <h5 class="fs-16 mb-1">Banner #2</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['company_banner2'] . " Item # " . $datos['company_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">

                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                            <img src="<?php echo $company_banner3 == "nophoto.jpg"
                                                                            ? "http://localhost/multimarket/app/views/fotos/nophoto.jpg"
                                                                            : "http://localhost/multimarket/app/views/fotos/company/" . $datos['company_id'] . "/" . $company_banner3;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="company_banner3" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>

                                                        <h5 class="fs-16 mb-1">Banner #3</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['company_banner3'] . " Item # " . $datos['company_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">

                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                            <img src="http://localhost/multimarket/app/views/fotos/pdf.jpg" 
                                                            class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="company_pdf" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>

                                                        <h5 class="fs-16 mb-1">Archivo PDF</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['company_pdf'] . " Item # " . $datos['company_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                        </div>
                                    </div>
                                    <!--end tab-pane-->

                                    <div class="tab-pane  <?=$tab3?>" id="masinformacion" role="tabpanel">
                                        <div class="row">
                                            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/companyAjax.php" 
                                            method="POST" autocomplete="off">
                                            <input type="hidden" name="modulo_company" value="actualizarMasInformacion">
                                            <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                                            <input type="hidden" name="company_user" value="<?= $_SESSION['id'] ?>">
                                            <input type="hidden" name="tab" value="masinformacion">

                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <div class="mb-">
                                                            <label for="codigo" class="form-label">Código Negocio</label>
                                                            <input name="codigo" type="text" class="form-control" name="codigo" 
                                                            id="company_id" value="<?php echo $datos['company_id']; ?>" maxlength="40" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="company_name" class="form-label">Nombre del Negocio</label>
                                                            <input name="company_name" type="text" class="form-control" 
                                                            id="company_name" value="<?php echo $datos['company_name']; ?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="company_type" class="form-label">Tipo de Negocio</label>
                                                            <select name="company_type" class="form-control" disabled data-choices data-choices-text-unique-true id="tipo">
                                                                <option value="E" <?php if ($datos['company_type'] == 'E') echo "selected" ?>>Tienda de un Negocio</option>
                                                                <option value="U" <?php if ($datos['company_type'] == 'U') echo "selected" ?>>Mini Tienda de un Usuario</option>
                                                                <option value="C" <?php if ($datos['company_type'] == 'C') echo "selected" ?>>Corporación (Múltiples tiendas)</option>
                                                                <option value="D" <?php if ($datos['company_type'] == 'D') echo "selected" ?>>Servicio de Delivery a tiendas</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <hr>
                                                    <?php
                                                    $vector=[1,2,3];
                                                    for ($i=0; $i < 3 ; $i++) { 
                                                    ?>
                                                        <div class="col-lg-2">
                                                            <div class="mb-3">
                                                                <label for="company_red" class="form-label">
                                                                    <?php if($i==0){ echo"<strong>";}?>
                                                                    Red Social #
                                                                    <?php if($i==0){ echo"</strong>";}?>
                                                                </label>
                                                                <select name="company_red<?=$i?>" class="form-control" required data-choices data-choices-text-unique-true 
                                                                    id="company_red<?=$i+1;?>">
                                                                    <option value="">Seleccione Red</option>
                                                                    <option value="facebook" <?php if ($datos['company_type'] == 'facebook') echo "selected" ?>>facebook</option>
                                                                    <option value="instagram" <?php if ($datos['company_type'] == 'instagram') echo "selected" ?>>instagram</option>
                                                                    <option value="twitterx" <?php if ($datos['company_type'] == 'twitterx') echo "selected" ?>>twitterx</option>
                                                                    <option value="tiktok" <?php if ($datos['company_type'] == 'tiktok') echo "selected" ?>>tiktok</option>
                                                                    <option value="youtube" <?php if ($datos['company_type'] == 'youtube') echo "selected" ?>>youtube</option>
                                                                    <option value="pinterest" <?php if ($datos['company_type'] == 'pinterest') echo "selected" ?>>pinterest</option>
                                                                    <option value="linkedin" <?php if ($datos['company_type'] == 'linkedin') echo "selected" ?>>linkedin</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-2">
                                                            <div class="mb-3">
                                                                <label for="company_red_valor<?=$i+1;?>" class="form-label">URL Red Social <?=$i+1;?></label>
                                                                <input name="company_red_valor<?=$i+1;?>" type="text" class="form-control" 
                                                                value="<?= $datos["company_red_valor".($i+1)] ?>" id="company_red_valor<?=$i+1;?>" 
                                                                placeholder="Red<?=$i+1;?> selección" required />
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                    <?php
                                                    }
                                                    ?>
                                                    <hr>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="company_slogan" class="form-label">
                                                            <strong>Slogan del Negocio</strong></label>
                                                            <input name="company_slogan" type="text" value="<?= $datos["company_slogan"] ?>"
                                                            class="form-control" id="company_web" 
                                                            placeholder="Cuál es el slogan de su empresa" de iva" maxlength="240" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="company_web" class="form-label">Página Web del negocio</label>
                                                            <input name="company_web" type="url" class="form-control" 
                                                            value="<?= $datos["company_web"] ?>" id="company_web" 
                                                            placeholder="Entre Pagina web del negocio" maxlength="240" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <hr>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="company_servicio_email" class="form-label">
                                                            <strong>Servicio de Email</strong></label>
                                                            <input name="company_servicio_email" type="text" 
                                                            value="<?= $datos["company_servicio_email"] ?>"
                                                            class="form-control" id="company_servicio_email" 
                                                            placeholder="Porcentaje de iva" maxlength="100" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="company_servicio_email_envio" class="form-label">Email de Envío</label>
                                                            <input name="company_servicio_email_envio" type="email" 
                                                            value="<?= $datos["company_servicio_email_envio"] ?>"
                                                            class="form-control" id="company_servicio_email_envio" 
                                                            placeholder="Email de envio" maxlength="240" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="company_servicio_email_password" 
                                                            class="form-label">Password del Email</label>
                                                            <input name="company_servicio_email_password" type="text" 
                                                            value="<?= $datos["company_servicio_email_password"] ?>"
                                                            class="form-control" id="company_servicio_email_password" 
                                                            placeholder="Password del Email" maxlength="20" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <div class="col-lg-2">
                                                        <div class="mb-3">
                                                            <label for="company_servicio_email_puerto" 
                                                            class="form-label">Puerto de envío</label>
                                                            <input name="company_servicio_email_puerto" type="text" 
                                                            value="<?= $datos["company_servicio_email_puerto"] ?>"
                                                            class="form-control" id="company_servicio_email_puerto" 
                                                            placeholder="Puerto de salida del email" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <hr>

                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="company_youtube_index" class="form-label">
                                                                <strong>Video de Youtube</strong></label>
                                                            <input name="company_youtube_index" type="text" class="form-control" 
                                                            value="<?= $datos["company_youtube_index"] ?>" 
                                                            id="company_youtube_index" placeholder="Valor indice del video" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="company_logo_witdh" class="form-label">Ancho del Logo </label>
                                                            <input name="company_logo_witdh" type="number" class="form-control" 
                                                            value="<?= $datos["company_logo_witdh"] ?>" id="company_logo_witdh" 
                                                            placeholder="Coloque el ancho del logo" maxlength="10" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="company_logo_height" class="form-label">Alto del Logo </label>
                                                            <input name="company_logo_height" type="number" class="form-control" 
                                                            value="<?= $datos["company_logo_height"] ?>" id="comopany_logo_height" 
                                                            placeholder="Coloque el alto del logo" maxlength="10" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <hr>
                                                    <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="submit" class="btn btn-primary">Actualizar Mas Información</button>
                                                            <a href="<?php echo APP_URL; ?>companyList/" class="btn btn-soft-success">Regresar</a>

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