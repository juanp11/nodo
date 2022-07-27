<?php
session_start();
require_once 'autoload.php';
require_once 'config/db.php';
require_once 'controllers/errorcontroller.php';
require_once 'config/parameters.php';
require_once 'helpers/utils.php';
require_once 'views/layout/header.php';

function show_error(){
    $error = new ErrorController();
    $error->index();
}

if(isset($_GET['controller'])){
    $nombreControlador = $_GET['controller'].'controller';
}elseif (!isset($_GET['controller'])) {
    $nombreControlador = controller_default;
}else {
    show_error();   
    exit();
}

if(class_exists($nombreControlador)){
    $controlador = new $nombreControlador();
    if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
        $action = $_GET['action'];
        $controlador->$action();
    }elseif (!isset($_GET['action'])) {
        $actionDefault = action_default;
        $controlador->$actionDefault();
    }else{
        show_error();
    }
}else{
    show_error();
}


require_once 'views/layout/footer.php';

?>