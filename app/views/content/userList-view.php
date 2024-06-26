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
                                                    name="txt_buscador" placeholder="¿Qué estas buscando?..." 
                                                    value="<?php echo isset($_SESSION[$url[0]])?$_SESSION[$url[0]]:""; ?>"
                                                    maxlength="30" required >
                                                    <button class="btn btn-info" type="submit" >Buscar</button>
                                                    <a href="<?php echo APP_URL; ?>userNew/" class="btn btn-success" >Agregar Usuario</a>
                                                    
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
            }else{
                $datos = $insMarket->listarTodosUsuarioControlador("*");
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
                                        
                                        <th>Img</th>
                                        <th>Usuario</th>
                                        <th>Action</th>
                                        <th>Email</th>
                                        <th>Telefono</th>
                                        <th>Status</th>
                                        <th>Empresa</th>
                                        <!--<th>Status</th>-->
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    <?php
                                    if(is_array($datos)){
                                        foreach($datos as $rows){
                                            if($rows['usuario_foto'] != ""){
                                                $usuario_foto = APP_URL . "app/views/fotos/usuarios/".$rows['usuario_foto'];
                                            }else{
                                                $usuario_foto = "<?php echo APP_URL; ?>app/views/images/users/avatar-1.jpg";
                                            }
                                            
                                            ?>
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input fs-15" type="checkbox" name="checkAll" value="option1">
                                                    </div>
                                                </th>
                                                
                                                <td>
                                                    <a href="<?= APP_URL.'userUpdate/'.$rows['user_id'].'/'?>">
                                                    <img class="rounded-circle header-profile-user" src="<?=$usuario_foto?>" alt="Header Avatar">
                                                    </a>
                                                </td>
                                                
                                                <td><?=$rows['firstname'] . " " . $rows['lastname'];?></td>
                                                
                                                <td>
                                                    <div class="dropdown d-inline-block">
                                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill align-middle"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a href="<?= APP_URL.'userUpdate/'.$rows['user_id'].'/'?>" class="dropdown-item"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Editar</a></li>
                                                            <li>

                                                            <li>
                                                                    <form class="FormularioAjax" action="<?=APP_URL?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off" >

                                                                    <input type="hidden" name="modulo_usuario" value="eliminar">
                                                                    <input type="hidden" name="user_id" value="<?=$rows['user_id']?>">

                                                                    <button type="submit" class="dropdown-item" > <i class="ri-delete-back-2-line align-bottom me-2 text-muted"></i>Borrar
                                                                    </button>
                                                                </form>
                                                            <li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td><?=$rows['email'];?></td>
                                                <td><?=$rows['tcarea']."-".$rows['tcnumber'];?></td>
                                                
                                                <td>
                                                    <?php
                                                    if($rows['estatus'] == 1 ){
                                                        ?><span class="badge bg-success">Activo<?php
                                                    }else{
                                                        ?><span class="badge bg-danger">Borrado<?php
                                                    }?>
                                                    </span>
                                                </td>
                                                <td><?=$rows['company_name']." (".$rows['company_id'].")";?></td>
                                            <!-- <td><span class="badge bg-info-subtle text-info">Re-open</span></td> -->
                                                
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
