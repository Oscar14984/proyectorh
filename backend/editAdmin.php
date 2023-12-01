<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    $insertarEnBaseDatos = new classGetPostInDataBase();

    $queryUpdateAdmin = "UPDATE AdminUsuario ad SET ad.nombre = ?, ad.apellido_paterno = ?, apellido_materno = ?, ad.correo = ?, ad.numero = ?, ad.contrasena = ? WHERE ad.id_usuario = ?";
    

    $dataDocument = json_decode(file_get_contents("php://input"), true);

    $nombre = $dataDocument["nombre"];
    $apellido_paterno = $dataDocument["apellido_paterno"];
    $apellido_materno = $dataDocument["apellido_materno"];
    $correo = $dataDocument["correo"];
    $numero = $dataDocument["numero"];
    $contrasena = $dataDocument["contrasena"];
    $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
    $idUsuario = $dataDocument["id_usuario"];
    $values = array($nombre,$apellido_paterno,$apellido_materno,$correo,$numero,$contrasena(int)$idUsuario);
    $insertarEnBaseDatos->consulta_ca($queryUpdateAdmin,$values);


    $insertarEnBaseDatos->dbDisconnect();
?>