<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
        
            <?php
            use app\controllers\userController;
            $insMarket = new userController();
            ?>
        
            <div class="row">
                <div class="col-xxl-3" style="margin-bottom: -15px;">
                    <div class="card">
                        <div class="card-body">
                            <div class="columns">
                                <div class="column">
                                    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                                        <input type="hidden" name="modulo_buscador" value="buscar">
                                        <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">

                                        <div class="col-xs-12 col-md-6">
                                            <div class="form-group">
                                                <label for=""></label>
                                                <div class="input-group">
                                                    <input class="form-control is-rounded" type="text"
                                                    name="txt_buscador" placeholder="¿Qué estas buscando?..." pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" required >
                                                    
                                                    <button class="btn btn-info" type="submit" >Buscar</button>
                                                    
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
                                            <i class="fas fa-search fa-fw"></i> &nbsp; Estas buscando <strong>“<?php echo $_SESSION[$url[0]]; ?>”</strong>
                                            
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
                $datos = $insMarket->listarTodosUsuarioControlador($_SESSION[$url[0]]);
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Lista de Usuarios</h5>
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
                                            <th>ID</th>
                                            <th>Usuario</th>
                                            
                                            <th>Email</th>
                                            <th>Telefono</th>
                                            <th>Assigned To</th>
                                            <th>Created By</th>
                                            <th>Create Date</th>
                                            <th>Status</th>
                                            <!--<th>Status</th>-->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                        <?php
                                        if(is_array($datos)){
                                            foreach($datos as $rows){
                                                ?>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input fs-15" type="checkbox" name="checkAll" value="option1">
                                                        </div>
                                                    </th>
                                                    <td><?=$rows['user_id'];?></td>
                                                    <td><?=$rows['firstname'] . " " . $rows['lastname'];?></td>
                                                    <td><?=$rows['email'];?></td>
                                                    <td><?=$rows['tcarea']."-".$rows['tcnumber'];?></td>
                                                    <td>Alexis Clarke</td>
                                                    <td>Joseph Parker</td>
                                                    <td><?=$rows['tcarea']."-".$rows['created_at'];?></td>
                                                    
                                                    <td>
                                                        <?php
                                                        if($rows['estatus'] =1 ){
                                                            ?><span class="badge bg-success">Activo<?php
                                                        }else{
                                                            ?><span class="badge bg-danger">Borrado<?php
                                                        }?>
                                                        </span></td>
                                                    
                                                <!-- <td><span class="badge bg-info-subtle text-info">Re-open</span></td> -->
                                                    
                                                    <td>
                                                        <div class="dropdown d-inline-block">
                                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-fill align-middle"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                                <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                <li>
                                                                    <a class="dropdown-item remove-item-btn">
                                                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                        <?php
                                            }    
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <!-- container-fluid -->
    </div><!-- End Page-content -->
</div>
