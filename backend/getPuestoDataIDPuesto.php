<?php
    /*
    Obtiene las postulaciones de los usuarios usando el id del puesto
    Entradas : 
    1.- id_puesto: int, id del numero de puesto que vamos a ingresar
    Salidas : 
    1.- response : array que contiene la informacion de los usuarios con los puestos o pustulaciones
    */
    //Importamos los accessos y la clase que no permite ingresar a la base de datos
    require_once "classGetPostInDataBase.php";
    require_once "accesos.php";
    //Query que hace el join para obtener la informacion de las postulaciones
    $queryDataPuestosRelacionados = "SELECT * FROM RelacionUsuarioPuesto rpu LEFT JOIN Usuario us ON rpu.id_usuario = us.id_usuario 
                                    LEFT JOIN Puestos pu ON rpu.id_puesto = pu.id_puesto
                                    WHERE pu.id_puesto = ?";
    //Variable que contiene todos los inputs del front al back                                
    $data = json_decode(file_get_contents("php://input"), true);
    //Id del usuario del cual queremos saber sus postulaciones
    $id_puesto = $data["id_puesto"];
    $valuesInsert = array((int)$id_puesto);

    $valuesData = array();
    //Creamos el objeto que contiene los metodos para acceder a la base de datos
    $insertarEnBaseDatos = new classGetPostInDataBase();
    //Obtenemos la informacion de las consultas
    $getDataRelacionUsuarioPuesto = $insertarEnBaseDatos->consulta_ca($queryDataPuestosRelacionados,$valuesInsert);
    //En caso de obtener al menos una fila
    if ($getDataRelacionUsuarioPuesto->num_rows > 0) {
        while($row = $getDataRelacionUsuarioPuesto->fetch_assoc()) {
            array_push($valuesData,array("id_usuario"=>$row["id_usuario"],"nombre"=>$row["nombre"],"apellido_paterno"=>$row["apellido_paterno"],"apellido_materno"=>$row["apellido_materno"],"correo"=>$row["correo"],"numero"=>$row["numero"],"contrasena"=>$row["contrasena"],"foto"=>$row["foto"]));
        }
        $jsonSalida = ($valuesData);
        $response['d']=json_encode(array("jsonSalida"=>$jsonSalida));
        echo json_encode($response);
    }else{
        //En caso de obtener una tabla vacia
        $response = json_encode(array());
        echo $response;
    }

?>