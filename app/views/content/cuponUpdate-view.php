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
            use app\controllers\cuponController;
            $cuponController = new cuponController();
            // por ahora actualizamos datos del administrador
            $cupon_id = $insLogin->limpiarCadena($url[1]);
            $datos = $insLogin->seleccionarDatos("Unico", "company_cupones", "cupon_id", $cupon_id);
            if ($datos->rowCount() == 1) {
                $datos = $datos->fetch();
                $company_id = $datos['company_id'];
                $cupon_inicio = $datos['cupon_inicio'];
                $cupon_final = $datos['cupon_final'];
                $product_id = $datos['cupon_final'];
                $cupon_id = $datos['cupon_id'];
                $cupon_token = $datos['cupon_token'];
                $codigo   = $datos['codigo'];
                $detiene_compra = $datos['detiene_compra'];
                $nombre   = $datos['nombre'];
                $valor_descuento = $datos['valor_descuento'];
                $tipo_oferta = $datos['tipo_oferta'];
                $cantidad_minima = $datos['cantidad_minima'];
                $accion = "actualizar";
                $boton_accion = "Actualizar";
                $cupon_foto = $datos['cupon_foto'];
                if ($datos['cupon_foto'] == "") {
                    $cupon_foto = "nophoto.jpg";
                }
                $pasa = 1;
            } else {
                // registro es nuevo
                $accion = "registrar";
                $boton_accion = "Agregar";
                $pasa = 0;
            }
            use app\controllers\productController;
            $productController = new productController();
            $product_list = $productController->listarTodosProductControlador($company_id, '*');
            if ($pasa == 1) {
            ?>
                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card mt-n6">
                            <div class="card-body p-1">
                                <div class="text-center">
                                    <form class="FormularioAjax" name="formAjax1" 
                                    action="<?php echo APP_URL; ?>app/ajax/cuponAjax.php" method="POST" 
                                    autocomplete="off" enctype="multipart/form-data">
                                        <!--    Campos parametros     -->
                                        <input type="hidden" name="modulo_cupon" value="actualizarFoto">
                                        <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
                                        <input type="hidden" name="cupon_id" value="<?php echo $datos['cupon_id']; ?>">
                                        <input type="hidden" name="cupon_tipo" value="cupon_foto">

                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">

                                            <img src="
                                            <?php
                                            echo $cupon_foto == "nophoto.jpg"
                                                ? APP_URL."app/views/fotos/nophoto.jpg"
                                                : APP_URL."app/views/fotos/company/" . $datos['company_id'] . "/cupones/" . $cupon_foto;
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
                                                            <input id="profile-img-file-input" name="cupon_foto" type="file" accept=".jpg, .png, .jpeg" class="profile-img-file-input">

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
                                    <h5 class="fs-16 mb-1"><?php echo "CUPONES<br>" . strtoupper($datos['nombre']) 
                                    . " Item # " . $datos['cupon_id']; ?> </h5>
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
                                        <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/cuponAjax.php" method="POST" autocomplete="off">
                                            <input type="hidden" name="company_id" value="<?= $company_id; ?>">
                                            <input type="hidden" name="modulo_cupon" value="<?= $accion; ?>">
                                            <input type="hidden" name="cupon_id" value="<?= $cupon_id; ?>">
                                            <input type="hidden" name="codigo" value="<?= $codigo; ?>">

                                            <div class="row">
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="codigo" class="form-label">Código <strong>
                                                    <?php echo CAMPO_OBLIGATORIO; ?></strong></label>
                                                    <input name="codigo" type="text" class="form-control" 
                                                    id="codigo" placeholder="Entre su codigo" 
                                                    value="<?=$codigo?>"
                                                    pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{3,40}" 
                                                    maxlength="40" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label">Nombre corto del cupón <strong>
                                                    <?php echo CAMPO_OBLIGATORIO; ?></strong></label>
                                                    <input name="nombre" type="text" class="form-control" id="nombre" value="<?=$nombre?>"
                                                    placeholder="Entre el nombre"
                                                    pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{5,80}" 
                                                    maxlength="80" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="estado" class="form-label">Estado <?php echo CAMPO_OBLIGATORIO; ?></label>
                                                    <select name="estado" class="form-control" data-choices data-choices-text-unique-true id="estado">
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="product_id" class="form-label">Seleccione Producto <?php echo CAMPO_OBLIGATORIO; ?></label>
                                                    <select name="product_id" class="form-control" data-choices data-choices-text-unique-true id="product_id">
                                                        <option value="">Seleccione producto</option>
                                                        <?php
                                                        if (is_array($product_list)) {
                                                            //print_r($product_list);
                                                            foreach ($product_list as $producto) {
                                                                if ($producto['product_estatus'] == 1){
                                                                    ?>
                                                                        <option value="<?= $producto['product_id']; ?>"><?= $producto['product_name']; ?>
                                                                        </option>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="cupon_inicio" class="form-label">Fecha inicio de oferta <?php echo CAMPO_OBLIGATORIO; ?></label>
                                                    <input name="cupon_inicio" type="date" value="<?=$cupon_inicio?>" class="form-control"  id="cupon_inicio" placeholder="Fecha de inicio de la oferta" required 
                                                    />
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="cupon_final" class="form-label">Fecha final de la oferta <?php echo CAMPO_OBLIGATORIO; ?></label>
                                                    <input name="cupon_final" type="date" required value="<?=$cupon_final?>"
                                                    class="form-control"  id="cupon_final"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="tipo_oferta" class="form-label">Tipo_oferta <?php echo CAMPO_OBLIGATORIO; ?></label>
                                                    <select name="tipo_oferta" class="form-control" data-choices data-choices-text-unique-true id="tipo_oferta">
                                                        <option value="P"
                                                        <?php if ( $tipo_oferta == "P" )echo "selected";?>
                                                        >Aplica porcentaje %</option>
                                                        <option value="M"
                                                        <?php if ( $tipo_oferta == "M" )echo "selected";?>
                                                        >Aplica un monto $</option>
                                                    </select>
                                                </div>
                                            </div>
                                                <!--end col-->
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="valor_descuento" class="form-label">Valor descuento <strong>
                                                    <?php echo CAMPO_OBLIGATORIO; ?></strong></label>
                                                    <input name="valor_descuento" type="number" step="0.01" class="form-control" id="valor_descuento" placeholder="Entre el valor de descuento" value="<?=$valor_descuento?>"
                                                    maxlength="40" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="valor_descuento" class="form-label">Cantidad mínima <strong>
                                                    <?php echo CAMPO_OBLIGATORIO; ?></strong></label>
                                                    <input name="cantidad_minima" type="number" class="form-control" id="cantidad_minima" placeholder="Entre la cantidad_mínima" value="<?=$cantidad_minima?>"
                                                    maxlength="40" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="cupon_token" class="form-label">Número Cupón <strong>
                                                    <?php echo CAMPO_OBLIGATORIO; ?></strong></label>
                                                    <input name="cupon_token" type="text" class="form-control" id="cantidad_minima" placeholder="Codigo que usuario usara para comprar" 
                                                    maxlength="40" required value="<?=$cupon_token;?>">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="detiene_compra" class="form-label">Detiene N compras <strong>
                                                    <?php echo CAMPO_OBLIGATORIO; ?></strong></label>
                                                    <input name="detiene_compra" type="number" class="form-control" id="detiene_compra" 
                                                    placeholder="Este cupon dejará de funcionar a las N ventas acumuladas" 
                                                    maxlength="40" required value="<?=$detiene_compra?>">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Actualizar Valores</button>
                                                    <a href="<?php echo APP_URL; ?>cuponList/" class="btn btn-soft-success">Cancelar</a>
                                                    
                                                </div>
                                                <p class="has-text-centered pt-6">
                                                    <small>Los campos cupondos con <strong><?php echo CAMPO_OBLIGATORIO; ?></strong> son obligatorios</small>
                                                </p>
                                                <br><br><br><br><br><br><br><br><br><br>
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