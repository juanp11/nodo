<?php

class Pedido
{
    private $id;
    private $nombrecompleto;
    private $direccion;
    private $departamento_id;
    private $ciudad_id;
    private $costo;
    private $status;
    private $fecha;
    private $pesocaja;
    private $valorasegurado;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getNombrecompleto()
    {
        return $this->nombrecompleto;
    }

    public function setNombrecompleto($nombrecompleto)
    {
        $this->nombrecompleto = $this->db->real_escape_string($nombrecompleto);
        return $this;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $this->db->real_escape_string($direccion);
        return $this;
    }

    public function getDepartamento_id()
    {
        return $this->departamento_id;
    }

    public function setDepartamento_id($departamento_id)
    {
        $this->departamento_id = $departamento_id;
        return $this;
    }


    public function getCiudad_id()
    {
        return $this->ciudad_id;
    }

    public function setCiudad_id($ciudad_id)
    {
        $this->ciudad_id = $ciudad_id;
        return $this;
    }

    public function getCosto()
    {
        return $this->costo;
    }

    public function setCosto($costo)
    {
        $this->costo = $costo;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    public function getPesocaja()
    {
        return $this->pesocaja;
    }

    public function setPesocaja($pesocaja)
    {
        $this->pesocaja = $pesocaja;
        return $this;
    }

    public function getValorasegurado()
    {
        return $this->valorasegurado;
    }

    public function setValorasegurado($valorasegurado)
    {
        $this->valorasegurado = $valorasegurado;
        return $this;
    }

    public function getAll()
    {
        $start = $this->getId();
        $sql = "SELECT p.id, p.nombrecompleto AS nombre,p.direccion,d.departamento, c.ciudad FROM `pedidos` p INNER JOIN departamentos d on d.id = p.departamento_id INNER join ciudades c on c.id = p.ciudad_id ORDER BY `id` DESC LIMIT $start,10 ";
        $consulta = $this->db->query($sql);
        return $consulta;
    }

    public function paginacion()
    {
        $sql = "SELECT COUNT(*) AS totalpedidos FROM `pedidos`";
        $consulta = $this->db->query($sql);
        $resultado = $consulta->fetch_assoc();
        $totalFilas = $resultado['totalpedidos'];
        return $totalFilas;
    }

    public function getDepartamento()
    {
        $departamento_id = $this->getDepartamento_id();
        $ciudad_id = $this->getCiudad_id();

        $sql = "SELECT d.`departamento`, c.`ciudad` FROM `departamentos` d INNER JOIN `ciudades` c on c.departamento_id = d.id WHERE d.id = $departamento_id AND c.id= $ciudad_id";
        $consulta = $this->db->query($sql);
        $departamento = $consulta->fetch_object();
        return $departamento;
    }

    public function Ticket()
    {
        $nombrecompleto = $this->getNombrecompleto();
        $direccion = $this->getDireccion();
        $departamento_id = $this->getDepartamento_id();
        $ciudad_id = $this->getCiudad_id();
        $pesocaja = $this->getPesocaja();
        $valorasegurado = $this->getValorasegurado();
        $costo = $this->getCosto();
        $sql = "INSERT INTO `pedidos`(`nombrecompleto`, `direccion`, `departamento_id`, `ciudad_id`, `costo`, `status`, `fecha`, `pesocaja`, `valorasegurado`) VALUES ('$nombrecompleto','$direccion',$departamento_id,$ciudad_id,'$costo','En Confirmacion',NOW(),$pesocaja,'$valorasegurado')";
        $consulta= $this->db->query($sql);
        if ($consulta) {
            $result = true;
        }else{
            $result = false;
        }

        return $result;
    }

    public function delete()
    {
        $id = $this->getId();

        $sql = "DELETE FROM `pedidos` WHERE `id`=$id";
        $delete = $this->db->query($sql);

        if ($delete) {
            $result = true;
        }else {
            $result = false;
        }

        return $result;
    }

    public function getOne()
    {
        $id = $this->getId();
        $sql = "SELECT p.*,d.departamento, c.ciudad FROM `pedidos` p INNER JOIN departamentos d on d.id = p.departamento_id INNER join ciudades c on c.id = p.ciudad_id WHERE p.id = $id";
        $consulta = $this->db->query($sql);
        $pedido = $consulta->fetch_object();
        return $pedido;
    }

    public function TicketEdit()
    {
        $id = $this->getId();
        $nombrecompleto = $this->getNombrecompleto();
        $direccion = $this->getDireccion();
        $departamento_id = $this->getDepartamento_id();
        $ciudad_id = $this->getCiudad_id();
        $pesocaja = $this->getPesocaja();
        $valorasegurado = $this->getValorasegurado();
        $costo = $this->getCosto();
        $sql = "UPDATE `pedidos` SET `nombrecompleto`='$nombrecompleto',`direccion`='$direccion',`departamento_id`=$departamento_id,`ciudad_id`=$ciudad_id,`costo`='$costo',`status`='En Confirmacion',`fecha`=NOW(),`pesocaja`=$pesocaja,`valorasegurado`='$valorasegurado' WHERE `id`= $id";
        $update= $this->db->query($sql);
        if ($update) {
            $result = true;
        }else{
            $result = false;
        }

        return $result;
    }
}
