<?php
    //Autor: Leonardo Gracida Munoz
    //Propiedad: Dental Network

    //Importamos los headers de la pagina
    //"C:\Users\chest\OneDrive\Documentos\GitHub\DataBaseDevelopment\gato_chambeador.jpg"
    require_once 'accesos.php';

    //Importamos la clase para adminiastar la base de datos
    require_once 'classGetPostInDataBase.php';

    //Importamos la clase para administar la insercion y extraccion de datos de DropBox
    require_once 'classInsertInDropBox.php';
    //query para insertar un usuario en la base de datos
    $queryInsertUsuario = "INSERT INTO `Usuario`(`nombre`,`apellido_paterno`,`apellido_materno`,`correo`,`numero`,`contrasena`,`foto`) VALUES(?,?,?,?,?,?,?)";
    //query para insertar una direccion en la base de datos
    $queryInsertDireccion = "INSERT INTO `Direccion`(`id_usuario`,`calle`,`CP`,`pais`,`numero`) VALUES(?,?,?,?,?)";
    //Generamos los objetos
    $insertarEnBaseDatos = new classGetPostInDataBase();
    $insertarEnDropBox = new classInsertInDropBox();
    //Obtenemos la informacion del JSON
    $jsonInformation = json_decode(file_get_contents("php://input"), true);
    //Declaramos todos los post que vamos a obtener del front
    $nombre = $jsonInformation["nombre"];
    $apellido_paterno = $jsonInformation["apellido_paterno"];
    $apellido_materno = $jsonInformation["apellido_materno"];
    $correo = $jsonInformation["correo"];
    $numero = $jsonInformation["numero"];
    $contrasena = $jsonInformation["contrasena"];
    $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
    $calle = $jsonInformation["calle"];
    $CP = $jsonInformation["CP"];
    $Estado = $jsonInformation["Estado"]; 
    $Pais = $jsonInformation["Pais"]; 
    $numero_casa = $jsonInformation["Num_casa"]; 

    //Checar si no hay un usuario ya ingreasdo en la base de datos.
    $correo_sin_espacios = trim($correo);
    $queryCheck = "SELECT * FROM Usuario us WHERE us.correo = "."'".$correo_sin_espacios."'"." AND us.numero = "."'".$numero."'";
    $correoRepCon = $insertarEnBaseDatos->consulta_sa($queryCheck);
    if ($correoRepCon->num_rows > 0) {
        //En caso de haber un usuario reepetido devolvemos solamente un false
        echo "repetido";
        $_POST["data"] = false;
    }else{
        //Insertar en MySQL
        //Inseratmos el usuario en la base de datos
        $values = array($nombre,$apellido_paterno,$apellido_materno,$correo,$numero,$contrasena,"/fotos_perfiles/foto_general_perfil.jpg");
        $insertarEnBaseDatos->consulta_ca($queryInsertUsuario,$values);
        //Consultamos la informacion del usuario recien ingresado para poder obtener el id autogenerada
        $queryGet = "SELECT * FROM Usuario us WHERE us.correo = ?";
        $values2 = array($correo);
        $getUsuarioData = $insertarEnBaseDatos->consulta_ca($queryGet,$values2);
        $resultUsuarioData = array();
        if ($getUsuarioData->num_rows > 0) {
            while($row = $getUsuarioData->fetch_assoc()) {
                array_unshift($resultUsuarioData,array($row["id_usuario"],$row["nombre"],$row["apellido_paterno"],$row["apellido_materno"],$row["correo"],$row["numero"],$row["contrasena"],$row["foto"]));
            }
        }
        //Insertar Direccion relacionada con usuario
        $valuesDir = array((int)$resultUsuarioData[0][0],$calle,$CP,$Pais,$numero);
        $insertarEnBaseDatos->consulta_ca($queryInsertDireccion,$valuesDir);
        //Si completamos todo posteamos un true
        $_POST["data"] = true;
    }
?>