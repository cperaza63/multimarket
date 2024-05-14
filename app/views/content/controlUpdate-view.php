<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <?php
            // busco market
            use app\controllers\controlController;

            $controlController = new controlController();
            $mercados = $controlController->listarSoloTipoControlador('market');
            //print_r($mercados);
            // por ahora actualizamos datos del administrador
            $control_id = $insLogin->limpiarCadena($url[1]);
            $datos = $insLogin->seleccionarDatos("Unico", "control", "control_id", $control_id);
            if ($datos->rowCount() == 1) {
                $datos = $datos->fetch();
                $control_id = $datos['control_id'];
                $codigo   = $datos['codigo'];
                $nombre   = $datos['nombre'];
                $accion = "actualizar";
                $boton_accion = "Actualizar";
                $control_foto = $datos['control_foto'];
                if ($datos['control_foto'] == "") {
                    $control_foto = "nophoto.jpg";
                }
                $control_card = $datos['control_card'];
                if ($datos['control_card'] == "") {
                    $control_card = "nophoto.jpg";
                }
                $control_banner1 = $datos['control_banner1'];
                if ($datos['control_banner1'] == "") {
                    $control_banner1 = "nophoto.jpg";
                }
                $control_banner2 = $datos['control_banner2'];
                if ($datos['control_banner2'] == "") {
                    $control_banner2 = "nophoto.jpg";
                }
                $control_banner3 = $datos['control_banner3'];
                if ($datos['control_banner3'] == "") {
                    $control_banner3 = "nophoto.jpg";
                }
                $pasa = 1;
            } else {
                // registro es nuevo
                $accion = "registrar";
                $boton_accion = "Agregar";
                $pasa = 0;
            }
            //print_r($control_foto);
            //exit();
            if ($pasa == 1) {
            ?>
                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card mt-n6">
                            <div class="card-body p-1">
                                <div class="text-center">
                                    <form class="FormularioAjax" name="<?php echo $control_tipo; ?>" action="<?php echo APP_URL; ?>app/ajax/controlAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                                        <!--    Campos parametros     -->
                                        <input type="hidden" name="modulo_control" value="actualizarFoto">
                                        <input type="hidden" name="control_id" value="<?php echo $datos['control_id']; ?>">
                                        <input type="hidden" name="control_tipo" value="control_foto">

                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">

                                            <img src="
                                            <?php
                                            echo $control_foto == "nophoto.jpg"
                                                ? "http://localhost/multimarket/app/views/fotos/nophoto.jpg"
                                                : "http://localhost/multimarket/app/views/fotos/control/" . $control_foto;
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
                                                            <input id="profile-img-file-input" name="control_foto" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">

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
                                    <h5 class="fs-16 mb-1"><?php echo "ACTUALIZANDO ITEM " . $datos['nombre']; ?></h5>
                                    <p class="text-muted mb-0"><?php echo $datos['codigo'] . " Item # " . $datos['control_id']; ?></p>
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
                                        <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/controlAjax.php" method="POST" autocomplete="off">

                                            <input type="hidden" name="modulo_control" value="<?= $accion; ?>">
                                            <input type="hidden" name="control_id" value="<?= $control_id; ?>">
                                            <input type="hidden" name="codigo" value="<?= $codigo; ?>">

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="codigo" class="form-label">Código</label>
                                                        <input name="codigo" type="text" class="form-control" name="codigo" id="firstnameInput" placeholder="Entre el codigo" value="<?php echo $datos['codigo']; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\-]{3,45}" maxlength="40" required>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="lastnameInput" class="form-label">Nombre</label>
                                                        <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Entre el nombre del item" value="<?php echo $datos['nombre']; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\-]{3,80}" maxlength="40" required>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="tipo" class="form-label">Tipo de Tabla</label>
                                                        <select name="tipo" class="form-control" data-choices data-choices-text-unique-true id="tipo">
                                                            <option value="market" <?php if ($datos['tipo'] == 'market') echo "selected" ?>>Market Place</option>
                                                            <option value="market" <?php if ($datos['tipo'] == 'market_cat') echo "selected" ?>>Categoría de Market Place</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--end col-->

                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="unidad" class="form-label">Categoria del tipo de tabla</label>
                                                        <select name="unidad" class="form-control" data-choices data-choices-text-unique-true id="tipo">
                                                            <?php
                                                            if (is_array($mercados)) {
                                                                foreach ($mercados as $mercado) { ?>
                                                                    <option value="<?= $mercado['control_id'] ?>"><?= ucfirst($mercado['nombre']) ?></option>
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
                                                        <label for="estatus" class="form-label">Estado</label>
                                                        <select name="estatus" class="form-control" data-choices data-choices-text-unique-true id="estatus">
                                                            <option value="1" <?php if ($datos['estatus'] == '1') echo "selected" ?>>Activo</option>
                                                            <option value="0" <?php if ($datos['estatus'] == '0') echo "selected" ?>>Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-primary">Actualizar</button>

                                                        <a href="<?php echo APP_URL; ?>controlList/" class="btn btn-soft-success">Cancelar</a>
                                                    </div>
                                                    <p class="has-text-centered pt-6">
                                                        <small>Los campos marcados con <strong><?php echo CAMPO_OBLIGATORIO; ?></strong> son obligatorios</small>
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
                                                <form class="FormularioAjax" name="<?php echo $control_tipo; ?>" action="<?php echo APP_URL; ?>app/ajax/controlAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                                                    <!--    Campos parametros     -->
                                                    <input type="hidden" name="modulo_control" value="actualizarFotoMasa">
                                                    <input type="hidden" name="control_id" value="<?php echo $datos['control_id']; ?>">

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

                                                    <hr class="my-4">
                                                </form>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">
                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                            <img src="<?php echo $control_card == "nophoto.jpg"
                                                                            ? "http://localhost/multimarket/app/views/fotos/nophoto.jpg"
                                                                            : "http://localhost/multimarket/app/views/fotos/control/" . $control_card;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="control_foto" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>
                                                        <strong>
                                                            <h4 class="fs-16 mb-1">Tarjeta - Card</h4>
                                                        </strong>
                                                        <p class="text-muted mb-0"><?php echo $datos['codigo'] . " Item # " . $datos['control_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">
                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                            <img src="<?= $control_banner1 == "nophoto.jpg"
                                                                            ? "http://localhost/multimarket/app/views/fotos/nophoto.jpg"
                                                                            : "http://localhost/multimarket/app/views/fotos/control/" . $control_banner1;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="control_foto" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>
                                                        <h5 class="fs-16 mb-1">Banner #1</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['codigo'] . " Item # " . $datos['control_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">
                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                            <img src="<?php echo $control_banner2 == "nophoto.jpg"
                                                                            ? "http://localhost/multimarket/app/views/fotos/nophoto.jpg"
                                                                            : "http://localhost/multimarket/app/views/fotos/control/" . $control_banner2;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="control_foto" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>
                                                        <h5 class="fs-16 mb-1">Banner #2</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['codigo'] . " Item # " . $datos['control_id']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end tab-pane-->
                                            <div class="col-lg-3">
                                                <div class="card-body p-1">
                                                    <div class="text-center">
                                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                            <img src="<?php echo $control_banner3 == "nophoto.jpg"
                                                                            ? "http://localhost/multimarket/app/views/fotos/nophoto.jpg"
                                                                            : "http://localhost/multimarket/app/views/fotos/control/" . $control_banner3;
                                                                        ?>" class="rounded avatar-xl img-thumbnail user-profile-image  shadow" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle ">
                                                                <input id="profile-img-file-input" name="control_foto" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            </div>
                                                        </div>
                                                        <h5 class="fs-16 mb-1">Banner #3</h5>
                                                        <p class="text-muted mb-0"><?php echo $datos['codigo'] . " Item # " . $datos['control_id']; ?></p>
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