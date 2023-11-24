<?php
    require_once "classGetPostInDataBase.php";
    require_once "accesos.php";

    $queryDataPuestosRelacionados = "SELECT * FROM RelacionUsuarioPuesto rpu LEFT JOIN Usuario us ON rpu.id_usuario = us.id_usuario 
                                    LEFT JOIN Puestos pu ON rpu.id_puesto = pu.id_puesto
                                    WHERE us.id_usuario = ?";
    $data = json_decode(file_get_contents("php://input"), true);
    $id_usuario = $data["id_usuario"];
    $valuesInsert = array($id_usuario);

    $valuesData = array();

    $insertarEnBaseDatos = new classGetPostInDataBase();
    $getDataRelacionUsuarioPuesto = $insertarEnBaseDatos->consulta_ca($queryDataPuestosRelacionados,$valuesInsert);
    if ($getDataRelacionUsuarioPuesto->num_rows > 0) {
        while($row = $getDataRelacionUsuarioPuesto->fetch_assoc()) {
            array_push($valuesData,array($row["id_puesto"],$row["titulo"],$row["descripcion"],$row["fecha_limite"]));
        }
    }else{
        //En caso de tener una respuesta incorrecta tiramos todo
        die("Sin trabajos registrados");
    }
    $jsonSalida = json_encode($valuesData);
    $_POST["dataPuestos"] = $jsonSalida;

?>