<?php
    require_once('./classGetPostInDataBase.php');
    require_once('./accesos.php');
    $mysql = new classGetPostInDataBase();
    $query=
 
	"SELECT
	profesionistas.curp, 
	profesionistas.nombre, 
	profesionistas.primer_apellido, 
	profesionistas.segundo_apellido, 
	profesionistas.email_profesionista, 
	profesionistas.matricula, 
	profesionistas.pdf, 
	antecedentes.institucion_procedencia, 
	antecedentes.fecha_inicio, 
	antecedentes.fecha_terminacion, 
	antecedentes.no_cedula, 
	antecedentes.fk_id_profesionista, 
	antecedentes.fk_id_tipo_estudio, 
	antecedentes.fk_id_entidad_federativa, 
	usuarios_carreras.fk_id_usuario, 
	usuarios_carreras.fk_id_carrera, 
	usuarios_carreras.fecha_inicio_carrea, 
	usuarios_carreras.fecha_expedicion_carrera, 
	usuarios_carreras.fecha_terminacion_carrera, 
	usuarios_carreras.modalidad, 
	usuarios_carreras.fecha_examen_profesional, 
	usuarios_carreras.fecha_excencion_examen_profesional, 
	usuarios_carreras.fundamento_legal, 
	usuarios_carreras.autorizacion_reconocimiento, 
	usuarios_carreras.folio, 
	usuarios_carreras.cumplio_servicio_social, 
	carreras.carrera_clave, 
	carreras.carrera_nombre, 
	carreras.carrera_activa, 
	carreras.id_carrera, 
	entidades_federativas.id_entidad_federativa, 
	entidades_federativas.entidad_federativa
FROM
	profesionistas
	INNER JOIN
	antecedentes
	ON 
		profesionistas.id_profesionista = antecedentes.fk_id_profesionista
	INNER JOIN
	usuarios_carreras
	ON 
		profesionistas.id_profesionista = usuarios_carreras.fk_id_usuario
	INNER JOIN
	carreras
	ON 
		usuarios_carreras.fk_id_carrera = carreras.id_carrera
	INNER JOIN
	entidades_federativas
	ON 
		antecedentes.fk_id_entidad_federativa = entidades_federativas.id_entidad_federativa
WHERE
	profesionistas.validado = 1
	ORDER BY
	profesionistas.primer_apellido ASC ";
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