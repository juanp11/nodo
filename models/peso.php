<?php
class Peso
{
    private $id;
    private $peso;

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

    public function getPeso()
    {
        return $this->peso;
    }

    public function setPeso($peso)
    {
        $this->peso = $peso;
        return $this;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM `pesocaja` ORDER BY `id` ASC";
        $consulta = $this->db->query($sql);
        return $consulta;
    }
}
