<?php

require_once '../../config/db.php';
require_once '../../helpers/utils.php';

$db = Database::connect();

header('Content-Type: application/json');
$departamento = $_POST['id'];
$sql = "SELECT * FROM `ciudades` WHERE departamento_id = $departamento";
$consulta = $db->query($sql);
$array = array();
$i=0;
while ($fila = $consulta->fetch_assoc()) {
    $array[$i] = $fila;
    $i++;
}
$json = json_encode($array);
print_r($json);
