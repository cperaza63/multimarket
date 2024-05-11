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
    if ($res = $mysqli -> query("SELECT * FROM ubicacion WHERE state_abbreviation<>'' AND 
    state_abbreviation='$q' ORDER BY city")) {
    ?>
        
        <?php while($fila=mysqli_fetch_array($res)){ ?>
        <option value="<?php echo $fila['id']; ?>" <?php if($c==$fila['id'])echo "selected"; ?>>
        <?php echo $fila['city']==""?"Seleccione Ciudad": $fila['city']; ?></option>
        <?php } ?>

        
    <?php
    }
    ?> 