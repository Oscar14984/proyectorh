<?php
    require_once('./classGetPostInDataBase.php');
    require_once('./accesos.php');
    $mysql = new classGetPostInDataBase;
    $data = json_decode(file_get_contents("php://input"), true);
    $id_relacion = $data['$id_relacion'];
    $query = "DELETE FROM `relacionusuariopuesto` WHERE `id_relacion` = ?";
    $values = [$id_relacion];
    $sql = $mysql->consulta_ca($query,$values);
?>
