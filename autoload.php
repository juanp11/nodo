<?php

function controllers_autoload($clase){
    $clase = str_replace('\\', DIRECTORY_SEPARATOR, $clase);
    include 'controllers/'.$clase.'.php';
}

spl_autoload_register('controllers_autoload');
?>