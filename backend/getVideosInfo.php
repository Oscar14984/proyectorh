<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    $jsonDataVideo = json_decode(file_get_contents("php://input"), true);
    $queryGetVideos = "SELECT * FROM Videos vid WHERE vid.id_usuario = ?";
    $insertarEnBaseDatos = new classGetPostInDataBase();
    
    $id_usuario = $jsonDataVideo["id_usuario"];
    $values = array((int)$id_usuario);
    $getDataVideos = $insertarEnBaseDatos->consulta_ca($queryGetVideos,$values);
    $infoVideos = array();
    while($row = $getDataVideos->fetch_assoc()){
        array_push($infoVideos,(array("id_video"=>$row["id_video"],"id_usuario"=>$row["id_usuario"],"mime"=>$row["mime"],"file_name"=>$row["file_name"],"localidad"=>$row["localidad"],"fase"=>$row["fase"])));
    }
    // $_POST["dataVideo"] = json_encode($infoVideos);
    $response['d']=json_encode(array("infoVideos"=>$infoVideos));
    echo json_encode($response);
?>