<?php
//print_r($_SESSION['view']);

if(isset($_SESSION['view'])){
    $view=explode("/", $_SESSION['view']);
    if( isset( $view[1]) && $view[1] != "" ){
        $marca_id = $view[1];
    }
}else{
    echo "Error, no hay parámetro de categoría";
}

use app\controllers\marcaController;
$insMarca = new marcaController();
$marca = $insMarca->obtenerUnItemControlador($marca_id);
use app\controllers\modeloController;
$modeloController = new modeloController();
$datos_modelo = $modeloController->obtenerUnItemControlador($marca_id);
if ($datos_modelo == false ){
    $haydatos = false;
}else{
    $haydatos = true;
}
?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid"> 
            <div class="row">
                <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/modeloAjax.php" 
                    method="POST" autocomplete="off" enctype="multipart/form-data" >
                    <input type="hidden" name="modulo_modelo" value="registrar">
                    <input type="hidden" name="marca_id" value="<?=$marca_id?>">
                    <input type="hidden" name="company_id" value="<?=$_SESSION['user_company_id']?>">

                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                   |<li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                            <i class="fas fa-home"></i> CREACION <?="(".$marca_id . ") " . $marca['nombre']?> - 
                                            Información de Modelo 
                                            <?php
                                             if($haydatos==0){
                                                echo "";
                                            }else{
                                                echo $datos_modelo['nombre'];
                                            }
                                            ?>
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
                                        <input id="profile-img-file-input" name="marca_foto" type="file" 
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
                                                    <label for="cat_id" class="form-label">Marca actual<strong>
                                                    <?php echo CAMPO_OBLIGATORIO; ?></strong></label>
                                                    <input name="cat_id" type="text" class="form-control" 
                                                    id="codigo" disabled value="<?php if ($haydatos!= ""){echo $marca_id." - " . $datos_modelo['nombre'];}else{echo trim($marca_id);}
                                                    ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="codigo" class="form-label">Código Modelo<strong>
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
                                                    <label for="nombre" class="form-label">Nombre Modelo<strong>
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
                                                    <button type="submit" class="btn btn-primary">Agregar Modelo</button>
                                                    <a href="<?php echo APP_URL; ?>modeloList/<?=$marca_id?>/" class="btn btn-soft-success">Cancelar</a>
                                                    
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
