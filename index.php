<?php

require_once "./config/app.php";
require_once "./autoload.php"; 

/*---------- Iniciando sesion ----------*/
require_once "./app/views/inc/session_start.php";

if(isset($_GET['views'])){
    $url=explode("/", $_GET['views']);
}else{
    $url=["login"];
}

//echo "Vista= " . $_GET['views'];

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
                    //     require_once "./app/views/inc/navbar.php";
                    require_once "./app/views/inc/navlateral.php";
                    require_once $vista;
                    require_once "./app/views/inc/barra-final.php";
                ?>
            </section>
        </main>
        <?php
        }

        require_once "./app/views/inc/footer.php"; 
        require_once "./app/views/inc/script.php"; 
        
        // recuerda el tab de las pestañas
        
        // desativamos el ajax para hacer prueas
        $a=1;
        if ($a == 0){
            if(isset($_GET['views']) && $_GET['views']!=""){
                if( $_GET['views'] == "userList/" || $_GET['views'] == "ubicacionList/"){
                    ?><script src="<?php echo APP_URL; ?>app/views/js/ajaxSinSwall.js" ></script><?php
                }else{
                    ?><script src="<?php echo APP_URL; ?>app/views/js/ajax.js" ></script><?php
                }
            }else{
                ?><script src="http://localhost/multimarket/app/views/js/app.js"></script><?php
            }
            // Se debe colocar el controlador que usara AJAX
        }

        if(isset($_GET['views']) && $_GET['views']!=""){
            if( substr($_GET['views'], 0, 11) == "userUpdate/"
                || substr($_GET['views'], 0, 8) == "userNew/"
                || substr($_GET['views'], 0, 11) == "companyNew/"
                || substr($_GET['views'], 0, 14) == "companyUpdate/"
                || substr($_GET['views'], 0, 11) == "controlNew/"
                || substr($_GET['views'], 0, 14) == "controlUpdate/"
                || substr($_GET['views'], 0, 12) == "categoryNew/"
                || substr($_GET['views'], 0, 15) == "categoryUpdate/"
            ){
                ?><script src="http://localhost/multimarket/app/views/js/ajax_edo.js"></script><?php
            }else{
                ?><script src="http://localhost/multimarket/app/views/js/app.js"></script><?php
            }
        }else{
            ?><script src="http://localhost/multimarket/app/views/js/app.js"></script><?php
        }

        ?>
</body>
</html>