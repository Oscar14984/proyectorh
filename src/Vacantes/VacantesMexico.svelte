<script>
    import axios from "axios";
    import { onMount } from 'svelte';

  let tienePuestos;
  let rsPuestos;

  const puestos = async () => {
    const res = await axios.post('http://localhost/RECURSOS_HUMANOS_PROYECTO/backend/getPuestosData.php');
    const data = JSON.parse(res.data.d);
    tienePuestos = data.tienePuestos;
    if (tienePuestos == true ) {
      rsPuestos = Object.values(data.rsPuestos);
    } else {
      rsPuestos = "";
    }
  };
  puestos();

  let isFlipped = false;

  const flipCard = () => {
    isFlipped = !isFlipped;
  };
</script>

<main>
  <div>
    <h1 class="text-info" style="text-shadow: 1px 1px 2px black;">OPORTUNIDADES DE EMPLEO</h1>
    <p>Siempre estamos buscando personas entusiastas y apasionadas para unirse a nuestro equipo, encuentra la vacante ideal para ti.</p>
  </div>
  <div class="container">
    {#if tienePuestos == true}
      {#each rsPuestos as vacantes (vacantes.id_puesto)}
      <!-- svelte-ignore a11y-click-events-have-key-events -->
      <!-- svelte-ignore a11y-no-static-element-interactions -->
      <div class="card" on:click={flipCard}>
        <div class="card-front">
          <div class="card-body">
            <h5 class="card-title">{vacantes.titulo}</h5>
            <p class="card-text">{vacantes.descripcion}</p>
          </div>
        </div>
        <div class="card-back">
          <div class="card-body">
            <h5 class="card-title">Detalles de la Vacante</h5>
            <p class="card-text">Fecha Limite: {vacantes.fecha_limite}</p>
          <button class="btn btn-info">Aplicar</button>
          </div>
        </div>
      </div>
      {/each}
      {:else}
      <p class="noPuestos">No se encuentra ningun puestos disponible.</p>
    {/if}
  </div>
  
</main>

<style>
  .container{
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr));
    grid-auto-rows: 200px;
    margin-bottom: 10%;
  }
  .card {
    width: 18rem;
    margin: 20px;
    cursor: pointer;
    transform-style: preserve-3d;
    transition: transform 0.5s;
    
  }

  .card:hover {
    transform: rotateY(180deg);
  }

  .card-front, .card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
  }

  .card-front {
    border-top: 4px solid #17a2b8;
    color: #212529;
    transform: rotateY(0deg);
    /* z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center; */
    background-color: #fff;
  }

  .card-back {
    color: black;
    transform: rotateY(180deg);
    border-top: 4px solid #17a2b8;
    background-color: #f8f9fa;
  }
  .noPuestos{
    display: flex;
    align-items: center;
  }
</style>