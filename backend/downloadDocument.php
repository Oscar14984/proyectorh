<?php
    /*
    Back end que prepara el servidor para poder descargar documentos pdf, docx, etc. Usando
    la nube y la base de datos de SQL.
    Entradas:
    1.- id_document : int, ID del documento que vamos a querer eliminar
    Salida:
    1.- response : json, Este json contiene un apuntador llamado "d" que apunta a otro array que contiene la "localidad" del archivo en el servidor temporal
    y un "nombre" que contiene el nombre normal del archivo para poder descargarlo.
    */
    //Importamos los accesos para poder mandar informacion del front al back
    require_once "accesos.php";
    //Clases que nos permiten tener accesos a la base de datos y a drop box
    require_once "classGetPostInDataBase.php";
    require_once "classInsertInDropBox.php";
    //Variable que contiene las entradas al Back End
    $jsonDataDocument = json_decode(file_get_contents("php://input"), true);
    //Creamos los objetos para poder acceder a las bases de datos
    $insertarEnBaseDatos = new classGetPostInDataBase();
    $insertarEnDropBox = new classInsertInDropBox();
    //Id del documento que queremos descargar
    $idDocument = (int)$jsonDataDocument["id_documento"];

    //Query para obtener la informacion del documento deseado
    $queryDownloadDocument = "SELECT * FROM Documentos doc WHERE doc.id_doc = ?";
    //Array que contiene el id para poder sustuir los signos de interrogacion del query
    $values = array($idDocument);
    //Obtenemos el documento relacionado con el id del documento
    $documentInformation = $insertarEnBaseDatos->consulta_ca($queryDownloadDocument,$values);
    //Extraemos la información de la consulta
    $infoDocument = array();
    while($row = $documentInformation->fetch_assoc()){
        array_push($infoDocument,array("id_doc"=>$row["id_doc"],"id_usuario"=>$row["id_usuario"],"mime"=>$row["mime"],"file_name"=>$row["file_name"],"localidad"=>$row["localidad"],"fase"=>$row["fase"]));
    }
    //Mandamos el archivo hacia el path temporal del servidor
    $filename = pathinfo($infoDocument[0]["localidad"], PATHINFO_FILENAME);
    $temp = tempnam(sys_get_temp_dir(), $filename);
    $infoDocument = $infoDocument[0];
    $pathDocument = $infoDocument["localidad"];
    $file = $insertarEnDropBox->download($pathDocument);
    $contents = $file->getContents();
    file_put_contents($temp, $contents);
    //Devolvemos la localidad y el nombre del archivo en un array
    $response = array();
    $response["d"] = array("localidad"=>$temp,"nombre"=>$filename);
    echo json_encode($response);
    //Desconectamos la base de datos
    $insertarEnBaseDatos->dbDisconnect();
?>