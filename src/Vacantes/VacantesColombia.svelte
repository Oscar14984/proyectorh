<script>
  import axios from "axios";
  import Lugar from "../Lugares";
  import { onMount } from 'svelte';

  let tienePuestos;
  let rsPuestos;

  const getPuestos = async () => {
    try {
      const res = await axios.post(Lugar.backend + 'getPuestosDataPrueba.php');
      const data = res.data;

      tienePuestos = data.length > 0;
      if (tienePuestos) {
        // Ensure rsPuestos is an array of objects
        rsPuestos = data.map(puesto => ({
          id_puesto: puesto.id_puesto,
          titulo: puesto.titulo,
          descripcion: puesto.descripcion,
          fecha_limite: puesto.fecha_limite,
          lugar: puesto.lugar,
          requisitos: JSON.parse(puesto.requisitos),
          ofrecemos: JSON.parse(puesto.ofrecemos),
          funciones_generales: JSON.parse(puesto.funcionesGenerales),
          habilidades_conocimientos: JSON.parse(puesto.habilidadesConocimientos),
        }));
      } else {
        rsPuestos = [];
      }
    } catch (error) {
      console.error("Error al obtener los puestos:", error);
    }
  };

  onMount(() => {
    getPuestos();
  });
</script>

<main>
  <div>
    <!-- Your existing HTML code -->
  </div>
  <div class="container">
    {#if tienePuestos}
      {#each rsPuestos as vacante (vacante.id_puesto)}
      <div class="card mt-3">
        <div class="card-body">
          <h5 class="card-title">{vacante.titulo}</h5>
          <p class="card-text"><strong>Descripción:</strong> {vacante.descripcion}</p>
          <p class="card-text"><strong>Fecha Límite:</strong> {vacante.fecha_limite}</p>
          <p class="card-text"><strong>Lugar:</strong> {vacante.lugar}

          <h6 class="card-subtitle mt-3 mb-2 text-muted">Requisitos:</h6>
          <ul class="list-group">
            {#if vacante.requisitos && vacante.requisitos.length > 0}
            {#each vacante.requisitos.filter(Boolean) as requisito}
                <li class="list-group-item">{requisito}</li>
            {/each}
            {/if}
          </ul>

          <h6 class="card-subtitle mt-3 mb-2 text-muted">Ofrecemos:</h6>
          <ul class="list-group">
            {#if vacante.ofrecemos && vacante.ofrecemos.length > 0}
            {#each vacante.ofrecemos.filter(Boolean) as ofrecemo}
              <li class="list-group-item">{ofrecemo}</li>
            {/each}
            {/if}
          </ul>

          <h6 class="card-subtitle mt-3 mb-2 text-muted">Funciones Generales:</h6>
          <ul class="list-group">
            {#if vacante.funciones_generales && vacante.funciones_generales.length > 0}
            {#each vacante.funciones_generales.filter(Boolean) as funcionGeneral}
              <li class="list-group-item">{funcionGeneral}</li>
            {/each}
            {/if}
          </ul>

          <h6 class="card-subtitle mt-3 mb-2 text-muted">Habilidades y Conocimientos:</h6>
          <ul class="list-group">
            {#if vacante.habilidades_conocimientos && vacante.habilidades_conocimientos.length > 0}
            {#each vacante.habilidades_conocimientos.filter(Boolean) as habilidadConocimiento}
              <li class="list-group-item">{habilidadConocimiento}</li>
            {/each}
            {/if}
          </ul>
        </div>
      </div>
      {/each}
    {:else}
      <p class="noPuestos">No se encuentra ningún puesto disponible.</p>
    {/if}
  </div>
</main>
