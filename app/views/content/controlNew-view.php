<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid"> 
            <div class="row">

                <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/controlAjax.php" 
                    method="POST" autocomplete="off" enctype="multipart/form-data" >
                    <input type="hidden" name="modulo_control" value="registrar">

                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                   |<li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                            <i class="fas fa-home"></i> Información de Control del sistema
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="text-center">
                                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                    <img src="http://localhost/multimarket/app/views/fotos/nophoto.jpg" 
                                    class="rounded-circle avatar-xl img-thumbnail user-profile-image  shadow" 
                                    alt="user-profile-image">
                                    <div class="avatar-xs p-0 rounded-circle ">
                                        <input id="profile-img-file-input" name="control_foto" type="file" 
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
                                                    <label for="codigo" class="form-label">Código</label>
                                                    <input name="codigo" type="text" class="form-control" name="codigo" 
                                                    id="codigo" placeholder="Entre su codigo" 
                                                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" 
                                                    maxlength="40" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label">Nombre</label>
                                                    <input name="nombre" type="text" class="form-control" id="nombre" 
                                                    placeholder="Entre el nombre"
                                                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" 
                                                    maxlength="40" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="tipo" class="form-label">Tipo de Tabla</label>
                                                    <select name="tipo" class="form-control" data-choices data-choices-text-unique-true id="tipo">
                                                        <option value="">Seleccione un tipo</option>
                                                        <option value="market">Market Place</option>
                                                        <option value="market_cat">Categorias Market</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="tipo" class="form-label">Si es una categoria de Market</label>
                                                    <select name="tipo" class="form-control" data-choices data-choices-text-unique-true id="tipo">
                                                        <option value="">Seleccione un Market</option>
                                                        <option value="market">CiudadHive Market</option>
                                                        <option value="market_cat">Comida Market</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Agregar a la Tabla</button>
                                                    <a href="<?php echo APP_URL; ?>controlList/" class="btn btn-soft-success">Cancelar</a>
                                                    
                                                </div>
                                                <p class="has-text-centered pt-6">
                                                    <small>Los campos marcados con <strong><?php echo CAMPO_OBLIGATORIO; ?></strong> son obligatorios</small>
                                                </p>
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
