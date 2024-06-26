<?php

require_once "./config/app.php";
require_once "./autoload.php"; 
/*---------- Iniciando sesion ----------*/
require_once "./app/views/inc/session_start.php";
// guardo los parametros de la url
$_SESSION['view']= "";
if(isset($_GET['views'])){
    $url=explode("/", $_GET['views']);
    $_SESSION['view']= $_GET['views'];
}else{
    $url=["login"];
}
//print_r($_SESSION['view']);
?>
<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" 
data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <?php 
    require_once "./app/views/inc/head.php";
    ?>
</head>
<body>
    <?php
        use app\controllers\viewsController;
        use app\controllers\loginController;
        $insLogin = new loginController;
        $viewsController= new viewsController();
        $vista=$viewsController->obtenerVistasControlador($url[0]);
        if($vista=="login" || $vista=="404"){
            require_once "./app/views/content/".$vista."-view.php";
        }else{
            ?>
            <main class="page-container">
            <?php
            # Cerrar sesion desde aqui #
            if((!isset($_SESSION['id']) || $_SESSION['id']=="") 
            || (!isset($_SESSION['usuario']) || $_SESSION['usuario']=="")){
                $insLogin->cerrarSesionControlador();
                exit();
            }
            ?>      
                <section class="full-width pageContent scroll" id="pageContent">
                    <?php
                        
                        require_once "./app/views/inc/navlateral.php";
                        require_once $vista;
                        require_once "./app/views/inc/barra-final.php";
                        //require_once "./app/views/inc/navbar.php";
                    ?>
                </section>
            </main>
        <?php
        }
        require_once "./app/views/inc/footer.php";
        require_once "./app/views/inc/script.php";
        // recuerda el tab de las pestañas
        // desativamos el ajax para hacer prueas
        $a=0;
        if ($a == 0){
            if(isset($_GET['views']) && $_GET['views']!=""){
                if( $_GET['views'] == "userList/" || $_GET['views'] == "ubicacionList/"
                 || $_GET['views'] == "categoryList/" || $_GET['views'] == "subcatList/"
                 || $_GET['views'] == "cuponList/" || $_GET['views'] == "marcaList/"  
                 || $_GET['views'] == "modeloList/" || $_GET['views'] == "proveedorList/" 
                 || $_GET['views'] == "clienteList/" || $_GET['views'] == "despachadorList/" 
                 || $_GET['views'] == "productCompra/" || $_GET['views'] == "ecommerceOrdenes-view.php"
                ){
                    ?><script src="<?php echo APP_URL; ?>app/views/js/ajaxSinSwall.js" ></script><?php
                }else{
                    ?><script src="<?php echo APP_URL; ?>app/views/js/ajax.js" ></script><?php
                }
            }else{
                ?><script src="<?php echo APP_URL; ?>app/views/js/app.js"></script><?php
            }
            // Se debe colocar el controlador que usara AJAX
        }

        if(isset($_GET['views']) && $_GET['views']!=""){
            if( substr($_GET['views'], 0, 11) == "userUpdate/"
                || substr($_GET['views'], 0, 8) == "userNew/"
                || substr($_GET['views'], 0, 11) == "companyNew/"
                || substr($_GET['views'], 0, 14) == "companyUpdate/"
                || substr($_GET['views'], 0, 13) == "proveedorNew/"
                || substr($_GET['views'], 0, 16) == "proveedorUpdate/"
                || substr($_GET['views'], 0, 15) == "despachadorNew/"
                || substr($_GET['views'], 0, 18) == "despachadorUpdate/"
                || substr($_GET['views'], 0, 11) == "clienteNew/"
                || substr($_GET['views'], 0, 14) == "clienteUpdate/"
                || substr($_GET['views'], 0, 11) == "controlNew/"
                || substr($_GET['views'], 0, 14) == "controlUpdate/"
                || substr($_GET['views'], 0, 12) == "categoryNew/"
                || substr($_GET['views'], 0, 15) == "categoryUpdate/"
                || substr($_GET['views'], 0, 9) == "marcaNew/"
                || substr($_GET['views'], 0, 12) == "marcaUpdate/"
                || substr($_GET['views'], 0, 9) == "cuponNew/"
                || substr($_GET['views'], 0, 12) == "cuponUpdate/"
                || substr($_GET['views'], 0, 11) == "productNew/"
                || substr($_GET['views'], 0, 14) == "productUpdate/"
                || substr($_GET['views'], 0, 14) == "productCompra/"
            ){
                ?><script src="<?php echo APP_URL; ?>app/views/js/ajax_edo.js"></script><?php
            }else{
                ?><script src="<?php echo APP_URL; ?>app/views/js/app.js"></script><?php
            }
        }else{
            ?><script src="<?php echo APP_URL; ?>app/views/js/app.js"></script><?php
        }
        ?>
</body>
</html>