<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    $jsonDataVideo = json_decode(file_get_contents("php://input"), true);
    $queryGetVideos = "SELECT * FROM documentos doc WHERE doc.id_usuario = = ?";
    $insertarEnBaseDatos = new classGetPostInDataBase();
    
    $id_usuario = $jsonDataVideo["id_usuario"];
    $values = array((int)$id_usuario);
    $getDataDocumentos = $insertarEnBaseDatos->consulta_ca($queryGetVideos,$values);
    $rsDocumentos = array();
    while($row = $getDataDocumentos->fetch_assoc()){
        array_push($rsDocumentos,(array("id_doc"=>$row["id_doc"],"id_usuario"=>$row["id_usuario"],"mime"=>$row["mime"],"file_name"=>$row["file_name"],"localidad"=>$row["localidad"],"fase"=>$row["fase"])));
    }
    $response['d']=json_encode(array("rsDocumentos"=>$rsDocumentos));
    echo json_encode($response);
?>