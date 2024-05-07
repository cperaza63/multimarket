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

echo "Vista= " . $_GET['views'];

?>

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

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
        if((!isset($_SESSION['id']) || $_SESSION['id']=="") || (!isset($_SESSION['usuario']) || $_SESSION['usuario']=="")){
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
        
        if(isset($_GET['views']) && $_GET['views']!=""){
            if( $_GET['views'] == "userList.../"){
                ?><script src="<?php echo APP_URL; ?>app/views/js/ajaxSinSwall.js" ></script><?php
            }else{
                ?><script src="<?php echo APP_URL; ?>app/views/js/ajax.js" ></script><?php
            }
            ?><script src="<?php echo APP_URL; ?>app/views/js/ajax.js" ></script><?php
        }else{
            ?><script src="<?php echo APP_URL; ?>app/views/js/ajax.js" ></script><?php
        }
        ?>
</body>
</html>