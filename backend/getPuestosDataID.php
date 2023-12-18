<?php
    require_once('./classGetPostInDataBase.php');
    require_once('./accesos.php');
    $mysql = new classGetPostInDataBase();
    $query=
	"SELECT
	relacionusuariopuesto.id_usuario, 
	relacionusuariopuesto.id_puesto, 
	puestos.titulo, 
	puestos.descripcion, 
	puestos.fecha_limite, 
	puestos.lugar, 
	puestos.pais, 
	puestos.doctor_solicitante, 
	usuario.nombre, 
	usuario.apellido_paterno, 
	usuario.apellido_materno, 
	usuario.id_usuario, 
	puestos.id_puesto, 
	relacionusuariopuesto.id_relacion, 
	usuario.correo, 
	usuario.numero, 
	usuario.contrasena, 
	usuario.foto
    FROM
    relacionusuariopuesto,
    puestos,
    usuario";

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