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
    if ($res = $mysqli -> query("SELECT * FROM control WHERE unidad=$q AND 
    estatus=1 and tipo='market_cat' ORDER BY nombre")) {
    ?>
        
        <?php while($fila=mysqli_fetch_array($res)){ ?>
        <option value="<?php echo $fila['control_id']; ?>" <?php if($c==$fila['control_id'])echo "selected"; ?>>
        <?php echo $fila['nombre']==""?"Seleccione Categoria": $fila['nombre']; ?></option>
        <?php } ?>

        
    <?php
    }
    ?> 