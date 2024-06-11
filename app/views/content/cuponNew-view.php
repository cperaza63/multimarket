<?php
 // busco market
 use app\controllers\cuponController;
 $cuponController = new cuponController();
 $company_id = $_SESSION['user_company_id'];

 use app\controllers\productController;
$productController = new productController();
$product_list = $productController->listarTodosProductControlador($company_id, '*');
?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid"> 
            <div class="row">
                <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/cuponAjax.php" 
                    method="POST" autocomplete="off" enctype="multipart/form-data" >
                    <input type="hidden" name="modulo_cupon" value="registrar">
                    <input type="hidden" name="company_id" value="<?=$_SESSION['user_company_id']?>">
                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                   |<li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                            <i class="fas fa-home"></i> CREACION - Información de Cupones de productos
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="text-center">
                                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                    <img src="<?php echo APP_URL; ?>app/views/fotos/nophoto.jpg" 
                                    class="rounded-circle avatar-xl img-thumbnail user-profile-image  shadow" 
                                    alt="user-profile-image">
                                    <div class="avatar-xs p-0 rounded-circle ">
                                        <input id="profile-img-file-input" name="cupon_foto" type="file" 
                                        accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                        
                                        <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                            <span class="avatar-title rounded-circle bg-light text-body shadow">
                                                <i class="ri-camera-fill"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="codigo" class="form-label">Código <strong>
                                                    <?php echo CAMPO_OBLIGATORIO; ?></strong></label>
                                                    <input name="codigo" type="text" class="form-control" 
                                                    id="codigo" placeholder="Entre su codigo" 
                                                    pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{3,40}" 
                                                    maxlength="40" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label">Nombre corto del cupón <strong>
                                                    <?php echo CAMPO_OBLIGATORIO; ?></strong></label>
                                                    <input name="nombre" type="text" class="form-control" id="nombre" 
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
                                                    <input name="cupon_inicio" type="date" class="form-control"  id="cupon_inicio" placeholder="Fecha de inicio de la oferta" required 
                                                    />
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="cupon_final" class="form-label">Fecha final de la oferta <?php echo CAMPO_OBLIGATORIO; ?></label>
                                                    <input name="cupon_final" type="date" required
                                                    class="form-control"  id="cupon_final"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="tipo_oferta" class="form-label">Tipo_oferta <?php echo CAMPO_OBLIGATORIO; ?></label>
                                                    <select name="tipo_oferta" class="form-control" data-choices data-choices-text-unique-true id="tipo_oferta">
                                                        <option value="P">Aplica porcentaje %</option>
                                                        <option value="M">Aplica un monto $</option>
                                                    </select>
                                                </div>
                                            </div>
                                                <!--end col-->
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label for="valor_descuento" class="form-label">Valor descuento <strong>
                                                    <?php echo CAMPO_OBLIGATORIO; ?></strong></label>
                                                    <input name="valor_descuento" type="number" step="0.01" class="form-control" id="valor_descuento" placeholder="Entre el valor de descuento" 
                                                    maxlength="40" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label for="valor_descuento" class="form-label">Mínima compra<strong>
                                                    <?php echo CAMPO_OBLIGATORIO; ?></strong></label>
                                                    <input name="cantidad_minima" type="number" class="form-control" id="cantidad_minima" placeholder="Entre la cantidad_mínima" 
                                                    maxlength="40" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label for="cupon_token" class="form-label">Token Cupón <strong>
                                                    <?php echo CAMPO_OBLIGATORIO; ?></strong></label>
                                                    <input name="cupon_token" type="number" class="form-control" id="cupon_token" 
                                                    placeholder="Entre la número del cupón a compartir" 
                                                    maxlength="40" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label for="detiene_compra" class="form-label">Se detiene a  <strong>
                                                    <?php echo CAMPO_OBLIGATORIO; ?></strong></label>
                                                    <input name="detiene_compra" type="number" class="form-control" id="detiene_compra" 
                                                    placeholder="Este cupon dejara de funcinoar a las N ventas acumuladas" 
                                                    maxlength="40" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Agregar Cupón</button>
                                                    <a href="<?php echo APP_URL; ?>cuponList/" class="btn btn-soft-success">Cancelar</a>
                                                    
                                                </div>
                                                <p class="has-text-centered pt-6">
                                                    <small>Los campos con <strong><?php echo CAMPO_OBLIGATORIO; ?></strong> son obligatorios</small>
                                                </p>
                                                <br><br><br><br><br><br><br><br><br><br>
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
