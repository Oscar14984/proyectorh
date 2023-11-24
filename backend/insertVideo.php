<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    require_once "classInsertInDropBox.php";
    $insertarEnDropBox = new classInsertInDropBox();
    $insertarEnBaseDatos = new classGetPostInDataBase();

    if(!empty($_FILES)){
        $dataVideo = json_decode(file_get_contents("php://input"), true);
        $locVideoDropBox = $_FILES['file']['tmp_name'];
        $videoName = $_FILES['file']['name'];
        $videoExten = explode(".",$videoName);
        $videoExten = end($videoExten);
        $idUsuario = $_POST["idUsuario"];
        $values = array($idUsuario,$videoExten,"video_presentacion_usuario_".$idUsuario.".".$videoExten,"/videos/video_presentacion_usuario_".$idUsuario.".".$videoExten,"inicial");
        $queryInsertVideo = "INSERT INTO Videos(id_usuario,mime,file_name,localidad,fase) VALUES(?,?,?,?,?)";
        $insertarEnBaseDatos->consulta_ca($queryInsertVideo,$values);
        $insertarEnDropBox->post(dirname($locVideoDropBox),basename($locVideoDropBox),"/videos","video_presentacion_usuario_".$idUsuario.".".$videoExten);
        $_POST["estado"] = true;
    }else{
        $_POST["estado"] = false;
    }
?>