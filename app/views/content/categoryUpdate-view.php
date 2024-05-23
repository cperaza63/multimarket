<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <?php
            if (!isset($_SESSION["tab"])) {
                $_SESSION["tab"] = "";
            }
            // busco market
            use app\controllers\categoryController;
            $categoryController = new categoryController();
            // por ahora actualizamos datos del administrador
            $categoria_id = $insLogin->limpiarCadena($url[1]);
            $datos = $insLogin->seleccionarDatos("Unico", "company_categorias", "categoria_id", $categoria_id);
            if ($datos->rowCount() == 1) {
                $datos = $datos->fetch();
                $company_id = $datos['company_id'];
                $categoria_id = $datos['categoria_id'];
                $codigo   = $datos['codigo'];
                $nombre   = $datos['nombre'];
                $unidad = $datos['unidad'];
                $accion = "actualizar";
                $boton_accion = "Actualizar";
                $categoria_foto = $datos['categoria_foto'];
                if ($datos['categoria_foto'] == "") {
                    $categoria_foto = "nophoto.jpg";
                }
                $pasa = 1;
            } else {
                // registro es nuevo
                $accion = "registrar";
                $boton_accion = "Agregar";
                $pasa = 0;
            }
            if ($pasa == 1) {
            ?>
                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card mt-n6">
                            <div class="card-body p-1">
                                <div class="text-center">
                                    <form class="FormularioAjax" name="formAjax1" 
                                    action="<?php echo APP_URL; ?>app/ajax/categoryAjax.php" method="POST" 
                                    autocomplete="off" enctype="multipart/form-data">
                                        <!--    Campos parametros     -->
                                        <input type="hidden" name="modulo_category" value="actualizarFoto">
                                        <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
                                        <input type="hidden" name="categoria_id" value="<?php echo $datos['categoria_id']; ?>">
                                        <input type="hidden" name="categoria_tipo" value="categoria_foto">

                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">

                                            <img src="
                                            <?php
                                            echo $categoria_foto == "nophoto.jpg"
                                                ? "http://localhost/multimarket/app/views/fotos/nophoto.jpg"
                                                : "http://localhost/multimarket/app/views/fotos/company/" . $datos['company_id'] . "/categorias/" . $categoria_foto;
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
                                                            <input id="profile-img-file-input" name="categoria_foto" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">

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
                                    <p class="text-muted mb-0"><?php echo $datos['codigo'] . " Item # " . $datos['categoria_id']; ?></p>
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
                                </ul>
                            </div>
                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                        <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/categoryAjax.php" method="POST" autocomplete="off">
                                            <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                                            <input type="hidden" name="modulo_category" value="<?= $accion; ?>">
                                            <input type="hidden" name="categoria_id" value="<?= $categoria_id; ?>">
                                            <input type="hidden" name="codigo" value="<?= $codigo; ?>">

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="codigo" class="form-label">Código</label>
                                                        <input name="codigo" type="text" class="form-control" name="codigo" id="firstnameInput" placeholder="Entre el codigo" value="<?php echo $datos['codigo']; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\-]{3,45}" maxlength="40" required>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="lastnameInput" class="form-label">Nombre</label>
                                                        <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Entre el nombre del item" value="<?php echo $datos['nombre']; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\-]{3,80}" maxlength="40" required>
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

                                                        <a href="<?php echo APP_URL; ?>categoryList/" class="btn btn-soft-success">Cancelar</a>
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