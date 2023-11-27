<script>
	import RegistrarPuesto from './RegistrarPuesto.svelte';
	import { push } from 'svelte-spa-router';

    const irVacantes = () =>{
        push('/RegistrarPuesto')
    }

    const irPostulados = () =>{
        push('/Postulados')
    }

</script>

<main>
    <div class="container">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">Vacantes</h5>
              <p class="card-text">Tabla para administrar los puestos de trabajo.</p>
              <button class="btn btn-info" on:click={irVacantes}>Ir</button>
            </div>
          </div>
        <div class="card" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">Postulados</h5>
              <p class="card-text">Tabla para administrar a los postulados.</p>
              <button class="btn btn-info" on:click={irPostulados}>Ir</button>
            </div>
          </div>
    </div>
   
</main>

<style>
.container{
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(25rem 1fr));
    gap: 16px;
}
</style>