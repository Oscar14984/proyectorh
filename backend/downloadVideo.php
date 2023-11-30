<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    require_once "classInsertInDropBox.php";
    $jsonDataVideo = json_decode(file_get_contents("php://input"), true);
    $insertarEnBaseDatos = new classGetPostInDataBase();
    $insertarEnDropBox = new classInsertInDropBox();
    $idVideo = (int)$jsonDataVideo["id_video"];

    $queryDownloadVideo = "SELECT * FROM Videos vid WHERE vid.id_video = ?";
    $values = array($idVideo);
    $videoInformation = $insertarEnBaseDatos->consulta_ca($queryDownloadVideo,$values);
    $infoVideos = array();
    while($row = $videoInformation->fetch_assoc()){
        array_push($infoVideos,(array("id_video"=>$row["id_video"],"id_usuario"=>$row["id_usuario"],"mime"=>$row["mime"],"file_name"=>$row["file_name"],"localidad"=>$row["localidad"],"fase"=>$row["fase"])));
    }
    $filename = pathinfo($infoVideos[0]["localidad"], PATHINFO_FILENAME);
    $temp = tempnam(sys_get_temp_dir(), $filename);
    $infoVideo = $infoVideos[0];
    $pathVideo = $infoVideo["localidad"];
    $file = $insertarEnDropBox->download($pathVideo);
    $contents = $file->getContents();
    file_put_contents($temp, $contents);
    // $_POST["video_info"] = json_encode(array("localidad"=>$temp,"nombre"=>$filename));
    $response['d']=array("localidad"=>$temp,"nombre"=>$filename);
    echo json_encode($response);
    $insertarEnBaseDatos->dbDisconnect();
?>