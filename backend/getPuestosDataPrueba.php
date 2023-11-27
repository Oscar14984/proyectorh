<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";

    $queryGetPustosData = "SELECT * FROM Puestos";
    $insertarEnBaseDatos = new classGetPostInDataBase();
    $getPuestosData = $insertarEnBaseDatos->consulta_sa($queryGetPustosData);

    $jsonDataPuestos = array();

    if ($getPuestosData->num_rows > 0) {
        while($row = $getPuestosData->fetch_assoc()) {
            //Requisitos
            $queryRequisitos = "SELECT * FROM Requisitos re WHERE re.id_puesto = ?";
            $values = array((int)$row["id_puesto"]);
            $result = $insertarEnBaseDatos->consulta_ca($queryRequisitos,$values);
            $arrayRequisitos = array();
            while($row = $result->fetch_assoc()){
                array_push($arrayRequisitos,json_encode(array("id"=>$row["id"],"linea"=>$row["descripcion"])));
            }
            //Ofrecemos
            $queryOfrecemos = "SELECT * FROM Ofrecemos of WHERE of.id_puesto = ?";
            $values = array((int)$row["id_puesto"]);
            $result = $insertarEnBaseDatos->consulta_ca($queryOfrecemos,$values);
            $arrayOfrecemos= array();
            while($row = $result->fetch_assoc()){
                array_push($arrayOfrecemos,json_encode(array("id"=>$row["id"],"linea"=>$row["descripcion"])));
            }
            //FuncionesGenerales
            $queryFuncionesGenerales = "SELECT * FROM FuncionesGenerales fg WHERE fg.id_puesto = ?";
            $values = array((int)$row["id_puesto"]);
            $result = $insertarEnBaseDatos->consulta_ca($queryFuncionesGenerales,$values);
            $arrayFuncionesGenerales = array();
            while($row = $result->fetch_assoc()){
                array_push($arrayFuncionesGenerales,json_encode(array("id"=>$row["id"],"linea"=>$row["descripcion"])));
            }
            //HabilidadesConocimientos
            $queryHabilidadesConocimientos = "SELECT * FROM HabilidadesConocimientos hc WHERE hc.id_puesto = ?";
            $values = array((int)$row["id_puesto"]);
            $result = $insertarEnBaseDatos->consulta_ca($queryHabilidadesConocimientos,$values);
            $arrayHabilidadesGenerales = array();
            while($row = $result->fetch_assoc()){
                array_push($arrayHabilidadesGenerales,json_encode(array("id"=>$row["id"],"linea"=>$row["descripcion"])));
            }
            $jsonPuesto= array("id_puesto" => $row["id_puesto"],
                            "titulo" => $row["titulo"],
                            "descripcion" => $row["descripcion"],
                            "fecha_limite" => $row["fecha_limite"],
                            "lugar" => $row["lugar"],
                            "requisitos" => json_encode($arrayRequisitos),
                            "ofrecemos" => json_encode($arrayOfrecemos),
                            "funcionesGenerales" => json_encode($arrayFuncionesGenerales),
                            "habilidadesConocimientos" => json_encode($arrayHabilidadesGenerales));
            $jsonPuesto = json_encode($jsonPuesto);
            array_unshift($jsonDataPuestos,$jsonPuesto);
            //array_push($jsonDataPuestos,array($row["id_puesto"],$row["titulo"],$row["descripcion"],$row["fecha_limite"],$row["lugar"],array("requisitos",$arrayRequisitos),array("ofrecemos",$arrayOfrecemos),array("funcionesGenerales",$arrayFuncionesGenerales)));
        }

        $jsonSalida = json_encode($jsonDataPuestos);
        $_POST["dataPuestos"] = $jsonSalida;
    }else{
        //En caso de tener una respuesta incorrecta tiramos todo
        $_POST["dataPuestos"] = false;
    }
    $insertarEnBaseDatos->dbDisconnect();
?>