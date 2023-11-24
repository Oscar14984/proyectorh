<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    $mysql = new classGetPostInDataBase();
    // Consulta SQL para obtener puestos no validados ordenados por fecha límite ascendente
    $query = 
    "SELECT titulo, descripcion, fecha_limite, lugar
    FROM Puestos;
    ";
    // Ejecutar la consulta SQL
    $sql = $mysql->consulta_sa($query);
    // Inicializar variables para almacenar resultados
    $nuevoValor = 1;
    $tienePuestos = 0;
    $rsPuestos = array();
    // Verificar si hay resultados en la consulta
    if ($sql->num_rows === 0) {
        $nuevoValor = 1;
        $tienePuestos = 0;
        $rsPuestos = '';
    } else {
        // Hay puestos disponibles
        $tienePuestos = 1;
        $i=1;
        // Iterar sobre los resultados y almacenar en un arreglo asociativo
        while ($row = $sql->fetch_assoc()) {
            $rsPuestos[$i]['id_puesto'] = $i;
            $rsPuestos[$i]['titulo'] = $row['titulo'];
            $rsPuestos[$i]['descripcion'] = $row['descripcion'];
            $rsPuestos[$i]['fecha_limite'] = $row['fecha_limite'];
            $rsPuestos[$i]['lugar'] = $row['lugar'];
            $i++;
        }
    }
    // Preparar la respuesta en formato JSON
    $response['d']=json_encode(array("rsPuestos"=>$rsPuestos,"tienePuestos"=>$tienePuestos));
    // Enviar la respuesta JSON al frontend
    echo json_encode($response);
    ?>


