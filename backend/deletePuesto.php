<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    $jsonDataPuesto = json_decode(file_get_contents("php://input"), true);

    $idPuesto = $jsonDataPuesto["id_puesto"];
    $queryDeletePuesto = "DELETE FROM Puestos WHERE id_puesto = ?";
    $queryDeleteRequisitos = "DELETE FROM Requisitos WHERE id_puesto = ?";
    $queryDeleteOfrecemos = "DELETE FROM Ofrecemos WHERE id_puesto = ?";
    $queryDeleteFuncionesGenerales = "DELETE FROM FuncionesGenerales WHERE id_puesto = ?";
    $queryDeleteHabilidadesConocimientos = "DELETE FROM HabilidadesConocimientos WHERE id_puesto = ?";

    $insertarEnBaseDatos = new classGetPostInDataBase();
    $values = array((int)$idPuesto);
    $insertarEnBaseDatos->consulta_ca($queryDeletePuesto,$values);
    $insertarEnBaseDatos->consulta_ca($queryDeleteRequisitos,$values);
    $insertarEnBaseDatos->consulta_ca($queryDeleteOfrecemos,$values);
    $insertarEnBaseDatos->consulta_ca($queryDeleteFuncionesGenerales,$values);
    $insertarEnBaseDatos->consulta_ca($queryDeleteHabilidadesConocimientos,$values);

    $insertarEnBaseDatos->dbDisconnect();
?>