<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    $insertarEnBaseDatos = new classGetPostInDataBase();
    $queryGetAdminUsuarios = "SELECT * FROM AdminUsuario";
    $dataUsuariosAdmin = $insertarEnBaseDatos->consulta_sa($queryGetAdminUsuarios);

    $jsonDataUsuariosAdmin = array();

    if ($dataUsuariosAdmin->num_rows > 0) {
        while($row = $dataUsuariosAdmin->fetch_assoc()){
            array_unshift($jsonDataUsuariosAdmin,array("id_usuario"=>$row["id_usuario"],
            "nombre"=>$row["nombre"],
            "apellido_paterno"=>$row["apellido_paterno"],
            "apellido_materno"=>$row["apellido_materno"],
            "correo"=>$row["correo"],"numero"=>$row["numero"],
            "contrasena"=>$row["contrasena"],
            "foto"=>$row["foto"]));
        }
        // $response = json_encode(array("d"=>$jsonDataUsuariosAdmin));
        $response['d']=json_encode(array("jsonDataUsuariosAdmin"=>$jsonDataUsuariosAdmin));
        echo json_encode($response);
    }else{
        //En caso de tener una respuesta incorrecta tiramos todo
        $response = json_encode(array("d" => array()));
        echo $response;
    }
    $insertarEnBaseDatos->dbDisconnect();
?>