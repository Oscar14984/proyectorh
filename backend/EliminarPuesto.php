<?php
    require_once( './accesos.php');
    require_once( './classGetPostInDataBase.php');
    $mysql = new classGetPostInDataBase();
    $data = json_decode(file_get_contents("php://input"), true);
    $id_puesto = $data['id_puesto'];
    $query = 
    "DELETE FROM Puestos WHERE `Puestos`.`id_puesto` = ?";
    $values = [$id_puesto];
    $sql = $mysql->consulta_ca($query,$values);
?>