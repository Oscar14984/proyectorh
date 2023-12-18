<?php
    require_once('./classGetPostInDataBase.php');
    require_once('./accesos.php');
    $mysql = new classGetPostInDataBase();
    $query=
	"SELECT * FROM RelacionUsuarioPuesto rpu LEFT JOIN Usuario us ON rpu.id_usuario = us.id_usuario 
    LEFT JOIN Puestos pu ON rpu.id_puesto = pu.id_puesto
    WHERE pu.id_puesto";

    $sql = $mysql->consulta_sa($query);
    if ($sql->num_rows === 0){
		$nuevoValor = 1;
        $tieneProfesionistas=0;
        $rsProfesionistas = '';
    } else {
        $tieneProfesionistas=1;
        $i=1;
        while ($row = $sql->fetch_assoc()) {
            //Puestos
            $rsProfesionistas[$i]['contador'] = $i;
            $rsProfesionistas[$i]['titulo']=$row['titulo'];
            $rsProfesionistas[$i]['descripcion']=$row['descripcion'];
            $rsProfesionistas[$i]['fecha_limite']=$row['fecha_limite'];
            $rsProfesionistas[$i]['lugar']=$row['lugar'];
            $rsProfesionistas[$i]['pais']=$row['pais'];
            $rsProfesionistas[$i]['doctor_solicitante']=$row['doctor_solicitante'];
            //Usuarios
            $rsProfesionistas[$i]['nombre']=$row['nombre'];
            $rsProfesionistas[$i]['apellido_paterno']=$row['apellido_paterno'];
            $rsProfesionistas[$i]['apellido_materno']=$row['apellido_materno'];
            $rsProfesionistas[$i]['correo']=$row['correo'];
            $rsProfesionistas[$i]['numero']=$row['numero'];
            $i++;
        }
    }
    $response['d']=json_encode(array("rsProfesionistas"=>$rsProfesionistas,"tieneProfesionistas"=>$tieneProfesionistas));
    echo json_encode($response);
    ?>