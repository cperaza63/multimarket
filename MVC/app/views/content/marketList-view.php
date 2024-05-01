<div class="container is-fluid mb-6">
	<h1 class="title">Market Place</h1>
	<h2 class="subtitle"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de Market Place</h2>
    
    <a href="<?php echo APP_URL; ?>marketNew/">
	<button class="button is-primary">Agregar Market Place</button>
	</a>

</div>
<div class="container pb-6 pt-6 ml-2 mr-2">

	<div class="form-rest mb-6 mt-6"></div>

	<?php
		use app\controllers\marketController;

		$insProducto = new marketController();

		echo $insProducto->listarMarketControlador($url[1],10,$url[0],"",0);
	?>
</div>