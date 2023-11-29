<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    $insertarEnBaseDatos = new classGetPostInDataBase();

    $queryUpdatePuesto = "UPDATE Puestos pu SET pu.titulo = ?, pu.descripcion = ?, fecha_limite = ?, pu.lugar = ? WHERE pu.id_puesto = ?";
    $queryUpdateRequisitosGenerales = "UPDATE Requisitos re SET re.descripcion = ? WHERE re.id = ?";
    $queryUpdateOfrecemos = "UPDATE Ofrecemos of SET of.descripcion = ? WHERE of.id = ?";
    $queryUpdateFuncionesGenerales = "UPDATE FuncionesGenerales fg SET fg.descripcion = ? WHERE fg.id = ?";
    $queryUpdateHabilidadesConocimientos = "UPDATE HabilidadesConocimientos hc SET hc.descripcion = ? WHERE hc.id = ?";

    $dataDocument = json_decode(file_get_contents("php://input"), true);

    $titulo = $dataDocument["titulo"];
    $descripcion = $dataDocument["descripcion"];
    $fechaLimite = $dataDocument["fecha_limite"];
    $lugar = $dataDocument["lugar"];
    $idPuesto = $dataDocument["id_puesto"];
    $requisitos = $dataDocument["requisitos"];
    $ofrecemos = $dataDocument["ofrecemos"];
    $funcionesGenerales = $dataDocument["funciones_generales"];
    $habilidadesConocimientos = ($dataDocument["habilidades_conocimientos"]);
    $values = array($titulo,$descripcion,$fechaLimite,$lugar,(int)$idPuesto);
    $insertarEnBaseDatos->consulta_ca($queryUpdatePuesto,$values);

    foreach ($requisitos as $requisito) {
        $id = $requisito["id"];
        $req = $requisito["linea"];
        $valuesRequisito = array($req,$id);
        $insertarEnBaseDatos->consulta_ca($queryUpdateRequisitosGenerales,$valuesRequisito);
    }

    foreach ($ofrecemos as $ofrece) {
        $id = $ofrece["id"];
        $ofer = $ofrece["linea"];
        $valuesOferta = array($ofer,$id);
        $insertarEnBaseDatos->consulta_ca($queryUpdateOfrecemos,$valuesOferta);
    }

    foreach ($funcionesGenerales as $funcion) {
        $id = $funcion["id"];
        $fun = $funcion["linea"];
        $valuesFuncionGeneral = array($fun,$id);
        $insertarEnBaseDatos->consulta_ca($queryUpdateFuncionesGenerales,$valuesFuncionGeneral);
    }

    foreach ($habilidadesConocimientos as $habCon) {
        $id = $habCon["id"];
        $hab = $habCon["linea"];
        $valuesHabilidadConocimiento = array($hab,$id);
        $insertarEnBaseDatos->consulta_ca($queryUpdateHabilidadesConocimientos,$valuesHabilidadConocimiento);
    }
    $insertarEnBaseDatos->dbDisconnect();
?>