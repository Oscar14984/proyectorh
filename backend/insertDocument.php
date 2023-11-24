<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    require_once "classInsertInDropBox.php";
    $dataDocument = json_decode(file_get_contents("php://input"), true);

    $id_usuario = $_FILES['file']['tmp_name'];
    $document_name = $_FILES['file']['name'];
    $localDocumentPath = dirname($document_name);
    $document_name = basename($document_name);
    $mime = pathinfo($document_name, PATHINFO_EXTENSION);
    $fase = $dataDocument["fase"];
    $localidad = "/".$fase."/".$document_name;

    $insertarEnDropBox = new classInsertInDropBox();
    $insertarEnBaseDatos = new classGetPostInDataBase();

    $queryInsertDocumento = "INSERT INTO Documentos(id_usuario,mime,file_name,localidad,fase) VALUES(?,?,?,?,?)";
    $values = array($id_usuario,$mime,$document_name,$localDocumentPath,$fase);
    $insertarEnBaseDatos->consulta_ca($queryInsertDocumento,$values);

    $insertarEnDropBox->createFolderDropBox("/".$fase,$id_usuario);
    $insertarEnDropBox->post($localDocumentPath,$document_name,"/".$fase."/".$id_usuario,"documento_fase_".$fase."_usuario_".$id_usuario.".".$mime);
?>