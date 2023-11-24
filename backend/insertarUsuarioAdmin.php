<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    require_once "classInsertInDropBox.php";
    $insertarEnDropBox = new classInsertInDropBox();
    $insertarEnBaseDatos = new classGetPostInDataBase();
    if(!empty($_FILES)){
        $dataDocument = json_decode(file_get_contents("php://input"), true);
        $locDocumentDropBox = $_FILES['file']['tmp_name'];
        $documentName = $_FILES['file']['name'];
        $documentExten = explode(".",$documentName);
        $documentExten = end($documentExten);
        $idUsuario = $_POST["idUsuario"];
        $values = array($idUsuario,$documentExten,"documento_cv_usuario_".$idUsuario.".".$documentExten,"/documentos/documento_cv_usuario_".$idUsuario.".".$documentExten,"inicial");
        $queryInsertDocuments = "INSERT INTO Documentos(id_usuario,mime,file_name,localidad,fase) VALUES (?,?,?,?,?)";
        $insertarEnBaseDatos->consulta_ca($queryInsertDocuments,$values);
        $insertarEnDropBox->post(dirname($locDocumentDropBox),basename($locDocumentDropBox),"/documentos","documento_cv_usuario_".$idUsuario.".".$documentExten);
        $_POST["estado"] = true;
    }else{
        $_POST["estado"] = false;
    }
?>