 <?php
//     require_once "accesos.php";
//     require_once "classGetPostInDataBase.php";
//     $insertarEnBaseDatos = new classGetPostInDataBase();
//     $queryGetUsuarios = "SELECT * FROM Usuario us";
//     $dataUsuarios = $insertarEnBaseDatos->consulta_sa($queryGetUsuarios);
//     if ($dataUsuarios->num_rows > 0){
//         $usuarios = array();
//         while($row = $dataUsuarios->fetch_assoc()){
//             $usuario = array("id_usuario"=>$row["id_usuario"],"nombre"=>$row["nombre"],"apellido_paterno"=>$row["apellido_paterno"],"apellido_materno"=>$row["apellido_materno"],"correo"=>$row["correo"],"numero"=>$row["numero"],"contrasena"=>$row["contrasena"],"foto"=>$row["foto"]);
//             $usuario = json_encode($usuario);
//             array_unshift($usuarios,$usuario);
//         }
//         $usuarios = json_encode($usuarios);
//         $_POST["usuarios"] = $usuarios;
//     }else{
//         $_POST["usuarios"] = false;
//     }
//     $insertarEnBaseDatos->dbDisconnect();

    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    $mysql = new classGetPostInDataBase();
    // Consulta SQL para obtener puestos no validados ordenados por fecha límite ascendente
    $query = 
    "SELECT id_usuario, nombre, apellido_paterno, apellido_materno, correo, numero, contrasena, foto FROM Usuario
    ";
    // Ejecutar la consulta SQL
    $sql = $mysql->consulta_sa($query);
    // Inicializar variables para almacenar resultados
    $nuevoValor = 1;
    $tieneUsuarios = 0;
    $rsUsuarios = array();
    // Verificar si hay resultados en la consulta
    if ($sql->num_rows === 0) {
        $nuevoValor = 1;
        $tieneUsuarios = 0;
        $rsUsuarios = '';
    } else {
        // Hay puestos disponibles
        $tieneUsuarios = 1;
        $i=1;
        // Iterar sobre los resultados y almacenar en un arreglo asociativo
        while ($row = $sql->fetch_assoc()) {
            $rsUsuarios[$i]['id_usuario'] = $i;
            $rsUsuarios[$i]['nombre'] = $row['nombre'];
            $rsUsuarios[$i]['apellido_paterno'] = $row['apellido_paterno'];
            $rsUsuarios[$i]['apellido_materno'] = $row['apellido_materno'];
            $rsUsuarios[$i]['correo'] = $row['correo'];
            $i++;
        }
    }
    // Preparar la respuesta en formato JSON
    $response['d']=json_encode(array("rsUsuarios"=>$rsUsuarios,"tieneUsuarios"=>$tieneUsuarios));
    // Enviar la respuesta JSON al frontend
    echo json_encode($response);
    ?>