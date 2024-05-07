<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid"> 
            <div class="row">

                <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" 
                    method="POST" autocomplete="off" enctype="multipart/form-data" >
                    <input type="hidden" name="modulo_usuario" value="registrar">

                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                   |<li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                            <i class="fas fa-home"></i> Información personal
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="text-center">
                                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                    <img src="http://localhost/multimarket/app/views/fotos/default.png" 
                                    class="rounded-circle avatar-xl img-thumbnail user-profile-image  shadow" 
                                    alt="user-profile-image">
                                    <div class="avatar-xs p-0 rounded-circle ">
                                        <input id="profile-img-file-input" name="usuario_foto" type="file" 
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
                                                    <label for="firstnameInput" class="form-label">Primer nombre</label>
                                                    <input name="firstname" type="text" class="form-control" name="usuario_nombre" 
                                                    id="firstnameInput" placeholder="Enter your firstname" 
                                                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" 
                                                    maxlength="40" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="lastnameInput" class="form-label">Apellido</label>
                                                    <input name="lastname" type="text" class="form-control" id="lastnameInput" 
                                                    placeholder="Enter your lastname"
                                                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" 
                                                    maxlength="40" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email Address</label>
                                                    <input name="email" type="text" class="form-control" id="email" 
                                                    placeholder="Coloque su email" 
                                                    >
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-2">
                                                <div class="mb-1">
                                                    <label for="rif" class="form-label">Cedula/Rif</label>
                                                    <input name="rif" size="4" type="text" class="form-control" id="rif"
                                                    placeholder="Cedula o Rif" 
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="mb-1">
                                                    <label for="phonenumberInput" class="form-label">Telefono/Area</label>
                                                    <input name="tcarea" size="4" type="text" class="form-control" id="tcarea" 
                                                    placeholder="Codigo de area" 
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="mb-1">
                                                    <label for="phonenumberInput" class="form-label">Telefono/Número</label>
                                                    <input name="tcnumber" size="10" type="text" class="form-control" id="tcnumber" 
                                                    placeholder="Numero de telefono" 
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="tipo" class="form-label">Tipo de Usuario</label>
                                                    <select name="tipo" class="form-control" data-choices data-choices-text-unique-true id="tipo">
                                                        <option value="">Seleccione un Perfil</option>
                                                        <option value="ADMINISTRATOR"
                                                        >Administrador</option>
                                                        <option value="VENDOR"
                                                        >Vendedor/promotor</option>
                                                        <option value="DESPACHADOR" 
                                                        >Despachador</option>
                                                        <option value="DISTRIBUIDOR"
                                                        >Distribuidor</option>
                                                        <option value="USUARIO"
                                                        >Estudiante</option>
                                                        <option value="ASISTENTE"
                                                        >Asistente</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="departamento" class="form-label">Departamento/designación</label>
                                                    <input name="departamento" type="text" class="form-control" id="departamento" placeholder="Designation" 
                                                    >
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="company_id" class="form-label">Empresa/Tienda asignada</label>
                                                    <input name="company_id" type="text" class="form-control" id="company_id" placeholder="Tienda asignada" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="city" class="form-label">Ciudad</label>
                                                    <input name="city" type="text" class="form-control" id="cityInput" placeholder="Ciudad" 
                                                    />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="state" class="form-label">Estado/Provincia</label>
                                                    <input name="state" type="text" class="form-control" minlength="2" maxlength="10" id="state" placeholder="Enter Estado/provincia" >
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="countryInput" class="form-label">País</label>
                                                    <input name="country" type="text" class="form-control" id="country" placeholder="Pais"  
                                                    />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="mb-3 pb-2">
                                                    <label for="location" class="form-label">Dirección</label>
                                                    <textarea name="location" class="form-control" id="exampleFormControlTextarea" placeholder="Dirección de habitación" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <!--end col-->

                                            <?php
                                            $createdAt = date("Y-m-d");
                                            //echo $createdAt; ?>
                                            
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="gender" class="form-label">Género</label>
                                                    <select name="gender" class="form-control" data-choices data-choices-text-unique-true id="gender">
                                                        <option value="M"
                                                        >Masculino</option>
                                                        <option value="F"
                                                        >Femenino</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="dateofbirth" class="form-label">Fecha de nacimiento</label>
                                                    <input name="dateofbirth" type="date" class="form-control"  id="dateofbirth" placeholder="Seleccione una fecha" 
                                                    value="<?php echo $createdAt; ?>"
                                                    />
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="created_at" class="form-label">Usuario a incorporar</label>
                                                    <input name="created_at" disabled name="created_at" type="date" class="form-control"  id="created_at"
                                                    value="<?php echo $createdAt; ?>"
                                                    />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="row g-2">
                                                <div class="col-lg-4">
                                                    <div>
                                                        <label for="newpasswordInput" class="form-label">Nuevo Password*</label>
                                                        <input name="new_password" pattern="[a-zA-Z0-9$@.-]{7,100}" type="password" class="form-control" id="newpasswordInput" placeholder="Coloque nuevo password">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div>
                                                        <label for="confirmpasswordInput" class="form-label">Confirmar Password*</label>
                                                        <input name="repeat_password" pattern="[a-zA-Z0-9$@.-]{7,100}" type="password" class="form-control" id="confirmpasswordInput" placeholder="Confirme nuevo password">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end row-->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                                                    <button type="button" class="btn btn-soft-success">Cancelar</button>
                                                    
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
