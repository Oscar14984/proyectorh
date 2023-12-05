<?php
    /*
    Codigo que inserta un puesto de manera dinamica
    Entrada : 
    1.- titulo : str
    2.- descripcion : str
    3.- fecha_limite : str
    4.- lugar : str
    5.- pais : str
    6.- doctor_solicitante : str
    7.- requisitos : array, con str adentro
    8.- ofrecemos : array, con str adentro
    9.- funciones_generales : array, con str adentro
    10.- habilidades_conocimintos : array, con str adentro
    Salida : 
    Ninguna
    */
    require_once "accessos.php";
    require_once "classGetPostInDataBase.php";

    $insertInDataBase = new classGetPostInDataBase();
    $jsonPuestoData = json_decode(file_get_contents("php://input"), true);
    try{
        //Informacion general del puesto
        $titulo = $jsonPuestoData["titulo"];
        $desripcion = $jsonPuestoData["descripcion"];
        $fecha_limite = $jsonPuestoData["fecha_limite"];
        $lugar = $jsonPuestoData["lugar"];
        $pais = $jsonPuestoData["pais"];
        $doctorSolicitante = $jsonPuestoData["doctor_solicitante"];

        //Array con str dinamicos
        $requisitos = $jsonPuestoData["requisitos"];
        $ofrecemos = $jsonPuestoData["ofrecemos"];
        $funcionesGenerales = $jsonPuestoData["funciones_generales"];
        $habilidadesConocimientos = $jsonPuestoData["habilidades_conocimientos"];

        //Insertamos informacion general del puesto
        $queryInsertPuesto = "INSERT INTO Puestos(titulo,descripcion,fecha_limite,lugar,pais,doctor_solicitante) VALUES (?,?,?,?,?,?)";
        $valuesInsertPuesto = array($titulo,$desripcion,$fecha_limite,$lugar,$pais,$doctorSolicitante);
        $insertInDataBase->consulta_ca($queryInsertPuesto,$valuesInsertPuesto);

        //Obtenemos id autogenerada del puesto
        $queryConsultaGeneral = "SELECT * FROM Puestos pu WHERE pu.titulo = ? AND pu.descripcion = ? AND pu.fecha_limite = ? AND pu.lugar = ?";
        $valuesSearchPuesto = array($titulo,$desripcion,$fecha_limite,$lugar);
        $getDataPuesto = $insertInDataBase->consulta_ca($quertConsultaGeneral,$valuesSearchPuesto);
        $dataPuesto = array();
        while($row = $getDataPuesto->fetch_assoc()) {
            array_unshift($dataPuesto,array($row["id_puesto"],$row["titulo"],$row["descripcion"],$row["fecha_limite"],$row["lugar"]));
        }
        $dataPuesto = $dataPuesto[0];
        $idPuesto = (int)$dataPuesto[0];
        
        //Interamos dentro de los array para insertar cada uno dentro de las tablas para guardar los requisitos dinamicos
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
        }

        $_POST["estado"] = true;
    }catch(Exception $e){
        $_POST["estado"] = false;
    }
    $insertInDataBase->dbDisconnect();
?>