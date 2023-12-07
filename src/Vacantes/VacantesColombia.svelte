<script>
  // @ts-nocheck
	import Spinner from './../Componentes/Spinner.svelte';
  // @ts-nocheck
  import axios from "axios";
  import Lugar from "../Lugares";
  import { session } from "../session";
  import { onMount } from 'svelte';


  let spinner = false;
  let idUsuario = null;
//Para exportar el id_usuario cuando hace inicio de sesión.
  idUsuario = $session.id_usuario;
  console.log(idUsuario)

// let tienePuestos;
let jsonSalida = [];
const getPuestos = async () =>{
  try {
    spinner = true
    const res = await axios.post(Lugar.backend + 'getPuestosData.php')
    const data = JSON.parse(res.data.d);
    spinner = false
      jsonSalida = Object.values(data.jsonSalida).map(puesto => {
        const fechaLimite = new Date(puesto.fecha_limite);
        const fechaActual = new Date();
        const idPuesto = puesto.id_puesto;
        console.log(idPuesto)

        postularse(idPuesto);
        // Calcular la diferencia en milisegundos
        // @ts-ignore
        const diferenciaMilisegundos = fechaLimite - fechaActual;

        // Calcular la diferencia en días
        const diferenciaDias = Math.floor(diferenciaMilisegundos / (1000 * 60 * 60 * 24));


        return { ...puesto, diferenciaDias };
        // tienePuestos = jsonSalida.length > 0;

      });
      console.log(jsonSalida)
    
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

  //para postutularse
  const postularse = async (idPuesto) =>{
    try {
      const res = await axios.post(Lugar.backend+'postulacion.php',{
        id_puesto:idPuesto,
        // @ts-ignore
        id_usuario:idUsuario,
      })
    } catch (error) {
      
    };
  };
</script>
 
<main>
  {#if spinner == true}
     <Spinner />
  {/if}
  <div>
    <!-- Your existing HTML code -->
  </div>
  <div class="container">
      {#each jsonSalida as puesto (puesto.id_puesto)}
      <div class="card mt-3 ">
        <div class="card-header bg-primary text-white">Encabezado Azul</div>
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
        <div class="card-footer  text-white {getFecha(puesto.diferenciaDias)}">Tiempo estimado</div>
        <button class="btn btn-primary mt-3 mb-3" on:click={() => postularse(puesto.id_puesto)}>Postularse</button>
      </div>
      {/each}
  </div>
</main>

<style>
  .verde { background-color: green; }
  .amarillo { background-color: yellow; }
  .rojo { background-color: red; }
</style>