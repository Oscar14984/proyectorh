<script>
	import { push } from 'svelte-spa-router';
  import axios from "axios";
  import Lugar from "../Lugares";
  import { onMount } from 'svelte';

  let tienePuestos;
  let rsPuestos;

  const getPuestos = async () => {
  try {
    const res = await axios.post(Lugar.backend + 'getPuestosData.php');
    const data = res.data;

    if (Array.isArray(data) && data.length > 0) {
      rsPuestos = data.map((/** @type {{ id_puesto: any; titulo: any; descripcion: any; fecha_limite: any; lugar: any; requisitos: string; ofrecemos: string; funcionesGenerales: string; habilidadesConocimientos: string; }} */ puesto) => {
        return {
          id_puesto: puesto.id_puesto,
          titulo: puesto.titulo,
          descripcion: puesto.descripcion,
          fecha_limite: puesto.fecha_limite,
          lugar: puesto.lugar,
          // requisitos: puesto.requisitos,
          // ofrecemos: puesto.ofrecemos,
          // funciones_generales: puesto.funcionesGenerales,
          // habilidades_conocimientos: puesto.habilidadesConocimientos,
        };
      });
    } else {
      rsPuestos = [];
    }
  } catch (error) {
    console.error("Error al obtener los puestos:", error);
    throw new Error("Error al obtener los puestos");
  }
};



// let puestos = [];
  onMount( async() => {
    getPuestos();
    // try {
    //   const response = await axios.post(Lugar.backend + 'getPuestosData.php');
    //   puestos = response.data;
    // } catch (error) {
    //   console.error('Error data:', error);
    // }
  });
</script>

<main>
  <div>
    <!-- Your existing HTML code -->
  </div>
  <div class="container">
    {#if tienePuestos}
      {#each rsPuestos as puesto (puesto.id_puesto) }
      <div class="card mt-3">
        <div class="card-body">
          <h5 class="card-title">{puesto.titulo}</h5>
          <p class="card-text"><strong>Descripción:</strong> {puesto.descripcion}</p>
          <p class="card-text"><strong>Fecha Límite:</strong> {puesto.fecha_limite}</p>
          <p class="card-text"><strong>Lugar:</strong> {puesto.lugar}

          <h6 class="card-subtitle mt-3 mb-2 text-muted">Requisitos:</h6>
          <ul class="list-group">
            <!-- {#if puesto.requisitos && puesto.requisitos.length > 0}
            {#each puesto.requisitos as requisito} -->
                <li class="list-group-item">{puesto.requisito}</li>
            <!-- {/each}
            {/if} -->
          </ul>

          <h6 class="card-subtitle mt-3 mb-2 text-muted">Ofrecemos:</h6>
          <ul class="list-group">
            <!-- {#if puesto.ofrecemos && puesto.ofrecemos.length > 0}
            {#each puesto.ofrecemos as ofrecemo} -->
              <li class="list-group-item">{puesto.ofrecemos}</li>
            <!-- {/each}
            {/if} -->
          </ul>

          <h6 class="card-subtitle mt-3 mb-2 text-muted">Funciones Generales:</h6>
          <ul class="list-group">
            <!-- {#if puesto.funciones_generales && puesto.funciones_generales.length > 0}
            {#each puesto.funciones_generales as funcionGeneral} -->
              <li class="list-group-item">{puesto.funcionGeneral}</li>
            <!-- {/each}
            {/if} -->
          </ul>

          <h6 class="card-subtitle mt-3 mb-2 text-muted">Habilidades y Conocimientos:</h6>
          <ul class="list-group">
            <!-- {#if puesto.habilidades_conocimientos && puesto.habilidades_conocimientos.length > 0}
            {#each puesto.habilidades_conocimientos as habilidadConocimiento} -->
              <li class="list-group-item">{puesto.habilidadConocimiento}</li>
            <!-- {/each}
            {/if} -->
          </ul>
        </div>
      </div>
      {/each}
    {:else}
      <p class="noPuestos">No se encuentra ningún puesto disponible.</p>
    {/if}
  </div>
</main>
