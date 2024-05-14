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
                                    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/companyAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                                        <!--    Campos parametros     -->
                                        <input type="hidden" name="modulo_company" value="actualizarFoto">
                                        <input type="hidden" name="company_id" value="<?php echo $datos['company_id']; ?>">
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
                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul id="myTab" class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                    |<li class="nav-item">
                                        <a class="nav-link active" id="tab-header-1" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                            <i class="fas fa-home"></i> Información
                                        </a>
                                    </li>

                                    <li li class="nav-item">
                                        <a class="nav-link" id="tab-header-2" data-bs-toggle="tab" href="#multimedia" role="tab">
                                            <i class="far fa-user"></i> Multimedia
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                        <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/companyAjax.php" 
                                        method="POST" autocomplete="off">
                                            <input type="hidden" name="modulo_company" value="<?= $accion; ?>">
                                            <input type="hidden" name="company_id" value="<?= $company_id; ?>">

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
                                                        <label for="lastnameInput" class="form-label">Nombre de Negocio</label>
                                                        <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Entre el nombre del item" value="<?php echo $datos['company_name']; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\-]{3,80}" maxlength="40" required>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="tipo" class="form-label">Tipo de Negocio</label>
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
                                    <div class="tab-pane" id="multimedia" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <form class="FormularioAjax" name="<?php echo $company_tipo; ?>" 
                                                action="<?php echo APP_URL; ?>app/ajax/companyAjax.php" method="POST" 
                                                autocomplete="off" enctype="multipart/form-data">
                                                <input type="hidden" name="modulo_company" value="actualizarFotoMasa">
                                                <input type="hidden" name="company_id" value="<?php echo $datos['company_id']; ?>">
                                                    
                                                    <div class="card-body p-4">
                                                        <label for="card">Card
                                                            <input class="form-control" type="file" name="archivo[0]"></label>
                                                        <label for="card">Banner1
                                                            <input class="form-control" type="file" name="archivo[1]"></label>
                                                        <label for="card">Banner2
                                                            <input class="form-control" type="file" name="archivo[2]"></label>
                                                        <label for="card">Banner3
                                                            <input class="form-control" type="file" name="archivo[3]"></label>
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
                                                                            : "http://localhost/multimarket/app/views/fotos/company/" . $datos['company_id']."/".$company_card;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="control_foto" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>
                                                        <strong>
                                                            <h4 class="fs-16 mb-1">Tarjeta - Card</h4>
                                                        </strong>
                                                        <p class="text-muted mb-0"><?php echo $datos['company_id'] . " Item # " . $datos['company_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">
                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">

                                                            <img src="<?= $company_banner1 == "nophoto.jpg"
                                                                            ? "http://localhost/multimarket/app/views/fotos/nophoto.jpg"
                                                                            : "http://localhost/multimarket/app/views/fotos/company/". $datos['company_id']."/" . $company_banner1;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="control_foto" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>

                                                        <h5 class="fs-16 mb-1">Banner #1</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['company_id'] . " Item # " . $datos['company_id']; ?></p>
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
                                                                            : "http://localhost/multimarket/app/views/fotos/company/" . $datos['company_id'] ."/". $company_banner2;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="control_foto" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>

                                                        <h5 class="fs-16 mb-1">Banner #2</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['company_id'] . " Item # " . $datos['company_id']; ?></p>
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
                                                                <input id="profile-img-file-input" name="control_foto" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>

                                                        <h5 class="fs-16 mb-1">Banner #3</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['company_id'] . " Item # " . $datos['company_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
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