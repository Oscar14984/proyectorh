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
	usuario
	ORDER BY
	usuario.primer_apellido ASC ";
    $sql = $mysql->consulta_sa($query);
    if ($sql->num_rows === 0){
		$nuevoValor = 1;
        $tieneProfesionistas=0;
        $rsProfesionistas = '';
    } else {
        $tieneProfesionistas=1;
        $i=1;
        while ($row = $sql->fetch_assoc()) {
            $rsProfesionistas[$i]['contador'] = $i;
            $rsProfesionistas[$i]['curp']=$row['curp'];
            $rsProfesionistas[$i]['nombre']=$row['nombre'];
            $rsProfesionistas[$i]['primer_apellido']=$row['primer_apellido'];
            $rsProfesionistas[$i]['segundo_apellido']=$row['segundo_apellido'];
            $rsProfesionistas[$i]['matricula']=$row['matricula'];
            $rsProfesionistas[$i]['correo_usuario']=$row['email_profesionista'];
            $rsProfesionistas[$i]['pdf']=$row['pdf'];
            //Antecedentes
            $rsProfesionistas[$i]['institucion_procedencia']=$row['institucion_procedencia'];
            $rsProfesionistas[$i]['fecha_inicio']=$row['fecha_inicio'];
            $rsProfesionistas[$i]['fecha_terminacion']=$row['fecha_terminacion'];
            $rsProfesionistas[$i]['no_cedula']=$row['no_cedula'];
            $rsProfesionistas[$i]['fk_id_tipo_estudio']=$row['fk_id_tipo_estudio'];
            $rsProfesionistas[$i]['entidad_federativa']=$row['entidad_federativa'];
            //Carrera en curso
            $rsProfesionistas[$i]['carrera_nombre']=$row['carrera_nombre'];
            $rsProfesionistas[$i]['fecha_inicio_carrera']=$row['fecha_inicio_carrea'];
            $rsProfesionistas[$i]['fecha_terminacion_carrera']=$row['fecha_terminacion_carrera'];
            $rsProfesionistas[$i]['fecha_expedicion_carrera']=$row['fecha_expedicion_carrera'];
            $rsProfesionistas[$i]['autorizacion_reconocimiento']=$row['autorizacion_reconocimiento'];
            $rsProfesionistas[$i]['modalidad']=$row['modalidad'];
            $rsProfesionistas[$i]['fecha_examen_profesional']=$row['fecha_examen_profesional'];
            $rsProfesionistas[$i]['fundamento_legal']=$row['fundamento_legal'];
            $rsProfesionistas[$i]['folio']=$row['folio'];
            $rsProfesionistas[$i]['cumplio_servicio_social']=$row['cumplio_servicio_social'];


            $i++;
        }
    }
    $response['d']=json_encode(array("rsProfesionistas"=>$rsProfesionistas,"tieneProfesionistas"=>$tieneProfesionistas));
    echo json_encode($response);
    ?>