<?php
    /*
    Back End que prepara todo para poder hacer la descarga de un video en el Front End de la pagina.
    Entradas:
    1.- id_video : int, Numero de la id del video que queremos descargar
    Salidas:
    1.- response : json, Este json contiene un apuntador llamado "d" que apunta a otro array que contiene la "localidad" del archivo en el servidor temporal
    y un "nombre" que contiene el nombre normal del archivo para poder descargarlo.
    */
    //Importamos los accesos para poder mandar informacion del front al back
    require_once "accesos.php";
    //Clases que nos permiten tener accesos a la base de datos y a drop box
    require_once "classGetPostInDataBase.php";
    require_once "classInsertInDropBox.php";
    //Variable que contiene las entradas al Back End
    $jsonDataVideo = json_decode(file_get_contents("php://input"), true);
    //Creamos los objetos para poder acceder a las bases de datos
    $insertarEnBaseDatos = new classGetPostInDataBase();
    $insertarEnDropBox = new classInsertInDropBox();
    //Id del documento que queremos descargar
    $idVideo = (int)$jsonDataVideo["id_video"];

    //Query para obtener la informacion del documento deseado
    $queryDownloadVideo = "SELECT * FROM Videos vid WHERE vid.id_video = ?";
    //Array que contiene el id para poder sustuir los signos de interrogacion del query
    $values = array($idVideo);
    //Obtenemos el documento relacionado con el id del documento
    $videoInformation = $insertarEnBaseDatos->consulta_ca($queryDownloadVideo,$values);
    //Extraemos la información de la consulta
    $infoVideos = array();
    $localPath = getcwd();
    while($row = $videoInformation->fetch_assoc()){
        array_push($infoVideos,(array("id_video"=>$row["id_video"],"id_usuario"=>$row["id_usuario"],"mime"=>$row["mime"],"file_name"=>$row["file_name"],"localidad"=>$row["localidad"],"fase"=>$row["fase"])));
    }
    //Mandamos el archivo hacia el path temporal del servidor
    $filename = pathinfo($infoVideos[0]["localidad"], PATHINFO_FILENAME);
    $temp = tempnam(sys_get_temp_dir(), $filename);
    $infoVideo = $infoVideos[0];
    $pathVideo = $infoVideo["localidad"];
    $file = $insertarEnDropBox->download($pathVideo);
    $contents = $file->getContents();
    file_put_contents($temp, $contents);
    //Devolvemos la localidad y el nombre del archivo en un array
    $response = array();
    $response["d"] = array("localidad"=>str_replace('\\', '/',$temp),"nombre"=>$filename);
    echo json_encode($response);
    //Desconectamos la base de datos
    $insertarEnBaseDatos->dbDisconnect();
?>