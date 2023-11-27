<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    $insertInDataBase = new classGetPostInDataBase();
    $jsonAdminoData = json_decode(file_get_contents("php://input"), true);

    $queryInsertAdmin = "INSERT INTO AdminUsuario(nombre,apellido_paterno,apellido_materno,correo,numero,contrasena,foto) VALUES (?,?,?,?,?,?,?)";
    $nombre = $jsonAdminoData["nombre"];
    $apellido_paterno = $jsonAdminoData["apellido_paterno"];
    $apellido_materno = $jsonAdminoData["apellido_materno"];
    $correo = $jsonAdminoData["correo"];
    $numero = $jsonAdminoData["numero"];
    $contrasena = $jsonAdminoData["contrasena"];
    $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
    $foto = "/fotos_perfiles/foto_general_perfil.jpg";
    $queryCheck = "SELECT * FROM AdminUsuario us WHERE us.correo = '".$correo."'";
    $correoRepCon = $insertarEnBaseDatos->consulta_sa($queryCheck);
    if ($correoRepCon->num_rows > 0) {
        echo "repetido";
        $_POST["estado"] = false;
    }else{
        $values = array($nombre,$apellido_paterno,$apellido_materno,$correo,$numero,$contrasena,$foto);
        $insertInDataBase->consulta_ca($queryInsertAdmin,$values);
        $_POST["estado"] = true;
    }
?>