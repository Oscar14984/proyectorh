<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";

    $queryGetPustosData = "SELECT * FROM Puestos";
    $insertarEnBaseDatos = new classGetPostInDataBase();
    $getPuestosData = $insertarEnBaseDatos->consulta_sa($queryGetPustosData);

    $jsonDataPuestos = array();

    if ($getPuestosData->num_rows > 0) {
        while($rowPuestos = $getPuestosData->fetch_assoc()) {
            //Requisitos
            $queryRequisitos = "SELECT * FROM Requisitos re WHERE re.id_puesto = ?";
            $values = array((int)$rowPuestos["id_puesto"]);
            $result = $insertarEnBaseDatos->consulta_ca($queryRequisitos,$values);
            $arrayRequisitos = array();
            while($row = $result->fetch_assoc()){
                array_push($arrayRequisitos,(array("id"=>$row["id"],"linea"=>$row["descripcion"])));
            }
            //Ofrecemos
            $queryOfrecemos = "SELECT * FROM Ofrecemos of WHERE of.id_puesto = ?";
            $values = array((int)$rowPuestos["id_puesto"]);
            $result = $insertarEnBaseDatos->consulta_ca($queryOfrecemos,$values);
            $arrayOfrecemos= array();
            while($row = $result->fetch_assoc()){
                array_push($arrayOfrecemos,(array("id"=>$row["id"],"linea"=>$row["descripcion"])));
            }
            //FuncionesGenerales
            $queryFuncionesGenerales = "SELECT * FROM FuncionesGenerales fg WHERE fg.id_puesto = ?";
            $values = array((int)$rowPuestos["id_puesto"]);
            $result = $insertarEnBaseDatos->consulta_ca($queryFuncionesGenerales,$values);
            $arrayFuncionesGenerales = array();
            while($row = $result->fetch_assoc()){
                array_push($arrayFuncionesGenerales,(array("id"=>$row["id"],"linea"=>$row["descripcion"])));
            }
            //HabilidadesConocimientos
            $queryHabilidadesConocimientos = "SELECT * FROM HabilidadesConocimientos hc WHERE hc.id_puesto = ?";
            $values = array((int)$rowPuestos["id_puesto"]);
            $result = $insertarEnBaseDatos->consulta_ca($queryHabilidadesConocimientos,$values);
            $arrayHabilidadesGenerales = array();
            while($row = $result->fetch_assoc()){
                array_push($arrayHabilidadesGenerales,(array("id"=>$row["id"],"linea"=>$row["descripcion"])));
            }
            $jsonPuesto= array("id_puesto" => $rowPuestos["id_puesto"],
                            "titulo" => $rowPuestos["titulo"],
                            "descripcion" => $rowPuestos["descripcion"],
                            "fecha_limite" => $rowPuestos["fecha_limite"],
                            "lugar" => $rowPuestos["lugar"],
                            "pais" => $rowPuestos["pais"],
                            "doctor_solicitante" => $rowPuestos["doctor_solicitante"],
                            "requisitos" => ($arrayRequisitos),
                            "ofrecemos" => ($arrayOfrecemos),
                            "funcionesGenerales" => ($arrayFuncionesGenerales),
                            "habilidadesConocimientos" => ($arrayHabilidadesGenerales));
            $jsonPuesto = ($jsonPuesto);
            // echo "<script>console.log('Esta es la info de la data Puesto:', " . json_encode($jsonPuesto) . ");</script>";
            array_unshift($jsonDataPuestos,$jsonPuesto);
            // array_push($jsonDataPuestos,array($row["id_puesto"],$row["titulo"],$row["descripcion"],$row["fecha_limite"],$row["lugar"],array("requisitos",$arrayRequisitos),array("ofrecemos",$arrayOfrecemos),array("funcionesGenerales",$arrayFuncionesGenerales)));
        }

        $jsonSalida = ($jsonDataPuestos);
        // echo "<script>console.log('Esta es la info de la data Puesto:', " . json_encode($jsonSalida) . ");</script>";
        $response['d']=json_encode(array("jsonSalida"=>$jsonSalida));
        echo json_encode($response);
        // $_POST["dataPuestos"] = $jsonSalida;
    }else{
        //En caso de tener una respuesta incorrecta tiramos todo
        $_POST["dataPuestos"] = false;
    }
    $insertarEnBaseDatos->dbDisconnect();
?>
