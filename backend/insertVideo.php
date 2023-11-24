<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    require_once "classInsertInDropBox.php";

    $insertarEnDropBox = new classInsertInDropBox();
    $insertarEnBaseDatos = new classGetPostInDataBase();
    $dataVideo = json_decode(file_get_contents("php://input"), true);

    $id_usuario = $_FILES['file']['tmp_name'];
    $video_name = $_FILES['file']['name'];
    $localVideoPath = dirname($video_name);
    $video_name = basename($video_name);
    $mime = pathinfo($video_name, PATHINFO_EXTENSION);
    $fase = $dataVideo["fase"];
    $localidad = "/".$fase."/".$video_name;


    $queryInsertVideo = "INSERT INTO Videos(id_usuario,mime,file_name,localidad,fase) VALUES(?,?,?,?,?)";
    $values = array($id_usuario,$mime,$video_name,$localVideoPath,$fase);
    $insertarEnBaseDatos->consulta_ca($queryInsertVideo,$values);

    $insertarEnDropBox->createFolderDropBox("/".$fase,$id_usuario);
    $insertarEnDropBox->post($localVideoPath,$video_name,"/".$fase."/".$id_usuario,"video_fase_".$fase."_usuario_".$id_usuario.".".$mime);
?>