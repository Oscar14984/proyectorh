<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    $jsonDataPuesto = json_decode(file_get_contents("php://input"), true);

    $idPuesto = $jsonDataPuestos["id_puesto"];
    $queryDeletePuesto = "DELETE FROM Puestos pu WHERE pu.id_puesto = ?";
    $queryDeleteRequisitos = "DELETE FROM Requisitos re WHERE re.id_puesto = ?";
    $queryDeleteOfrecemos = "DELETE FROM Ofrecemos of WHERE of.id_puesto = ?";
    $queryDeleteFuncionesGenerales = "DELETE FROM FuncionesGenerales fg WHERE fg.id_puesto = ?";
    $queryDeleteHabilidadesConocimientos = "DELETE FROM HabilidadesConocimientos hc WHERE hc.id_puesto = ?";

    $insertarEnBaseDatos = new classGetPostInDataBase();
    $values = array((int)$idPuesto);
    $insertarEnBaseDatos->consulta_ca($queryDeletePuesto,$values);
    $insertarEnBaseDatos->consulta_ca($queryDeleteRequisitos,$values);
    $insertarEnBaseDatos->consulta_ca($queryDeleteOfrecemos,$values);
    $insertarEnBaseDatos->consulta_ca($queryDeleteFuncionesGenerales,$values);
    $insertarEnBaseDatos->consulta_ca($queryDeleteHabilidadesConocimientos,$values);

    $insertarEnBaseDatos->dbDisconnect();
?>