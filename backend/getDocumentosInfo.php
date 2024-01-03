<?php
require_once "accesos.php";
require_once "classGetPostInDataBase.php";

// para obtener la solicitud POST en JSON
$jsonDataDocumentos = json_decode(file_get_contents("php://input"), true);

// Consulta SQL 
$queryGetDocumentos = "SELECT * FROM documentos doc WHERE doc.id_usuario = ?";
$insertarEnBaseDatos = new classGetPostInDataBase();

// Obtener el id_usuario 
$id_usuario = $jsonDataDocumentos["id_usuario"];

$values = array((int)$id_usuario);

$getDataDocumentos = $insertarEnBaseDatos->consulta_ca($queryGetDocumentos, $values);

$rsDocumentos = array();

// Recorrer los resultados y guardarlos en el array $rsDocumentos
while ($row = $getDataDocumentos->fetch_assoc()) {
    array_push($rsDocumentos, array(
        "id_doc" => $row["id_doc"],
        "id_usuario" => $row["id_usuario"],
        "mime" => $row["mime"],
        "file_name" => $row["file_name"],
        "localidad" => $row["localidad"],
        "fase" => $row["fase"]
    ));
}

// Crear la respuesta JSON con los resultados
$response['d'] = json_encode(array("rsDocumentos" => $rsDocumentos));

echo json_encode($response);
?>