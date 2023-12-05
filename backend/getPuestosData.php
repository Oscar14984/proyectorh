<?php
    /*
    Back que obtiene la informacion de todos los puestos registrados en la base de datos
    Entradas :
    Ninguna
    Salidas :
    1.- array : Este array va a contener la informacion de cada uno de los puestos, pero este tambien va a tener adentro mas array con strings con los requisitos, oferta, funciones generales etc.
    */
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";

    //Query que obtiene la informacion de todos los puestos
    $queryGetPustosData = "SELECT * FROM Puestos";
    //Creamos el objeto que contiene los metodo para acceder a la base de datos
    $insertarEnBaseDatos = new classGetPostInDataBase();
    //Obtenermos la informacion de todos los puesto
    $getPuestosData = $insertarEnBaseDatos->consulta_sa($queryGetPustosData);

    $jsonDataPuestos = array();

    if ($getPuestosData->num_rows > 0) {
        while($rowPuesto = $getPuestosData->fetch_assoc()) {
            /*
            En caso de los array dinamicos de los requisitos, oferta, habiliades conocimeintos, funciones generales, vamos a 
            iterar en cada uno de ellos para poder ingresar su informacion en array independientes para pdoer entregarlos al front end
            */
            //Requisitos
            $queryRequisitos = "SELECT * FROM Requisitos re WHERE re.id_puesto = ?";
            $values = array((int)$row["id_puesto"]);
            $result = $insertarEnBaseDatos->consulta_ca($queryRequisitos,$values);
            $arrayRequisitos = array();
            while($row = $result->fetch_assoc()){
                array_push($arrayRequisitos,array("id"=>$row["id"],"linea"=>$row["descripcion"]));
            }
            //Ofrecemos
            $queryOfrecemos = "SELECT * FROM Ofrecemos of WHERE of.id_puesto = ?";
            $values = array((int)$row["id_puesto"]);
            $result = $insertarEnBaseDatos->consulta_ca($queryOfrecemos,$values);
            $arrayOfrecemos= array();
            while($row = $result->fetch_assoc()){
                array_push($arrayOfrecemos,array("id"=>$row["id"],"linea"=>$row["descripcion"]));
            }
            //FuncionesGenerales
            $queryFuncionesGenerales = "SELECT * FROM FuncionesGenerales fg WHERE fg.id_puesto = ?";
            $values = array((int)$row["id_puesto"]);
            $result = $insertarEnBaseDatos->consulta_ca($queryFuncionesGenerales,$values);
            $arrayFuncionesGenerales = array();
            while($row = $result->fetch_assoc()){
                array_push($arrayFuncionesGenerales,array("id"=>$row["id"],"linea"=>$row["descripcion"]));
            }
            //HabilidadesConocimientos
            $queryHabilidadesConocimientos = "SELECT * FROM HabilidadesConocimientos hc WHERE hc.id_puesto = ?";
            $values = array((int)$row["id_puesto"]);
            $result = $insertarEnBaseDatos->consulta_ca($queryHabilidadesConocimientos,$values);
            $arrayHabilidadesGenerales = array();
            while($row = $result->fetch_assoc()){
                array_push($arrayHabilidadesGenerales,array("id"=>$row["id"],"linea"=>$row["descripcion"]));
            }
            //Al interar en cada unos de los array dinamicos guardamos este array en un array mas grande 
            $jsonPuesto= array("id_puesto" => $rowPuesto["id_puesto"],
                            "titulo" => $rowPuesto["titulo"],
                            "descripcion" => $rowPuesto["descripcion"],
                            "fecha_limite" => $rowPuesto["fecha_limite"],
                            "lugar" => $rowPuesto["lugar"],
                            "pais" => $rowPuesto["pais"],
                            "doctor_solicitante" => $rowPuesto["doctor_solicitante"],
                            "requisitos" => $arrayRequisitos,
                            "ofrecemos" => $arrayOfrecemos,
                            "funcionesGenerales" => $arrayFuncionesGenerales,
                            "habilidadesConocimientos" => $arrayHabilidadesGenerales);
            array_unshift($jsonDataPuestos,$jsonPuesto);
        }
        //Volvemos el array en un json y lo mandamos al front
        $jsonSalida = $jsonDataPuestos;
        $response['d']=json_encode(array("jsonSalida"=>$jsonSalida));
        echo json_encode($response);
    }else{
        //En caso de tener una respuesta vacia devolvemos un array vacio
        $response = json_encode(array("d" => array()));
        echo $response;
    }
    $insertarEnBaseDatos->dbDisconnect();
?>

