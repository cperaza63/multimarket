<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
        
        <?php
		use app\controllers\userController;
		$insMarket = new userController();

		$datos = $insMarket->listarTodosUsuarioControlador("");
	?>
            <div class="row">
                <div class="col-xxl-3" style="margin-bottom: -15px;">
                    <!--end card-->
                    <div class="card">
                        <div class="card-body">
                            aqui para buscar
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->

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
                                        <th>SR No.</th>
                                        <th>Usuario</th>
                                        <th>ID</th>
                                        <th>Email</th>
                                        <th>Telefono</th>
                                        <th>Assigned To</th>
                                        <th>Created By</th>
                                        <th>Create Date</th>
                                        <th>Status</th>
                                        <th>Priority</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    <?php
                                    foreach($datos as $rows){
                                    ?>
                                        <tr>
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input fs-15" type="checkbox" name="checkAll" value="option1">
                                                </div>
                                            </th>
                                            <td>01</td>
                                            <td><?=$rows['firstname'] . " " . $rows['lastname'];?></td>
                                            <td><?=$rows['user_id'];?></td>
                                            <td><?=$rows['email'];?></td>
                                            <td><?=$rows['tcarea']."-".$rows['tcnumber'];?></td>
                                            <td>Alexis Clarke</td>
                                            <td>Joseph Parker</td>
                                            <td>03 Oct, 2021</td>
                                            <td><span class="badge bg-info-subtle text-info">Re-open</span></td>
                                            <td><span class="badge bg-danger">High</span></td>
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
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- container-fluid -->
    </div><!-- End Page-content -->
</div>
