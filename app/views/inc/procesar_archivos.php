<?php
//print_r($_FILES);
$num_archivos=count($_FILES['archivo']['name']);
$ruta_dir = $_SERVER['DOCUMENT_ROOT']."/multimarket/app/views/fotos/control/";
for ($i=0; $i < $num_archivos; $i++) {
    if( !empty( $_FILES['archivo']['name'][$i] ) ){
        $ruta_nueva = $ruta_dir . $_FILES['archivo']['name'][$i];
        if(file_exists($ruta_nueva)){
            echo "El archivo " . $_FILES['archivo']['name'][$i] . " ya existe en el servidor<br>";
        }else{
            $ruta_temporal = $_FILES['archivo']['tmp_name'][$i];
            move_uploaded_file($ruta_temporal, $ruta_nueva);
            echo "El archivo " . $_FILES['archivo']['name'][$i] . " se subio de manera exitosa<br>";
        }
    }
}