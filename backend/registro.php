<?php
require_once "accesos.php";
require_once "classGetPostInDataBase.php";

$mysql = new classGetPostInDataBase();
    $data = json_decode(file_get_contents("php://input"), true);
    $nombre = $data['nombre'];
    $apellido_paterno = $data['apellido_paterno'];
    $apellido_materno = $data['apellido_materno'];
    $correo= $data['correo'];
    $numero = $data['numero'];
    $contrasena = $data['contrasena'];
    $claveEncriptada = password_hash($contrasena, PASSWORD_DEFAULT);
    $foto = $data['foto'];
    $query=
    "INSERT INTO `Usuario`(`nombre`,`apellido_paterno`,`apellido_materno`, `correo`,`numero`,`contrasena`, `foto`) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $values = [$nombre,$apellido_paterno,$apellido_materno,$correo,$numero,$claveEncriptada,$foto];
    $sql = $mysql->consulta_ca($query,$values);
    $row = $sql->fetch_assoc();
    $sql = $mysql->consulta_ca($query,$values);
?>
    