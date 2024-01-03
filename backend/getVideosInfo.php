<?php
    require_once "accesos.php";
    require_once "classGetPostInDataBase.php";

    // $mysql = new classGetPostInDataBase();
    // $query=
	// "SELECT * FROM Videos vid WHERE vid.id_usuario = vid.id_usuario ";

    // $sql = $mysql->consulta_sa($query);
    // if ($sql->num_rows === 0){
	// 	$nuevoValor = 1;
    //     $tieneVideos=0;
    //     $rsVideos = '';
    // } else {
    //     $tieneVideos=1;
    //     $i=1;
    //     while ($row = $sql->fetch_assoc()) {
    //         //Videos
    //         $rsVideos[$i]['contador'] = $i;
    //         $rsVideos[$i]['id_video']=$row['id_video'];
    //         $rsVideos[$i]['id_usuario']=$row['id_usuario'];
    //         $rsVideos[$i]['mime']=$row['mime'];
    //         $rsVideos[$i]['file_name']=$row['file_name'];
    //         $rsVideos[$i]['localidad']=$row['localidad'];
    //         $rsVideos[$i]['fase']=$row['fase'];
    //         $i++;
    //     }
    // }
    // $response['d']=json_encode(array("rsVideos"=>$rsVideos,"tieneVideos"=>$tieneVideos));
    // echo json_encode($response);



    $jsonDataVideo = json_decode(file_get_contents("php://input"), true);
    $queryGetVideos = "SELECT * FROM Videos vid WHERE vid.id_usuario = ?";
    $insertarEnBaseDatos = new classGetPostInDataBase();
    
    $id_usuario = $jsonDataVideo["id_usuario"];
    $values = array((int)$id_usuario);
    $getDataVideos = $insertarEnBaseDatos->consulta_ca($queryGetVideos,$values);
    $rsVideos = array();
    while($row = $getDataVideos->fetch_assoc()){
        array_push($rsVideos,(array("id_video"=>$row["id_video"],"id_usuario"=>$row["id_usuario"],"mime"=>$row["mime"],"file_name"=>$row["file_name"],"localidad"=>$row["localidad"],"fase"=>$row["fase"])));
    }
    $response['d']=json_encode(array("rsVideos"=>$rsVideos));
    echo json_encode($response);
?>