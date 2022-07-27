<?php
class Departamentos
{
    private $id;
    private $departametos;

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

    public function getDepartametos()
    {
        return $this->departametos;
    }
    
    public function setDepartametos($departametos)
    {
        $this->departametos = $departametos;
        return $this;
    }

    public function getAll()
    {
        $departamentos = $this->db->query("SELECT * FROM `departamentos` ORDER BY `id` ASC");
        return $departamentos;
    }
}
