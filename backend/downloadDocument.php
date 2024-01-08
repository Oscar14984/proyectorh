<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    require_once "classInsertInDropBox.php";
    $jsonDataDocument = json_decode(file_get_contents("php://input"), true);
    $insertarEnBaseDatos = new classGetPostInDataBase();
    $insertarEnDropBox = new classInsertInDropBox();
    $id_documento = (int)$jsonDataDocument["id_documento"];

    $queryDownloadDocument = "SELECT * FROM Documentos doc WHERE doc.id_doc = ?";
    $values = array($id_documento);
    $documentInformation = $insertarEnBaseDatos->consulta_ca($queryDownloadDocument,$values);
    $infoDocument = array();
    while($row = $documentInformation->fetch_assoc()){
        array_push($infoDocument,json_decode(array("id_doc"=>$row["id_doc"],"id_usuario"=>$row["id_usuario"],"mime"=>$row["mime"],"file_name"=>$row["file_name"],"localidad"=>$row["localidad"],"fase"=>$row["fase"])));
    }
    $filename = pathinfo($infoDocument[0]["localidad"], PATHINFO_FILENAME);
    $temp = tempnam(sys_get_temp_dir(), $filename);
    $infoDocument = $infoDocument[0];
    $pathDocument = $infoDocument["localidad"];
    $file = $insertarEnDropBox->download($pathDocument);
    $contents = $file->getContents();
    file_put_contents($temp, $contents);
    
    $response["d"] = array("localidad"=>$temp,"nombre"=>$filename);
    echo json_encode($response);
    // $_POST["document_info"] = json_encode(array("localidad"=>$temp,"nombre"=>$filename));
    $insertarEnBaseDatos->dbDisconnect();
?>