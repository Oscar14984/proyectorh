<?php
    //Autor: Leonardo Gracida Munoz
    //Propiedad: Dental Network

    //Importamos los headers de la pagina
    require_once 'accesos.php';

    //Creamos los objetos para poder insertar en DropBox y en MySQL
    require_once 'classGetPostInDataBase.php';
    require_once 'classInsertInDropBox.php';
    //Declaramos los post que vamos a obtener del front
    $jsonLogIn = json_decode(file_get_contents("php://input"), true);
    $correo = $jsonLogIn["correo"];
    $correo = trim($correo);
    $contrasena = $jsonLogIn["contrasena"];
    //Consulta para obtener los usuarios relacionados con el correo ingresado
    $query = "SELECT * FROM Usuario us WHERE us.correo = ?";
    $values = array($correo);
    $insertarEnBaseDatos = new classGetPostInDataBase();
    $insertarEnDropBox = new classInsertInDropBox();
    $getUsuarioData = $insertarEnBaseDatos->consulta_ca($query,$values);
    $resultUsuarioData = array();
    $localPath = getcwd();
    //En caso de obtener una consulta no vacia proseguimos
    if ($getUsuarioData->num_rows > 0) {
        while($row = $getUsuarioData->fetch_assoc()) {
            array_unshift($resultUsuarioData,array($row["id_usuario"],$row["nombre"],$row["apellido_paterno"],$row["apellido_materno"],$row["correo"],$row["numero"],$row["contrasena"],$row["foto"]));
        }
        //Si el correo y el hash de la contraseña coinciden devolvemos la informacion del usuario y un true
        if (($resultUsuarioData[0][4] == $correo) and (password_verify($contrasena, $resultUsuarioData[0][6]))){
            //$image = $insertarEnDropBox->getData($resultUsuarioData[0][7]);
            //echo getcwd();
            $file = $insertarEnDropBox->download($resultUsuarioData[0][7]);
            //File Contents
            $contents = $file->getContents();
            file_put_contents($localPath."/".basename($resultUsuarioData[0][7]),$contents);
            $post = array(
                "id_usuario" => $resultUsuarioData[0][0],
                "nombre" => $resultUsuarioData[0][1],
                "apellido_paterno" => $resultUsuarioData[0][2],
                "apellido_materno" => $resultUsuarioData[0][3],
                "correo" => $resultUsuarioData[0][4],
                "foto" => str_replace('\\', '/',$localPath."/".basename($resultUsuarioData[0][7])),
            );
            $post = json_encode($post);
            // $_POST["data"] = $post;
            echo $post;
            
            
        }else{
            //En caso de que no solo devolvemos un false
            $_POST["data"] = false;
        }
    }else{
        //En caso de tener una respuesta incorrecta tiramos todo
        $_POST["data"] = false;
    }
?>