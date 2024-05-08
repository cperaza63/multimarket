<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
        
        <?php
            // por ahora actualizamos datos del administrador

            $control_id = $insLogin->limpiarCadena($url[1]);

            $datos = $insLogin->seleccionarDatos( "Unico", "control", "control_id", $control_id );

            if($datos->rowCount()==1){
                $datos = $datos->fetch();
                $control_id = $datos['control_id'];
                $codigo   = $datos['codigo'];
                $nombre   = $datos['nombre'];
                $accion = "actualizar";
                $boton_accion = "Actualizar";
                $control_foto = $datos['control_foto'];
                if( $datos['control_foto'] ==""){
                    $control_foto = "http://localhost/multimarket/app/views/fotos/default.png";
                }
                $pasa = 1;
            }else{
                // registro es nuevo
                $pasa = 0;
                $accion = "registrar";
                $boton_accion = "Agregar";
            }
            //print_r($control_foto);
            //exit();

            if($pasa == 1){
            ?>
                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card mt-n6">
                            <div class="card-body p-1">
                                <div class="text-center">
                                    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/controlAjax.php" 
                                        method="POST" autocomplete="off" enctype="multipart/form-data" >
                                        <!--    Campos parametros     -->
                                        <input type="hidden" name="modulo_control" value="actualizarFoto">
                                        <input type="hidden" name="control_id" value="<?php echo $datos['control_id']; ?>">

                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                            
                                            <img src="http://localhost/multimarket/app/views/fotos/control/<?php echo $control_foto; ?>" 
                                            class="rounded-circle avatar-xl img-thumbnail user-profile-image  shadow" 
                                            alt="user-profile-image">
                                            
                                            <table>
                                                <tr>
                                                    <td>
                                                        <button type="submit" class="avatar-title rounded-circle bg-light text-body shadow">
                                                                <i class="ri-upload-2-fill"></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <div class="avatar-xs p-0 rounded-circle ">
                                                            <input id="profile-img-file-input" name="control_foto" type="file" 
                                                            accept=".jpg, .png, .jpeg" class="profile-img-file-input">
                                                            
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
                                    <h5 class="fs-16 mb-1"><?php echo $datos['nombre']; ?></h5>
                                    <p class="text-muted mb-0"><?php echo $datos['codigo'] . " Item # " . $datos['control_id']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <form class="FormularioAjax" 
                        action="<?php echo APP_URL; ?>app/ajax/controlAjax.php" 
                        method="POST" autocomplete="off" 
                        enctype="multipart/form-data" >
                        
                        <input type="hidden" name="modulo_control" value="<?=$accion;?>">
                        <input type="hidden" name="control_id" value="<?=$control_id;?>">
                        <input type="hidden" name="codigo" value="<?=$codigo;?>">

                        <div class="col-xxl-9">
                            <div class="card mt-xxl-n5">
                                <div class="card-header">
                                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                    |<li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                                <i class="fas fa-home"></i> Información del Item
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body p-4">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                            <form action="javascript:void(0);">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="codigo" class="form-label">Código</label>
                                                            <input name="codigo" type="text" class="form-control" name="codigo" 
                                                            id="firstnameInput" placeholder="Entre el codigo" 
                                                            value="<?php echo $datos['codigo']; ?>"
                                                            pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" 
                                                            maxlength="40" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="lastnameInput" class="form-label">Nombre</label>
                                                            <input name="nombre" type="text" class="form-control" id="nombre" 
                                                            placeholder="Entre el nombre del item" 
                                                            value="<?php echo $datos['nombre']; ?>"
                                                            pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,80}" 
                                                            maxlength="40" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="tipo" class="form-label">Tipo de Tabla</label>
                                                            <select name="tipo" class="form-control" data-choices data-choices-text-unique-true id="tipo">
                                                                <option value="market"
                                                                <?php if( $datos['tipo'] == 'market'  ) echo"selected" ?>
                                                                >Market Place</option>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </form>

                </div>
                <!--end row-->
            <?php
            }
            ?>
        </div>
        <!-- container-fluid -->
    </div><!-- End Page-content -->
</div>
