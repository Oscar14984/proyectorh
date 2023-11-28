<script>
	import ExamenTecnico from './ExamenTecnico.svelte';

const preguntas = [
  {
    pregunta: "Pregunta 1",
    respuestas: [
      { respuesta: "a. 36 y 35" },
      { respuesta: "b. 46 y 45" },
      { respuesta: "c. 37 y 35" },
      { respuesta: "d. 47 y 35" },
      { respuesta: "e. 36 y 34" },
    ],
  },
  {
    pregunta: "Pregunta 2",
    respuestas: [
      { respuesta: "a. Nunca" },
      { respuesta: "b. Consulta primera vez" },
      { respuesta: "c. En cita de tratamiento" },
      { respuesta: "d. Cita de urgencia" },
      { respuesta: "e. Cuando el paciente esté dispuesto" },
    ],
  },
  {
    pregunta: "Pregunta 3",
    respuestas: [
      { respuesta: "a. En tratamientos invasivos" },
      { respuesta: "b. Solo una vez para todo el tratamiento y finalizando la consulta" },
      { respuesta: "c. Antes de cada procedimiento que se vaya a realiza" },
      { respuesta: "d. En la consulta de primera vez" },
    ],
  },
  {
    pregunta: '4. Paciente de 45 años. Asiste por urgencias por dolor severo de 2 días de evolución, e informa que desde ayer se inflamo "señala cuadrante II (OD 26). Al interrogatorio relata que es diabetico e hipertenso controlado, desde hace 3 años. Al examen radiográfico se evidencia tratamiento endodóntico, con ensanchamiento del espacio de ligamento periodental. Clinicamente se evidencia edema extraoral, indurado, sin fistula, en zona posterior de cuadrante II. Defina el diagnóstico y tratamiento."',
    respuestas: [
        {respuesta:"a. Dx: Pulpitis Irreversible. Tx: Medicación + retratamiento endodóntico"},
        {respuesta:"b. Dx: Necrosis pulpar con periodontitis apical crónica. Tx: Endodoncia"},
        {respuesta:"c. Dx: Absceso periapical sin fistula. Tx: Drenaje + Medicación"},
        {respuesta:"d. Dx: Absceso periapical sin fistula. Tx: Medicación + Retratamiento"},
        {respuesta:"e. Ninguna de las anteriores"},
    ]
  },
];


</script>

<main>
 <div class="container">
    <fieldset>
        <legend>ExamenTecnico</legend>
        <div class="seccion_1">
           {#each preguntas as pre}
           <p>{pre.pregunta}</p>
            {#each pre.respuestas as res}
                <ul>
                    <li>
                        <input type="radio">
                        {res.respuesta}
                    </li>
                </ul>
            {/each}
           {/each}
        </div>
    </fieldset>
 </div>
</main>

<style>
p{
    font-weight: bold;
}
</style>