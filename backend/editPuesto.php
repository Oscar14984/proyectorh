<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    $insertarEnBaseDatos = new classGetPostInDataBase();

    $queryUpdateRequisitosGenerales = "UPDATE Requisitos re SET re.descripcion = ? WHERE re.id = ?";
    $queryUpdateOfrecemos = "UPDATE Ofrecemos of SET of.descripcion = ? WHERE of.id = ?";
    $queryUpdateFuncionesGenerales = "UPDATE FuncionesGenerales fg SET fg.descripcion = ? WHERE fg.id = ?";
    $queryUpdateHabilidadesConocimientos = "UPDATE HabiliadesConocimientos hc SET hc.descripcion = ? WHERE hc.id = ?";

    $dataDocument = json_decode(file_get_contents("php://input"), true);

    $requisitos = json_decode($dataDocument["requisitos"]);
    $ofrecemos = json_decode($dataDocument["ofrecemos"]);
    $funcionesGenerales = json_decode($dataDocument["funciones_generales"]);
    $habilidadesConocimientos = json_decode($dataDocument["habilidades_conocimientos"]);

    foreach ($requisitos as $requisito) {
        $requisito = json_decode($requisito);
        $id = $requisito["id"];
        $req = $requisito["linea"];
        $valuesRequisito = array($req,$id);
        $insertInDataBase->consulta_ca($queryUpdateRequisitosGenerales,$valuesRequisito);
    }

    foreach ($ofrecemos as $ofrece) {
        $ofrece = json_decode($ofrece);
        $id = $ofrece["id"];
        $ofer = $ofrece["linea"];
        $valuesOferta = array($ofer,$id);
        $insertInDataBase->consulta_ca($queryUpdateRequisitosGenerales,$valuesOferta);
    }

    foreach ($funcionesGenerales as $funcion) {
        $funcionesGenerales = json_decode($funcion);
        $id = $funcion["id"];
        $fun = $funcion["linea"];
        $valuesRequisito = array($fun,$id);
        $insertInDataBase->consulta_ca($queryUpdateFuncionesGenerales,$valuesRequisito);
    }

    foreach ($habilidadesConocimientos as $habCon) {
        $habCon = json_decode($habCon);
        $id = $habCon["id"];
        $hab = $habCon["linea"];
        $valuesRequisito = array($hab,$id);
        $insertInDataBase->consulta_ca($queryUpdateHabilidadesConocimientos,$valuesRequisito);
    }
?>