<?php
require_once "accesos.php";
require_once "classGetPostInDataBase.php";

// Crear una instancia de la clase para acceder a la base de datos
$getFromDataBase = new classGetPostInDataBase();

try {
    // Consulta para obtener todos los puestos con sus detalles
    $queryGetPuestos = "SELECT p.id_puesto, p.titulo, p.descripcion, p.fecha_limite, p.lugar,
                               r.descripcion as requisito,
                               o.descripcion as ofrecemos,
                               fg.descripcion as funcion_general,
                               hc.descripcion as habilidad_conocimiento
                        FROM Puestos p
                        LEFT JOIN Requisitos r ON p.id_puesto = r.id_puesto
                        LEFT JOIN Ofrecemos o ON p.id_puesto = o.id_puesto
                        LEFT JOIN FuncionesGenerales fg ON p.id_puesto = fg.id_puesto
                        LEFT JOIN HabilidadesConocimientos hc ON p.id_puesto = hc.id_puesto";

    $result = $getFromDataBase->consulta_ca($queryGetPuestos);

    // Verificar si se obtuvieron resultados
    if ($result->num_rows > 0) {
        // Crear un array para almacenar los datos de los puestos
        $puestos = array();

        // Recorrer los resultados y almacenarlos en el array
        while ($row = $result->fetch_assoc()) {
            $puestoId = $row["id_puesto"];

            // Verificar si ya existe el puesto en el array principal
            if (!isset($puestos[$puestoId])) {
                $puestos[$puestoId] = array(
                    "id_puesto" => $puestoId,
                    "titulo" => $row["titulo"],
                    "descripcion" => $row["descripcion"],
                    "fecha_limite" => $row["fecha_limite"],
                    "lugar" => $row["lugar"],
                    "requisitos" => array(),
                    "ofrecemos" => array(),
                    "funciones_generales" => array(),
                    "habilidades_conocimientos" => array()
                );
            }

            // Agregar detalles al array del puesto
            if (!empty($row["requisito"])) {
                $puestos[$puestoId]["requisitos"][] = $row["requisito"];
            }
            if (!empty($row["ofrecemos"])) {
                $puestos[$puestoId]["ofrecemos"][] = $row["ofrecemos"];
            }
            if (!empty($row["funcion_general"])) {
                $puestos[$puestoId]["funciones_generales"][] = $row["funcion_general"];
            }
            if (!empty($row["habilidad_conocimiento"])) {
                $puestos[$puestoId]["habilidades_conocimientos"][] = $row["habilidad_conocimiento"];
            }
        }

        // Convertir el array a formato JSON y mostrarlo
        echo json_encode(array_values($puestos)); // Usar array_values para reiniciar los índices numéricos
    } else {
        echo "No se encontraron puestos.";
    }
} catch (Exception $e) {
    // Manejar la excepción si ocurre algún error
    echo "Error al obtener los puestos: " . $e->getMessage();
} finally {
    // Desconectar la base de datos
    $getFromDataBase->dbDisconnect();
}
?>
