<?php
    /*
    Codigo que registra la un postulacion
    Entradas : 
    1.- id_usuario : int
    2.- id_puesto : int
    Salidas : 
    Ninguna
    */
    //Importamos accesos para poder obtener informacion del Front End
    require_once "accesos.php";
    //Clase con los accesos a la base de datos
    require_once "classGetPostInDataBase.php";
    //Objeto con los metodos para acceder a la base de datos
    $insertarEnBaseDatos = new classGetPostInDataBase();

    try{
        $dataPostulacion = json_decode(file_get_contents("php://input"), true);
        //Id del usuario y del puesto
        $idUsuario = (int)$dataPostulacion["id_usuario"];
        $idPuesto = (int)$dataPostulacion["id_puesto"];
        $queryGetInfoPuestos = "SELECT * FROM RelacionUsuarioPuesto rup WHERE rup.id_usuario = ? AND rup.id_puesto = ?";
        $getPuestosInfo = $insertarEnBaseDatos->consulta_ca($queryGetInfoPuestos,array($idUsuario,$idPuesto));
        if ($getPuestosInfo->num_rows == 0){
            //Query para insertar una postulacion
            $queryPostulacion = "INSERT INTO RelacionUsuarioPuesto(id_usuario,id_puesto) VALUES(?,?)";
            $insertarEnBaseDatos->consulta_ca($queryPostulacion,array($idUsuario,$idPuesto));
            $insertarEnBaseDatos->dbDisconnect();
            $_POST["estado"] = true;
        }else{
            $_POST["estado"] = false;
        }
    }catch(Exception $e){
        $insertarEnBaseDatos->dbDisconnect();
        $_POST["estado"] = false;
    }
?>