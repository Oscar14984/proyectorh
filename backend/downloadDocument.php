 <?php
 /*
 Back End que prepara todo para poder hacer la descarga de un video en el Front End de la pagina.
 Entradas:
 1.- id_doc : int, Numero de la id del video que queremos descargar
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
 $jsonDataDocumento = json_decode(file_get_contents("php://input"), true);
 //Creamos los objetos para poder acceder a las bases de datos
 $insertarEnBaseDatos = new classGetPostInDataBase();
 $insertarEnDropBox = new classInsertInDropBox();
 //Id del documento que queremos descargar
 $id_doc = (int)$jsonDataDocumento["id_doc"];

 //Query para obtener la informacion del documento deseado
 $queryDownloadDocumento = "SELECT * FROM Documentos doc WHERE doc.id_doc = ?";
 //Array que contiene el id para poder sustuir los signos de interrogacion del query
 $values = array($id_doc);
 //Obtenemos el documento relacionado con el id del documento
 $DocumentoInformation = $insertarEnBaseDatos->consulta_ca($queryDownloadDocumento,$values);
 //Extraemos la información de la consulta
 $infoDocumento = array();
//  $localPath = getcwd();
 while($row = $DocumentoInformation->fetch_assoc()){
     array_push($infoDocumento,(array("id_doc"=>$row["id_doc"],"id_usuario"=>$row["id_usuario"],"mime"=>$row["mime"],"file_name"=>$row["file_name"],"localidad"=>$row["localidad"],"fase"=>$row["fase"])));
 }
 //Mandamos el archivo hacia el path temporal del servidor
 $filename = pathinfo($infoDocumento[0]["localidad"], PATHINFO_FILENAME);
 $temp = tempnam(sys_get_temp_dir(), $filename);
 $infoDocumento = $infoDocumento[0];
 $pathDocumento = $infoDocumento["localidad"];
 $file = $insertarEnDropBox->download($pathDocumento);
 $contents = $file->getContents();
 file_put_contents($temp, $contents);
 //Devolvemos la localidad y el nombre del archivo en un array
 $response = array();
//  $response["d"] = array("localidad"=>str_replace('\\', '/',$temp),"nombre"=>$filename);
 $response["d"] = array("localidad"=>$temp,"nombre"=>$filename);
 echo json_encode($response);
 //Desconectamos la base de datos
 $insertarEnBaseDatos->dbDisconnect();
    // require_once "accesos.php";
    // require_once "classGetPostInDataBase.php";
    // require_once "classInsertInDropBox.php";
    // $jsonDataDocument = json_decode(file_get_contents("php://input"), true);
    // $insertarEnBaseDatos = new classGetPostInDataBase();
    // $insertarEnDropBox = new classInsertInDropBox();
    // $id_doc = (int)$jsonDataDocument["id_doc"];

    // $queryDownloadDocument = "SELECT * FROM Documentos doc WHERE doc.id_doc = ?";
    // $values = array($id_doc);
    // $documentInformation = $insertarEnBaseDatos->consulta_ca($queryDownloadDocument,$values);
    // $infoDocument = array();
    // $localPath = getcwd();
    // while($row = $documentInformation->fetch_assoc()){
    //     array_push($infoDocument,json_decode(array("id_doc"=>$row["id_doc"],"id_usuario"=>$row["id_usuario"],"mime"=>$row["mime"],"file_name"=>$row["file_name"],"localidad"=>$row["localidad"],"fase"=>$row["fase"])));
    // }
    // $filename = pathinfo($infoDocument[0]["localidad"], PATHINFO_FILENAME);
    // $temp = tempnam(sys_get_temp_dir(), $filename);
    // $infoDocument = $infoDocument[0];
    // $pathDocument = $infoDocument["localidad"];
    // $file = $insertarEnDropBox->download($pathDocument);
    // $contents = $file->getContents();
    // file_put_contents($temp, $contents);
    
    // $response["d"] = array("localidad"=>$temp,"nombre"=>$filename);
    // echo json_encode($response);
    // $_POST["document_info"] = json_encode(array("localidad"=>$temp,"nombre"=>$filename));
    // $insertarEnBaseDatos->dbDisconnect();
?> 
