<?php
// Autor: Leonardo Gracida Munoz
// Propiedad: Dental Network

// Importamos los headers de la página (si es necesario)
require_once 'accesos.php';

// Importamos la clase para administrar la base de datos
require_once 'classGetPostInDataBase.php';

// Importamos la clase para administrar la inserción y extracción de datos de Dropbox
require_once 'classInsertInDropBox.php';

// Función para responder al cliente con un mensaje JSON
function respond($message, $status) {
    $response = array('message' => $message, 'status' => $status);
    echo json_encode($response);
}

// Verificamos si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Convierte los datos JSON en un arreglo asociativo
    $jsonInformation = json_decode(file_get_contents("php://input"), true);

    // Verifica que se hayan recibido todos los campos requeridos
    if (isset($jsonInformation["nombre"]) &&
        isset($jsonInformation["apellido_paterno"]) &&
        isset($jsonInformation["apellido_materno"]) &&
        isset($jsonInformation["correo"]) &&
        isset($jsonInformation["numero"]) &&
        isset($jsonInformation["contrasena"]) &&
        isset($jsonInformation["image_path"]) &&
        isset($jsonInformation["calle"]) &&
        isset($jsonInformation["CP"]) &&
        isset($jsonInformation["Estado"]) &&
        isset($jsonInformation["Pais"]) &&
        isset($jsonInformation["Num_casa"])) {

        // Obtén los valores del JSON
        $nombre = $jsonInformation["nombre"];
        $apellido_paterno = $jsonInformation["apellido_paterno"];
        $apellido_materno = $jsonInformation["apellido_materno"];
        $correo = $jsonInformation["correo"];
        $numero = $jsonInformation["numero"];
        $contrasena = $jsonInformation["contrasena"];
        $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        $locFotoDropBox = $jsonInformation["image_path"];
        $locFotoDropBox = str_replace("/", DIRECTORY_SEPARATOR, $locFotoDropBox);
        $fotoExten = pathinfo($locFotoDropBox, PATHINFO_EXTENSION);
        $calle = $jsonInformation["calle"];
        $CP = $jsonInformation["CP"];
        $Estado = $jsonInformation["Estado"];
        $Pais = $jsonInformation["Pais"];
        $numero_casa = $jsonInformation["Num_casa"];

        // Checar si no hay un usuario ya ingresado en la base de datos.
        $correo_sin_espacios = trim($correo);
        $queryCheck = "SELECT * FROM Usuario us WHERE us.correo = " . "'" . $correo_sin_espacios . "'" . " AND us.numero = " . "'" . $numero . "'";
        $correoRepCon = $insertarEnBaseDatos->consulta_sa($queryCheck);
        if ($correoRepCon->num_rows > 0) {
            respond("repetido", false);
        } else {
            // Insertar en MySQL
            // Insertamos el usuario en la base de datos
            $values = array($nombre, $apellido_paterno, $apellido_materno, $correo, $numero, $contrasena, "pendiente");
            $insertarEnBaseDatos->consulta_ca($queryInsertUsuario, $values);
            // Consultamos la información del usuario recién ingresado para poder obtener el ID autogenerado
            $queryGet = "SELECT * FROM Usuario us WHERE us.correo = ?";
            $values2 = array($correo);
            $getUsuarioData = $insertarEnBaseDatos->consulta_ca($queryGet, $values2);
            $resultUsuarioData = array();
            if ($getUsuarioData->num_rows > 0) {
                while ($row = $getUsuarioData->fetch_assoc()) {
                    array_unshift($resultUsuarioData, array($row["id_usuario"], $row["nombre"], $row["apellido_paterno"], $row["apellido_materno"], $row["correo"], $row["numero"], $row["contrasena"], $row["foto"]));
                }
            }
            // Actualizar path de imagen en Dropbox con el ID autogenerado
            $queryUpdateImage = "UPDATE Usuario us SET us.foto = ? WHERE us.correo = ?";
            $valuesUpdate = array("/fotos_perfiles/foto_perfil_usuario_" . $resultUsuarioData[0][0] . "." . $fotoExten, $correo);
            $insertarEnBaseDatos->consulta_ca($queryUpdateImage, $valuesUpdate);
            // Insertar Dirección relacionada con usuario
            $valuesDir = array((int)$resultUsuarioData[0][0], $calle, $CP, $Pais, $numero_casa);
            $insertarEnBaseDatos->consulta_ca($queryInsertDireccion, $valuesDir);
            // Insertar en Dropbox Imagen de perfil de usuario
            $insertarEnDropBox->post(dirname($locFotoDropBox), basename($locFotoDropBox), "/" . "fotos_perfiles", "foto_perfil_usuario_" . $resultUsuarioData[0][0] . "." . $fotoExten);
            // Si completamos todo, respondemos con un mensaje de éxito
            respond("insertado", true);
        }
    } else {
        respond("Faltan campos requeridos en la solicitud.", false);
    }
} else {
    respond("Método de solicitud no permitido.", false);
}
?>
