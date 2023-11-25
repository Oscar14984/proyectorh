<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";

    $insertInDataBase = new classGetPostInDataBase();
    $jsonPuestoData = json_decode(file_get_contents("php://input"), true);
    try{
        $titulo = $jsonPuestoData["titulo"];
        $desripcion = $jsonPuestoData["descripcion"];
        $fecha_limite = $jsonPuestoData["fecha_limite"];
        $lugar = $jsonPuestoData["lugar"];

        $requisitos = json_decode($jsonPuestoData["requisitos"]);
        echo var_dump($requisitos) . "<br>";
        $ofrecemos = $jsonPuestoData["ofrecemos"];
        $funcionesGenerales = $jsonPuestoData["funciones_generales"];
        $habilidadesConocimientos = $jsonPuestoData["habilidades_conocimientos"];

        $queryInsertPuesto = "INSERT INTO Puestos(titulo,descripcion,fecha_limite,lugar) VALUES (?,?,?)";
        $valuesInsertPuesto = array($titulo,$desripcion,$fecha_limite,$lugar);
        //$insertInDataBase->consulta_ca($queryInsertPuesto,$valuesInsertPuesto);

        $queryConsultaGeneral = "SELECT * FROM Puestos pu WHERE pu.titulo = ? AND pu.descripcion = ? AND pu.fecha_limite = ? AND pu.lugar = ?";
        $valuesSearchPuesto = array($titulo,$desripcion,$fecha_limite,$lugar);
        $getDataPuesto = $insertInDataBase->consulta_ca($queryConsultaGeneral,$valuesSearchPuesto);
        $dataPuesto = array();
        while($row = $getDataPuesto->fetch_assoc()) {
            array_unshift($dataPuesto,array($row["id_puesto"],$row["titulo"],$row["descripcion"],$row["fecha_limite"],$row["lugar"]));
        }
        $dataPuesto = $dataPuesto[0];
        $idPuesto = (int)$dataPuesto[0];
        /*

        $queryInsertRequisito = "INSERT INTO Requisitos(id_puesto,descripcion) VALUES (?,?)";
        foreach ($requisitos as $requisito) {
            $valuesRequisito = array($idPuesto,$requisito);
            $insertInDataBase->consulta_ca($queryInsertRequisito,$valuesRequisito);
        }

        $queryInsertOfrecemos= "INSERT INTO Ofrecemos(id_puesto,descripcion) VALUES (?,?)";
        foreach ($ofrecemos as $ofrecemo) {
            $valuesOfrecemos = array($idPuesto,$ofrecemo);
            $insertInDataBase->consulta_ca($queryInsertOfrecemos,$valuesOfrecemos);
        }

        $queryInsertFuncionesGenerales = "INSERT INTO FuncionesGenerales(id_puesto,descripcion) VALUES (?,?)";
        foreach ($funcionesGenerales as $funcionGeneral) {
            $valuesFuncionesGenerales= array($idPuesto,$funcionGeneral);
            $insertInDataBase->consulta_ca($queryInsertFuncionesGenerales,$valuesFuncionesGenerales);
        }

        $queryInsertHabilidadesConocimientos = "INSERT INTO HabilidadesConocimientos(id_puesto,descripcion) VALUES (?,?)";
        foreach ($habilidadesConocimientos as $habilidadConocimiento) {
            $valuesHabilidadesConocimientos = array($idPuesto,$habilidadConocimiento);
            $insertInDataBase->consulta_ca($queryInsertHabilidadesConocimientos,$valuesHabilidadesConocimientos);
        }*/

        $_POST["estado"] = true;
    }catch(Exception $e){
        $_POST["estado"] = false;
    }
    $insertInDataBase->dbDisconnect();
?>