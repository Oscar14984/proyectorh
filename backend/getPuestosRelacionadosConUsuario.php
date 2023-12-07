<?php
    /*
    Obtiene las postulaciones de los usuarios con los diferentes puestos
    Entradas : 
    1.- id_usuario : int, id del numero de usuario del cual se quiere saber sus postulaciones
    Salidas : 
    1.- response : array que contiene la informacion de los puestos relacionados a un usuario
    */
    //Importamos los accessos y la clase que no permite ingresar a la base de datos
    require_once "classGetPostInDataBase.php";
    require_once "accesos.php";
    //Query que hace el join para obtener la informacion de las postulaciones
    $queryDataPuestosRelacionados = "SELECT * FROM RelacionUsuarioPuesto rpu LEFT JOIN Usuario us ON rpu.id_usuario = us.id_usuario 
                                    LEFT JOIN Puestos pu ON rpu.id_puesto = pu.id_puesto
                                    WHERE us.id_usuario = ?";
    //Variable que contiene todos los inputs del front al back                                
    $data = json_decode(file_get_contents("php://input"), true);
    //Id del usuario del cual queremos saber sus postulaciones
    $id_usuario = $data["id_usuario"];
    $valuesInsert = array((int)$id_usuario);

    $valuesData = array();
    //Creamos el objeto que contiene los metodos para acceder a la base de datos
    $insertarEnBaseDatos = new classGetPostInDataBase();
    //Obtenemos la informacion de las consultas
    $getDataRelacionUsuarioPuesto = $insertarEnBaseDatos->consulta_ca($queryDataPuestosRelacionados,$valuesInsert);
    //En caso de obtener al menos una fila
    if ($getDataRelacionUsuarioPuesto->num_rows > 0) {
        while($row = $getDataRelacionUsuarioPuesto->fetch_assoc()) {
            array_push($valuesData,array("id_puesto"=>$row["id_puesto"],"titulo"=>$row["titulo"],"descripcion"=>$row["descripcion"],"fecha_limite"=>$row["fecha_limite"]));
        }
        $jsonSalida = ($valuesData);
        $response = json_encode(array("d"=>$jsonSalida));
        echo $response;
        // $response['d']=json_encode(array("jsonSalida"=>$jsonSalida));
        // echo json_encode($response);
    }else{
        //En caso de obtener una tabla vacia
        $response = json_encode(array());
        echo $response;
    }
?>