<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <?php
            use app\controllers\bancoController;
            $insBanco = new bancoController();
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
                                                    <a href="<?php echo APP_URL; ?>bancoNew/" class="btn btn-success" >Agregar Banco</a>
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
                                        <form class="form-control FormularioAjax" 
                                            action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" 
                                            method="POST" autocomplete="off" >
                                            <input type="hidden" name="modulo_buscador" value="eliminar">
                                            <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                                            <i class="fas fa-search fa-fw"></i></strong>
                                            
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash-restore"></i> &nbsp; Eliminar búsqueda</button>
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
                $datos = $insBanco->listarTodosBancoControlador($_SESSION[$url[0]]);
            }else{
                $datos = $insBanco->listarTodosBancoControlador("*");
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
                            <h5 class="card-title mb-0">Lista de valores de la Tabla Bancos</h5>
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
                                        <th>Action</th>
                                        <th>Banco</th>
                                        <th>Nombre</th>
                                        <th>Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(is_array($datos)){
                                        foreach($datos as $rows){
                                            if($rows['banco_foto'] != ""){
                                                $banco_foto = APP_URL . "app/views/fotos/company/".$rows['company_id']."/bancos/".$rows['banco_foto'];
                                            }else{
                                                $banco_foto = APP_URL . "app/views/fotos/nophoto.jpg";
                                            }
                                            
                                            ?>
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input fs-15" type="checkbox" name="checkAll" value="option1">
                                                    </div>
                                                </th>
                                                
                                                <td>
                                                    <a href="<?= APP_URL.'bancoUpdate/'.$rows['banco_id'].'/'?>">
                                                    <img class="rounded-circle header-profile-user" 
                                                    src="<?=$banco_foto; ?>" 
                                                    alt="Foto del item de la tabla">
                                                    </a>
                                                </td>
                                                
                                                <td>
                                                    <div class="dropdown d-inline-block">
                                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" 
                                                        aria-expanded="false"><i class="ri-more-fill align-middle"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a href="<?= APP_URL.'bancoUpdate/'.$rows['banco_id'].'/'?>" 
                                                                class="dropdown-item"><i class="ri-pencil-fill align-bottom me-2 text-muted">
                                                                </i> Editar</a>
                                                            </li>
                                                            <li>
                                                                <form class="FormularioAjax" action="<?=APP_URL?>app/ajax/bancoAjax.php" 
                                                                method="POST" autocomplete="off" >
                                                                    <input type="hidden" name="modulo_banco" value="eliminar">
                                                                    <input type="hidden" name="banco_id" value="<?=$rows['banco_id']?>">
                                                                    <input type="hidden" name="company_id" value="<?=$rows['company_id']?>">
                                                                    <button type="submit" class="dropdown-item" > 
                                                                        <i class="ri-delete-back-2-line align-bottom me-2 text-muted"></i>Borrar
                                                                    </button>
                                                                </form>
                                                            <li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td><?=$rows['codigo'];?></td>
                                                <td><?=$rows['nombre'];?></td>
                                                
                                                <td>
                                                    <?php
                                                    if($rows['estatus'] ==1 ){
                                                        ?><span class="badge bg-success">Activo<?php
                                                    }else{
                                                        ?><span class="badge bg-danger">Inactivo<?php
                                                    }?>
                                                    </span>
                                                </td>
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
