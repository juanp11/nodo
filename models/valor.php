<?php
class Valor
{
    private $id;
    private $valor;

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

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM `valorasegurado` ORDER BY `id` ASC";
        $consulta = $this->db->query($sql);
        return $consulta;
    }
}
