<?php
    /*
    Back End que edita los puesto en la base de datos.
    Entradas : 
    1.- titulo : str, titulo del puesto
    2.- descripcion : str, desripcion del puesto
    3.- fecha_limite : date yy-mm-dd
    4.- lugar : str, lugar donde reside el trabajo
    5.- pais : str, pais donde reside el puesto
    6.- id_puesto : int, id del puesto que queremos editar
    7.- doctor_solicitante : str, nombre del dentista que solicita el puesto
    7.- requisitos, ofrecemos, funciones_generales, habilidades_conocimientos : array, arreglo que contiene el id de su table y el nuevo requisito
    Salida :
    Ninguna
    */
    //Importamos los accesos para poder mandar informacion del front al back
    require_once "accesos.php";
    //Clases que nos permiten tener accesos a la base de datos
    require_once "classGetPostInDataBase.php";
    $insertarEnBaseDatos = new classGetPostInDataBase();
    //Queries para poder modificar el puesto y sus requisitos
    $queryUpdatePuesto = "UPDATE Puestos pu SET pu.titulo = ?, pu.descripcion = ?, fecha_limite = ?, pu.lugar = ?, pu.pais = ?, pu.doctor_solicitante = ? WHERE pu.id_puesto = ?";
    $queryUpdateRequisitosGenerales = "UPDATE Requisitos re SET re.descripcion = ? WHERE re.id = ?";
    $queryUpdateOfrecemos = "UPDATE Ofrecemos of SET of.descripcion = ? WHERE of.id = ?";
    $queryUpdateFuncionesGenerales = "UPDATE FuncionesGenerales fg SET fg.descripcion = ? WHERE fg.id = ?";
    $queryUpdateHabilidadesConocimientos = "UPDATE HabiliadesConocimientos hc SET hc.descripcion = ? WHERE hc.id = ?";

    //Variable que contiene la infoirmacion que mandamos al back end
    $dataDocument = json_decode(file_get_contents("php://input"), true);

    //Inputs de front al back
    $titulo = $dataDocument["titulo"];
    $descripcion = $dataDocument["descripcion"];
    $fechaLimite = $dataDocument["fecha_limite"];
    $lugar = $dataDocument["lugar"];
    $pais = $dataDocument["pais"];
    $idPuesto = $dataDocument["id_puesto"];
    $doctorSolicitante = $dataDocument["doctor_solicitante"];
    //Inputs de array
    $requisitos = $dataDocument["requisitos"];
    $ofrecemos = $dataDocument["ofrecemos"];
    $funcionesGenerales = $dataDocument["funciones_generales"];
    $habilidadesConocimientos = ($dataDocument["habilidades_conocimientos"]);
    //Actualizamos solamente la tabla general de puestos
    $values = array($titulo,$descripcion,$fechaLimite,$lugar,$pais,$doctorSolicitante,(int)$idPuesto);
    $insertarEnBaseDatos->consulta_ca($queryUpdatePuesto,$values);

    //Para poder hacer la insercion dinamica de los requisitos de cada puesto iteramos en cada unos de los array para poder insertar en las tablas de requisitos de los puestos
    foreach ($requisitos as $requisito) {
        $id = $requisito["id"];
        $req = $requisito["linea"];
        $valuesRequisito = array($req,$id);
        $insertarEnBaseDatos->consulta_ca($queryUpdateRequisitosGenerales,$valuesRequisito);
    }

    foreach ($ofrecemos as $ofrece) {
        $id = $ofrece["id"];
        $ofer = $ofrece["linea"];
        $valuesOferta = array($ofer,$id);
        $insertarEnBaseDatos->consulta_ca($queryUpdateOfrecemos,$valuesOferta);
    }

    foreach ($funcionesGenerales as $funcion) {
        $id = $funcion["id"];
        $fun = $funcion["linea"];
        $valuesFuncionGeneral = array($fun,$id);
        $insertarEnBaseDatos->consulta_ca($queryUpdateFuncionesGenerales,$valuesFuncionGeneral);
    }

    foreach ($habilidadesConocimientos as $habCon) {
        $id = $habCon["id"];
        $hab = $habCon["linea"];
        $valuesHabilidadConocimiento = array($hab,$id);
        $insertarEnBaseDatos->consulta_ca($queryUpdateHabilidadesConocimientos,$valuesHabilidadConocimiento);
    }
    //Nos deconectamos de la base de datos
    $insertarEnBaseDatos->dbDisconnect();
?>