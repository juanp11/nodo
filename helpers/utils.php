<?php

class Utils{
    public static function showDepartamentos()
    {
        require_once 'models/departamentos.php';
        $departamentos = new Departamentos();
        $departamentos =$departamentos->getAll();
        return $departamentos;
    }

    public static function getPedidos($start)
    {
        require_once 'models/pedidos.php';
        $pedidos = new Pedido();
        $pedidos->setId($start);
        $pedidos = $pedidos->getAll();
        return $pedidos;
    }

    public static function pesoCaja()
    {
        require_once 'models/peso.php';
        $peso = new Peso();
        $peso = $peso->getAll();
        return $peso;
    }

    public static function valorAsegurado()
    {
        require_once 'models/valor.php';
        $valor = new Valor();
        $valor = $valor->getAll();
        return $valor;
    }
}

?>