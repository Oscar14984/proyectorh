 <?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";
    $insertarEnBaseDatos = new classGetPostInDataBase();
    $queryGetUsuarios = "SELECT * FROM Usuario us";
    $dataUsuarios = $insertarEnBaseDatos->consulta_sa($queryGetUsuarios);
    if ($dataUsuarios->num_rows > 0){
        $usuarios = array();
        while($row = $dataUsuarios->fetch_assoc()){
            $usuario = array("id_usuario"=>$row["id_usuario"],"nombre"=>$row["nombre"],"apellido_paterno"=>$row["apellido_paterno"],"apellido_materno"=>$row["apellido_materno"],"correo"=>$row["correo"],"numero"=>$row["numero"],"contrasena"=>$row["contrasena"],"foto"=>$row["foto"]);
            $usuario = ($usuario);
            array_unshift($usuarios,$usuario);
        }
        $usuarios = ($usuarios);
        // $_POST["usuarios"] = $usuarios;
        $response['d']=json_encode(array("usuarios"=>$usuarios));
        echo json_encode($response);
    }else{
        $_POST["usuarios"] = false;
    }
    $insertarEnBaseDatos->dbDisconnect();

    // require_once "accesos.php";
    // require_once "classGetPostInDataBase.php";
    // $mysql = new classGetPostInDataBase();
    // $query = 
    // "SELECT id_usuario, nombre, apellido_paterno, apellido_materno, correo, numero, contrasena, foto FROM Usuario
    // ";
    // $sql = $mysql->consulta_sa($query);
    // $nuevoValor = 1;
    // $tieneUsuarios = 0;
    // $rsUsuarios = array();
    // if ($sql->num_rows === 0) {
    //     $nuevoValor = 1;
    //     $tieneUsuarios = 0;
    //     $rsUsuarios = '';
    // } else {
    //     $tieneUsuarios = 1;
    //     $i=1;
    //     while ($row = $sql->fetch_assoc()) {
    //         $rsUsuarios[$i]['id_usuario'] = $i;
    //         $rsUsuarios[$i]['nombre'] = $row['nombre'];
    //         $rsUsuarios[$i]['apellido_paterno'] = $row['apellido_paterno'];
    //         $rsUsuarios[$i]['apellido_materno'] = $row['apellido_materno'];
    //         $rsUsuarios[$i]['correo'] = $row['correo'];
    //         $rsUsuarios[$i]['numero'] = $row['numero'];
    //         $i++;
    //     }
    // }
    // $response['d']=json_encode(array("rsUsuarios"=>$rsUsuarios,"tieneUsuarios"=>$tieneUsuarios));
    // echo json_encode($response);
    ?>