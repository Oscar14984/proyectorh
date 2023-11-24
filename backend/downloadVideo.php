<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    require_once "classInsertInDropBox.php";
    $jsonDataVideo = json_decode(file_get_contents("php://input"), true);
    $id_usuario = $jsonDataVideo["id_usuario"];
    $fase = $jsonDataVideo["fase"];
    $localVideoPath = $jsonDataVideo["localVideoPath"];

    $queryGetVideo = "SELECT * FROM Videos vid WHERE vid.id_usuario = ? AND vid.fase";
    $valuesGetVideo = array($id_usuario,$fase);

    $insertarEnBaseDatos = new classGetPostInDataBase();
    $insertarEnDropBox = new classInsertInDropBox();

    $dataVideo = $insertarEnBaseDatos->consulta_ca($valuesGetVideo);

    $dataVideoArray = array();

    if ($dataVideo->num_rows > 0) {
        while($row = $dataVideo->fetch_assoc()) {
            array_push($dataVideoArray,array($row["id_usuario"],$row["mime"],$row["file_name"],$row["localidad"],$row["fase"]));
        }
    }else{
        //En caso de tener una respuesta incorrecta tiramos todo
        die("Usuario no registrado");
    }
    $dataVideoArray = $dataVideoArray[0];
    $insertarEnDropBox->download($dataVideoArray[3],$localVideoPath);
?>