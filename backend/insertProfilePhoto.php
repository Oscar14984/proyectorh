<?php
    require_once 'accesos.php';
    require_once 'classInsertInDropBox.php';
    require_once 'classGetPostInDataBase.php';
    if(!empty($_FILES)){
        $insertarEnBaseDatos = new classGetPostInDataBase();
        $insertarEnDropBox = new classInsertInDropBox();
        $jsonInformation = json_decode(file_get_contents("php://input"), true);
        $locFotoDopBox =  $_FILES['file']['tmp_name'];//$jsonInformation["image_path"];
        //$locFotoDopBox = str_replace("/",DIRECTORY_SEPARATOR,$locFotoDopBox);
        $fotoName = $_FILES['file']['name'];
        $fotoExten = explode(".",$fotoName);
        $fotoExten = end($fotoExten);
        $idUsuario = $_POST["idUsuario"];
        $correoUsuario = $_POST["correoUsuario"];
        //Obtener informacion del usuario
        $resultUsuarioData = array();
        $queryObtenerInfoUsuario = "SELECT * FROM Usuario us WHERE us.id_usuario = ?";
        $values = array((int)$idUsuario);
        $getUsuarioData = $insertarEnBaseDatos->consulta_ca($queryObtenerInfoUsuario,$values);
        while($row = $getUsuarioData->fetch_assoc()) {
            array_unshift($resultUsuarioData,array($row["id_usuario"],$row["nombre"],$row["apellido_paterno"],$row["apellido_materno"],$row["correo"],$row["numero"],$row["contrasena"],$row["foto"]));
        }
        $fotoActualNombre = $resultUsuarioData[0][7];
        if ($fotoActualNombre != "/fotos_perfiles/foto_general_perfil.jpg"){
            $insertarEnDropBox->deleteFileOrFolder($fotoActualNombre);
        }
        //Actualizar path de imagen en DropBox con el id autogenerada
        $queryUpdateImage = "UPDATE Usuario us SET us.foto = ? WHERE us.id_usuario = ?";
        $valuesUpdate = array("/fotos_perfiles/foto_perfil_usuario_".$idUsuario.".".$fotoExten,(int)$idUsuario);
        $insertarEnBaseDatos->consulta_ca($queryUpdateImage,$valuesUpdate);
        //Insertar en DropBox Imagen de perfil de usuario
        $insertarEnDropBox->post(dirname($locFotoDopBox),basename($locFotoDopBox),"/"."fotos_perfiles","foto_perfil_usuario_".$idUsuario.".".$fotoExten);
    }
?>