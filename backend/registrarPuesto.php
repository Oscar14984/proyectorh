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

        $requisitos = json_decode($jsonPuestoData["requisitos"], true);
        $ofrecemos = json_decode($jsonPuestoData["ofrecemos"], true);
        $funcionesGenerales = json_decode($jsonPuestoData["funciones_generales"], true);
        $habilidadesConocimientos = json_decode($jsonPuestoData["habilidades_conocimientos"], true);

        $queryInsertPuesto = "INSERT INTO Puestos(titulo,descripcion,fecha_limite,lugar) VALUES (?,?,?,?)";
        $valuesInsertPuesto = array($titulo,$desripcion,$fecha_limite,$lugar);
        $insertInDataBase->consulta_ca($queryInsertPuesto,$valuesInsertPuesto);

        $queryConsultaGeneral = "SELECT * FROM Puestos pu WHERE pu.titulo = ? AND pu.descripcion = ? AND pu.fecha_limite = ? AND pu.lugar = ?";
        $valuesSearchPuesto = array($titulo,$desripcion,$fecha_limite,$lugar);
        $getDataPuesto = $insertInDataBase->consulta_ca($queryConsultaGeneral,$valuesSearchPuesto);
        $dataPuesto = array();
        echo "<script>console.log('Esta es la info de la data Puesto:', " . json_encode($dataPuesto) . ");</script>";
        while($row = $getDataPuesto->fetch_assoc()) {
            array_unshift($dataPuesto,array($row["id_puesto"],$row["titulo"],$row["descripcion"],$row["fecha_limite"],$row["lugar"]));
        }

        $dataPuesto = $dataPuesto[0];
        $idPuesto = (int)$dataPuesto[0];
        // Insertar requisito
        $queryInsertRequisito = "INSERT INTO Requisitos(id_puesto,descripcion) VALUES (?,?)";
        if (is_array($requisitos)) {
            foreach ($requisitos as $requisito) {
                $requisito = json_decode($requisito, true); // Decodificar la cadena JSON
                $valuesRequisito = array($idPuesto, $requisito);
                $insertInDataBase->consulta_ca($queryInsertRequisito, $valuesRequisito);
            }
        } else {
            echo "Error: \$requisitos no es un array.";
        }
        // Insertar Ofrecemos
        $queryInsertOfrecemos = "INSERT INTO Ofrecemos(id_puesto,descripcion) VALUES (?,?)";
        if (is_array($ofrecemos)) {
            foreach ($ofrecemos as $ofrecemo) {
                $ofrecemo = json_decode($ofrecemo, true);
                $valuesOfrecemos = array($idPuesto, $ofrecemo);
                $insertInDataBase->consulta_ca($queryInsertOfrecemos, $valuesOfrecemos);
            }
        } else {
            echo "Error: \$ofrecemos no es un array.";
        }

        // Insertar Funciones Generales
        $queryInsertFuncionesGenerales = "INSERT INTO FuncionesGenerales(id_puesto,descripcion) VALUES (?,?)";
        if (is_array($funcionesGenerales)) {
            foreach ($funcionesGenerales as $funcionGeneral) {
                $funcionGeneral = json_decode($funcionGeneral, true);
                $valuesFuncionesGenerales = array($idPuesto, $funcionGeneral);
                $insertInDataBase->consulta_ca($queryInsertFuncionesGenerales, $valuesFuncionesGenerales);
            }
        } else {
            echo "Error: \$funcionesGenerales no es un array.";
        }

        // Insertar Habilidades y Conocimientos
        $queryInsertHabilidadesConocimientos = "INSERT INTO HabilidadesConocimientos(id_puesto,descripcion) VALUES (?,?)";
        if (is_array($habilidadesConocimientos)) {
            foreach ($habilidadesConocimientos as $habilidadConocimiento) {
                $habilidadConocimiento = json_decode($habilidadConocimiento, true);
                $valuesHabilidadesConocimientos = array($idPuesto, $habilidadConocimiento);
                $insertInDataBase->consulta_ca($queryInsertHabilidadesConocimientos, $valuesHabilidadesConocimientos);
            }
        } else {
            echo "Error: \$habilidadesConocimientos no es un array.";
        }

        $_POST["estado"] = true;
    }catch(Exception $e){
        $_POST["estado"] = false;
    }
    $insertInDataBase->dbDisconnect();
?>