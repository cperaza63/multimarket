<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
        
            <?php
            use app\controllers\proveedorController;
            $insProveedor = new proveedorController();
            $company_id = $_SESSION['user_company_id'];
            ?>
        
            <div class="row">
                <div class="col-xxl-3" style="margin-bottom: -15px;">
                    <div class="card">
                        <div class="card-body">
                            <div class="columns">
                                <div class="column">
                                    <form class="FormularioAjax" 
                                    action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" 
                                    method="POST" autocomplete="off" >
                                        <input type="hidden" name="modulo_buscador" value="buscar">
                                        <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                                        <div class="col-xs-12 col-md-6">
                                            <div class="form-group">
                                                <label for=""></label>
                                                <div class="input-group">
                                                    <input class="form-control is-rounded" type="text"
                                                    name="txt_buscador" placeholder="¿Qué estas buscando?..." 
                                                    value="<?php echo isset($_SESSION[$url[0]])?$_SESSION[$url[0]]:""; ?>"
                                                    maxlength="30" required >
                                                    <button class="btn btn-info" type="submit" >Buscar</button>
                                                    <a href="<?php echo APP_URL; ?>proveedorNew/" class="btn btn-success" >Agregar al Proveedor</a>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <?php
                            if(isset($_SESSION[$url[0]]) && !empty($_SESSION[$url[0]])){
                            ?>
                                <div class="columns">
                                    <div class="column col-xs-6 col-md-6">
                                        <form class="form-control FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                                            <input type="hidden" name="modulo_buscador" value="eliminar">
                                            <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                                            <i class="fas fa-search fa-fw"></i></strong>
                                            
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash-restore"></i> &nbsp; Eliminar busqueda</button>
                                        </form>
                                    </div>
                                </div>
                            <?php 
                            }
                            ?>

                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
            <?php

            if(isset($_SESSION[$url[0]]) && !empty($_SESSION[$url[0]])){
                $datos = $insProveedor->listarTodosProveedorControlador($company_id, $_SESSION[$url[0]]);
            }else{
                $datos = $insProveedor->listarTodosProveedorControlador($company_id, "*");
            }
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                    <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <a href="<?php echo APP_URL; ?>dashboard/" class="btn btn-soft-success">Regresar</a>
                            </div>
                        </div>
                        <div class="card-header">
                            <h5 class="card-title mb-0">Lista de Proveedores por Tienda</h5>
                        </div>
                        <div class="card-body">
                            <table id="fixed-header" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 10px;">
                                            <div class="form-check">
                                                <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                            </div>
                                        </th>
                                        <th>Logo</th>
                                        <th>Nombre</th>
                                        <th>Acción</th>
                                        <th>Id</th>
                                        <th>Email</th>
                                        <th>Telefono</th>
                                        <th>Ubicación</th>
                                        <th>Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    <?php
                                    if(is_array($datos)){
                                        foreach($datos as $rows){
                                            if($rows['proveedor_logo'] != ""){
                                                $proveedor_logo = APP_URL . "app/views/fotos/company/".$rows['company_id']."/proveedores/".$rows['proveedor_logo'];
                                            }else{
                                                $proveedor_logo = APP_URL . "app/views/fotos/nophoto.jpg";
                                            }
                                            ?>
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input fs-15" type="checkbox" name="checkAll" value="option1">
                                                    </div>
                                                </th>
                                                <td>
                                                    <a href="<?= APP_URL.'proveedorUpdate/'.$rows['proveedor_id'].'/'?>">
                                                    <img class="rounded-circle header-profile-user" 
                                                    src="<?=$proveedor_logo; ?>" 
                                                    alt="Logo del proveedor de la tabla">
                                                    </a>
                                                </td>
                                                <td><?=$rows['proveedor_name'];?></td>
                                                <td>
                                                    <div class="dropdown d-inline-block">
                                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill align-middle"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a href="<?= APP_URL.'proveedorUpdate/'.$rows['proveedor_id'].'/'?>" class="dropdown-item"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Editar</a></li>
                                                            <li>

                                                            <li>
                                                                    <form class="FormularioAjax" action="<?=APP_URL?>app/ajax/proveedorAjax.php" method="POST" autocomplete="off" >
                                                                    <input type="hidden" name="modulo_proveedor" value="eliminar">
                                                                    <input type="hidden" name="proveedor_id" value="<?=$rows['proveedor_id']?>">
                                                                    <input type="hidden" name="company_id"   value="<?=$rows['company_id']?>">
                                                                    <button type="submit" class="dropdown-item" > <i class="ri-delete-back-2-line align-bottom me-2 text-muted"></i>Borrar
                                                                    </button>
                                                                </form>
                                                            <li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td><?=$rows['proveedor_id'];?></td>
                                                <td><?=$rows['proveedor_email'];?></td>
                                                <td><?=$rows['proveedor_phone'];?></td>
                                                <td><?=$rows['proveedor_address'];?></td>
                                                <td>
                                                    <?php
                                                    if($rows['proveedor_estatus'] ==1 ){
                                                        ?><span class="badge bg-success">Activo<?php
                                                    }else{
                                                        ?><span class="badge bg-danger">Inactivo<?php
                                                    }?>
                                                    </span>
                                                </td>
                                            </tr>
                                    <?php
                                        }    
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <a href="<?php echo APP_URL; ?>dashboard/" class="btn btn-soft-success">Regresar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div><!-- End Page-content -->
</div>
