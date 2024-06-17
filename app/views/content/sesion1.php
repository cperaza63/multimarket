<?php
define('NOMBRE', "Edmundo");

$nombre = "Edmundo";

echo NOMBRE;

header("location: session2.php?nombre=$nombre");

if(isset($_REQUEST['nombre'])){
    echo $_REQUEST['nombre'];
}


session_start();

$_SESSION['nombre'] = "Edmundo";
echo $_SESSION['nombre'];

session_destroy();
session_unset($_SESSION['nombre']);
////////////////////////////////////

$_SESSION['carrito'][$producto]['codigo']= "1425";
$_SESSION['carrito'][$producto]['nombreProd']= "Coca Cola 0";
$_SESSION['carrito'][$producto]['cantidad']= 4;
$_SESSION['carrito'][$producto]['precio']= 4.25;

if(isset($_SESSION['carrito'])){
    foreach ($_SESSION['carrito'] as $indice => $arreglo) {
        $total += $arreglo['cantidad'] * $arreglo['precio'];
        foreach ($arreglo as $key => $value) {
            echo $key . ": " . $value . "<br>";
        }
        // los valores se cargan en una variavble de cantidad y producto
        echo "<a href='carrito.php?actualizar=$indice&cantidad=$value'>Eliminar item</a>";

        echo "<a href='carrito.php?borrar=$indice'>Eliminar item</a>";
    }    
}else{
    echo "El carrito esta vacio";
}

// vaqcvia el carrito
if($_REQUEST['vaciar']){
    session_destroy();
    HEADER("Location: carrito.php");
}
// elimino un item solo
if( isset($_REQUEST['borrar'])){
    $producto=$_REQUEST['borrar'];
    unset( $_SESSION['carrito'][$producto] );
    echo "<script>alert('Se elimino el producto $producto')</script>";
    HEADER("Location: carrito.php");
}

// actualizar cantidad del productio
if( isset($_REQUEST['actualizar'])){
    $producto = $_REQUEST['actualizar'];
    $cantidad = $_REQUEST['cantidad'];
    $_SESSION['carrito']['producto']['cantidad'] = 0;
    echo "<script>alert('Se elimino el producto $producto')</script>";
    HEADER("Location: carrito.php");
}

?>