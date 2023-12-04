<script>
// @ts-nocheck

  import axios from "axios";
  import Lugar from "../Lugares";
  import { onMount } from 'svelte';

  let tienePuestos = true;
  let rsPuestos;

//   const getPuestos = async () => {
//   try {
//     const res = await axios.post(Lugar.backend + 'getPuestosData.php');
//     const data = res.data;

//     tienePuestos = data.length > 0;
//     if (tienePuestos) {
//       rsPuestos = (puesto => {
//         // Parsea las cadenas JSON en cada propiedad correspondiente
//         return {
//           id_puesto: puesto.id_puesto,
//           titulo: puesto.titulo,
//           descripcion: puesto.descripcion,
//           fecha_limite: puesto.fecha_limite,
//           lugar: puesto.lugar,
//           requisitos: JSON.parse(puesto.requisitos),
//           ofrecemos: JSON.parse(puesto.ofrecemos),
//           funciones_generales: JSON.parse(puesto.funcionesGenerales),
//           habilidades_conocimientos: JSON.parse(puesto.habilidadesConocimientos),
//         };
//       });
//       console.log(rsPuestos)
//     } else {
//       rsPuestos = [];
//     }
//   } catch (error) {
//     console.error("Error al obtener los puestos:", error);
//   }
// };

let puestos = []
let jsonSalida = [];
const getPuestos = async () =>{
  try {
    const res = await axios.post(Lugar.backend + 'getPuestosData.php')
    const data = JSON.parse(res.data.d);
    // if(tienePuestos){
      jsonSalida = Object.values(data.jsonSalida).map(puesto => {
        const fechaLimite = new Date(puesto.fecha_limite);
        const fechaActual = new Date();

        // Calcular la diferencia en milisegundos
        const diferenciaMilisegundos = fechaLimite - fechaActual;

        // Calcular la diferencia en días
        const diferenciaDias = Math.floor(diferenciaMilisegundos / (1000 * 60 * 60 * 24));

        return { ...puesto, diferenciaDias };
      });
      console.log(jsonSalida)
    // } 
  } catch (error) {
    
  }
};
// Función para determinar la clase CSS basada en la diferencia de días
const getFecha = (diferenciaDias) => {
    if (diferenciaDias >= 15) {
      return 'verde';  // Clase CSS para color verde
    } else if (diferenciaDias >= 0) {
      return 'amarillo';  // Clase CSS para color amarillo
    } else {
      return 'rojo';  // Clase CSS para color rojo
    }
  }
  onMount(() => {
    getPuestos();
  });
</script>
 
<main>
  <div>
    <!-- Your existing HTML code -->
  </div>
  <div class="container">
    <!-- {#if tienePuestos} -->
      {#each jsonSalida as puesto (puesto.id_puesto)}
      <div class="card mt-3 {getFecha(puesto.diferenciaDias)}">
        <div class="card-body">
          <h5 class="card-title">{puesto.titulo}</h5>
          <p class="card-text"><strong>Descripción:</strong> {puesto.descripcion}</p>
          <p class="card-text"><strong>Fecha Límite:</strong> {puesto.fecha_limite}</p>
          <p class="card-text"><strong>Lugar:</strong> {puesto.lugar}

          <h6 class="card-subtitle mt-3 mb-2 text-muted">Requisitos:</h6>
          <ul class="list-group">
            {#each puesto.requisitos as requisito}
                <li class="list-group-item">{requisito.linea}</li>
            {/each}
          </ul>

          <h6 class="card-subtitle mt-3 mb-2 text-muted">Ofrecemos:</h6>
          <ul class="list-group">
            {#each puesto.ofrecemos as ofrecemo}
              <li class="list-group-item">{ofrecemo.linea}</li>
            {/each}
          </ul>

          <h6 class="card-subtitle mt-3 mb-2 text-muted">Funciones Generales:</h6>
          <ul class="list-group">
            {#each puesto.funcionesGenerales as funcionGeneral}
              <li class="list-group-item">{funcionGeneral.linea}</li>
            {/each}
          </ul>

          <h6 class="card-subtitle mt-3 mb-2 text-muted">Habilidades y Conocimientos:</h6>
          <ul class="list-group">
            {#each puesto.habilidadesConocimientos as habilidadConocimiento}
              <li class="list-group-item">{habilidadConocimiento.linea}</li>
            {/each}
          </ul>
        </div>
      </div>
      {/each}
    <!-- {:else}
      <p class="noPuestos">No se encuentra ningún puesto disponible.</p>
    {/if} -->
  </div>
</main>

<style>
  .verde { background-color: green; }
  .amarillo { background-color: yellow; }
  .rojo { background-color: red; }
</style>