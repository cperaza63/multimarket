<?php
    $q=$_GET['q'];
    $c=$_GET['c'];
    $mysqli = new mysqli("localhost","root","","multimarket");

    // Check connection
    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }
    // Perform query
    if ($res = $mysqli -> query("SELECT * FROM company_categorias WHERE unidad=$q AND 
    estatus=1 ORDER BY nombre")) {
    ?>
        <option value="">Escoja una opción</option>
        <?php while($fila=mysqli_fetch_array($res)){ ?>
        <option value="<?php echo $fila['categoria_id']; ?>" <?php if($c==$fila['categoria_id'])echo "selected"; ?>>
        <?php echo $fila['nombre']==""?"Seleccione Subcategoria": $fila['nombre']; ?></option>
        <?php } ?>

        
    <?php
    }
    ?> 