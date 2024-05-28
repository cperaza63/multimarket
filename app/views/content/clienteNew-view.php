<!-- ============================================================== -->
<!-- BASE DE DATOS PARA AJAX -->
<!-- ============================================================== -->
<?php
$mysqli = new mysqli("localhost","root","","multimarket");
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
}
use app\controllers\ubicacionController;
$ubicacionController = new ubicacionController();
// busco paises
$paises = $ubicacionController->obtenerPaisControlador();
// busco estados
if (isset($_POST['country'])){
    $estados = $ubicacionController->obtenerEstadosControlador($_POST['country']);
}else{
    $estados = $ubicacionController->obtenerEstadosControlador(APP_COUNTRY);
}
// Parametros para el ajax de Ciudad
// no aplica selected porque es nuevo, no hay POST
$city_user=0;
if (isset($_POST['state'])){
    $q=$_POST['state'];
}else{
    $q=$state_user;
}
?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid"> 
            <div class="row">
                <!-- 
                    FORMULARIO  
                                -->
                <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/clienteAjax.php" 
                    method="POST" autocomplete="off" enctype="multipart/form-data" >
                    <input type="hidden" name="modulo_cliente" value="registrar">
                    <input type="hidden" name="cliente_user" value="<?=$_SESSION['id']?>">
                    <input type="hidden" name="company_id" value="<?=$_SESSION['user_company_id']?>">
                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                   |<li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#companyDetalis" role="tab">
                                            <i class="fas fa-home"></i> CREACIóN DE PROVEEDORES del Negocio/Tienda
                                        </a>
                                    </li>
                                </ul>
                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="clienteDetalis" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="cliente_name" class="form-label">Nombre Tienda/negocio</label>
                                                    <input name="cliente_name" type="text" class="form-control" 
                                                    id="codigo" placeholder="Entre el nombre oficial" 
                                                    pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{5,80}" 
                                                    maxlength="80" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3 pb-2">
                                                    <label for="location" class="form-label">Breve descripción</label>
                                                    <textarea name="cliente_description" class="form-control" 
                                                    id="exampleFormControlTextarea" 
                                                    placeholder="Breve descripción del negocio" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3 pb-2">
                                                    <label for="location" class="form-label">Dirección</label>
                                                    <textarea name="cliente_address" class="form-control" 
                                                    id="exampleFormControlTextarea" 
                                                    placeholder="Dirección del negocio" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="countryInput" class="form-label">País</label>
                                                    <?php
                                                    
                                                    if(is_array($paises)){
                                                        foreach($paises as $pais){
                                                            ?>
                                                                <select name="cliente_country" class="form-control" 
                                                                data-choices data-choices-text-unique-true id="country">
                                                                    <option value="<?=$pais['country'];?>"
                                                                        ><?=$pais['country'];?>
                                                                    </option>
                                                            </select>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="cliente_state" class="form-label">Estado/Provincia</label>
                                                    <select name="cliente_state" 
                                                    language="javascript:void(0)" 
                                                    onchange="loadAjaxCiudadHive(this.value, <?=$city_user?>)"
                                                    class="form-control" data-choices data-choices-text-unique-true id="state">
                                                    <?php
                                                    if(is_array($estados)){
                                                        foreach($estados as $estado){
                                                            ?>
                                                            <option value="<?=$estado['state_abbreviation'];?>"><?=$estado['state_name'];?>
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
                                                    <label for="cliente_city" class="form-label">Ciudades</label>
                                                    <select name="cliente_city" class="form-control" data-choices data-choices-text-unique-true id="city">
                                                    <?php
                                                        if ($res = $mysqli -> query("SELECT * FROM ubicacion WHERE state_abbreviation<>'' AND 
                                                        state_abbreviation='$q' ORDER BY city")) {
                                                        ?>
                                                            <?php while($fila=mysqli_fetch_array($res)){ ?>
                                                            <option value="<?php echo $fila['id']; ?>">
                                                            <?php echo $fila['city']==""?"Seleccione Ciudad": $fila['city']; ?></option>
                                                            <?php } ?>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="cliente_email" class="form-label">Email del negocio</label>
                                                    <input name="cliente_email" type="email" class="form-control" 
                                                    id="cliente_email" placeholder="Email del Cliente" required 
                                                    />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="cliente_phone" class="form-label">Teléfono contacto</label>
                                                    <input name="cliente_phone" type="number" class="form-control" 
                                                    id="codigo" placeholder="Entre su numero de contacto" 
                                                    maxlength="80" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="cliente_rif" class="form-label">Número de Rif</label>
                                                    <input name="cliente_rif" type="text" class="form-control" 
                                                    id="codigo" placeholder="Entre su numero de rif, ejemplo: J12304567890" 
                                                    maxlength="20" required>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label for="cliente_estatus" class="form-label">Estatus Actual</label>
                                                    <select name="cliente_estatus" class="form-control" required 
                                                        data-choices data-choices-text-unique-true id="tipo">
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <?php
                                            $createdAt = date("Y-m-d");
                                            //echo $createdAt; ?>

                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Agregar el Cliente</button>
                                                    <a href="<?php echo APP_URL; ?>clienteList/" 
                                                    class="btn btn-soft-success">Regresar</a>
                                                    
                                                </div>
                                                <p class="has-text-centered pt-6">
                                                    <small>Los campos marcados con 
                                                    <strong><?php echo CAMPO_OBLIGATORIO; ?></strong> son obligatorios</small>
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
