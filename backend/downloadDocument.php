<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    require_once "classInsertInDropBox.php";
    $jsonDataDocument= json_decode(file_get_contents("php://input"), true);
    $id_usuario = $jsonDataDocument["id_usuario"];
    $fase = $jsonDataDocument["fase"];
    $localDocumentPath = $jsonDataDocument["localDOcumentPath"];

    $queryGetDocument = "SELECT * FROM Documentos doc WHERE doc.id_usuario = ? AND doc.fase";
    $valuesGetDocument = array($id_usuario,$fase);

    $insertarEnBaseDatos = new classGetPostInDataBase();
    $insertarEnDropBox = new classInsertInDropBox();

    $dataDocumento = $insertarEnBaseDatos->consulta_ca($valuesGetDocument);

    $dataDocumentArray = array();

    if ($dataDocumento->num_rows > 0) {
        while($row = $dataDocumento->fetch_assoc()) {
            array_push($dataDocumentArray,array($row["id_usuario"],$row["mime"],$row["file_name"],$row["localidad"],$row["fase"]));
        }
    }else{
        //En caso de tener una respuesta incorrecta tiramos todo
        die("Usuario no registrado");
    }
    $dataDocumentArray = $dataDocumentArray[0];
    $insertarEnDropBox->download($dataDocumentArray[3],$localDocumentPath);
?>