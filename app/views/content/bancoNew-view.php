<?php
 // busco market
use app\controllers\bancoController;
$bancoController = new bancoController();
use app\controllers\controlController;
$insControl = new controlController();
$listaBancos = $insControl->obtenerListaMarketControlador("bancos");

?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid"> 
            <div class="row">
                <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/bancoAjax.php" 
                    method="POST" autocomplete="off" enctype="multipart/form-data" >
                    <input type="hidden" name="modulo_banco" value="registrar">
                    <input type="hidden" name="company_id" value="<?=$_SESSION['user_company_id']?>">
                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                   |<li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                            <i class="fas fa-home"></i> CREACION - Información de Bancos
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
                                        <input id="profile-img-file-input" name="banco_foto" type="file" 
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
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="unidad" class="form-label">Bancos Disponibles</label>
                                                <select name="unidad" class="form-control" data-choices data-choices-text-unique-true id="company_id">
                                                    <?php
                                                    if(is_array($listaBancos)){
                                                        foreach($listaBancos as $listaBanco){
                                                        ?>
                                                            <option value="<?=$listaBanco['control_id'];?>"
                                                                ><?=$listaBanco['nombre'];?>
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
                                                    <label for="codigo" class="form-label">Código <strong>
                                                    <?php echo CAMPO_OBLIGATORIO; ?></strong></label>
                                                    <input name="codigo" type="text" class="form-control" 
                                                    id="codigo" placeholder="Entre su codigo" 
                                                    pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{3,40}" 
                                                    maxlength="40" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label">Nombre <strong>
                                                    <?php echo CAMPO_OBLIGATORIO; ?></strong></label>
                                                    <input name="nombre" type="text" class="form-control" id="nombre" 
                                                    placeholder="Entre el nombre"
                                                    pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{5,80}" 
                                                    maxlength="80" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Agregar Banco</button>
                                                    <a href="<?php echo APP_URL; ?>bancoList/" class="btn btn-soft-success">Cancelar</a>
                                                    
                                                </div>
                                                <p class="has-text-centered pt-6">
                                                    <small>Los campos marcados con <strong><?php echo CAMPO_OBLIGATORIO; ?></strong> son obligatorios</small>
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
