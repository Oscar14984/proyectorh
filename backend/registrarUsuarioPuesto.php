<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    $dataRelacionJson = json_decode(file_get_contents("php://input"), true);
    
    $id_usuario = $dataRelacionJson["id_usuario"];
    $id_puesto = $dataRelacionJson["id_puesto"];

    $queryRegistro = "INSERT INTO RelacionUsuarioPuesto(id_usuario,id_puesto) VALUES (?,?)";
    $valuesRegistroRelacion = array($id_usuario,$id_puesto);
    $insertarEnBaseDatos = new classGetPostInDataBase();

    $insertarEnBaseDatos->consulta_ca($queryRegistro,$valuesRegistroRelacion);
    
?>