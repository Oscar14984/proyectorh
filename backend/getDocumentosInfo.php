<?php
require_once "accesos.php";
require_once "classGetPostInDataBase.php";

// para obtener la solicitud POST en JSON
$mysql = new classGetPostInDataBase();
$data = json_decode(file_get_contents("php://input"), true);

// Obtener el id_usuario 
$id_usuario = $data["id_usuario"];


// Consulta SQL 
$query = 
"SELECT
    Documentos.id_doc, 
    Documentos.id_usuario, 
    Documentos.mime, 
    Documentos.file_name, 
    Documentos.localidad, 
    Documentos.fase
FROM 
    Documentos
WHERE
    Documentos.id_usuario = ?";

$values = array((int)$id_usuario);
$sql = $mysql->consulta_ca($query, $values);

$rsDocumentos = array();

// Recorrer los resultados y guardarlos en el array $rsDocumentos
while ($row = $sql->fetch_assoc()) {
    array_push($rsDocumentos, array(
        "id_doc" => $row["id_doc"],
        "id_usuario" => $row["id_usuario"],
        "mime" => $row["mime"],
        "file_name" => $row["file_name"],
        "localidad" => $row["localidad"],
        "fase" => $row["fase"]
    ));
};

// Crear la respuesta JSON con los resultados
$response['d'] = json_encode(array("rsDocumentos" => $rsDocumentos));

echo json_encode($response);
?>