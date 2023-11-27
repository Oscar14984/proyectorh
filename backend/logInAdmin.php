<?php
    require_once 'accesos.php';

    //Creamos los objetos para poder insertar en DropBox y en MySQL
    require_once 'classGetPostInDataBase.php';
    require_once 'classInsertInDropBox.php';
    $jsonLogIn = json_decode(file_get_contents("php://input"), true);
    $query = "SELECT * FROM AdminUsuario ad WHERE ad.correo = ?";
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];
    $insertarEnBaseDatos = new classGetPostInDataBase();
    $insertarEnDropBox = new classInsertInDropBox();
    $values = array($correo);
    $getUsuarioData = $insertarEnBaseDatos->consulta_ca($query,$values);
    $resultUsuarioData = array();
    $localPath = getcwd();
    if ($getUsuarioData->num_rows > 0){
        while($row = $getUsuarioData->fetch_assoc()) {
            array_unshift($resultUsuarioData,array($row["id_usuario"],$row["nombre"],$row["apellido_paterno"],$row["apellido_materno"],$row["correo"],$row["numero"],$row["contrasena"],$row["foto"]));
        }
        //Si el correo y el hash de la contraseña coinciden devolvemos la informacion del usuario y un true
        if (($resultUsuarioData[0][4] == $correo) and (password_verify($contrasena, $resultUsuarioData[0][6]))){
            //$image = $insertarEnDropBox->getData($resultUsuarioData[0][7]);
            //echo getcwd();
            $filename = pathinfo($resultUsuarioData[0][7], PATHINFO_FILENAME);
            $temp = tempnam(sys_get_temp_dir(), $filename);
            $file = $insertarEnDropBox->download($resultUsuarioData[0][7]);
            //File Contents
            $contents = $file->getContents();
            //file_put_contents($localPath."/".basename($resultUsuarioData[0][7]),$contents);
            file_put_contents($temp, $contents);
            $post = array(
                "id_usuario" => $resultUsuarioData[0][0],
                "nombre" => $resultUsuarioData[0][1],
                "apellido_paterno" => $resultUsuarioData[0][2],
                "apellido_materno" => $resultUsuarioData[0][3],
                "correo" => $resultUsuarioData[0][4],
                "foto" => str_replace('\\', '/',$temp),
            );
            $post = json_encode($post);
            // $_POST["data"] = $post;
            echo $post;
            
            
        }else{
            //En caso de que no solo devolvemos un false
            $_POST["data"] = false;
        }
    }


?>