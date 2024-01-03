<?php
require_once "accesos.php";
require_once "classGetPostInDataBase.php";

// Obtener los datos del cuerpo de la solicitud POST en JSON
$jsonDataDocumentos = json_decode(file_get_contents("php://input"), true);

// Consulta SQL para obtener los documentos de un usuario específico
$queryGetDocumentos = "SELECT * FROM documentos doc WHERE doc.id_usuario = ?";
$insertarEnBaseDatos = new classGetPostInDataBase();

// Obtener el id_usuario de los datos recibidos
$id_usuario = $jsonDataDocumentos["id_usuario"];

// Preparar los valores para la consulta
$values = array((int)$id_usuario);

// Ejecutar la consulta con la clase classGetPostInDataBase
$getDataDocumentos = $insertarEnBaseDatos->consulta_ca($queryGetDocumentos, $values);

// Inicializar un array para almacenar los resultados
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

// Enviar la respuesta JSON
echo json_encode($response);
?>