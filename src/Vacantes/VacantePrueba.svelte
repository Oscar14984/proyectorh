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
    <div class="container">
        <h1 class="text-info" style="text-shadow: 1px 1px 2px black;">OPORTUNIDADES DE EMPLEO</h1>
        <p>Siempre estamos buscando personas entusiastas y apasionadas para unirse a nuestro equipo, encuentra la vacante ideal para ti.</p>
        {#each jsonSalida as puesto (puesto.id_puesto)}
        <div class="grid-container">
            <div class="card">
                <div class="card-header">
                  Vacante:
                </div>
                <div class="card-body">
                  <h5 class="card-title">{puesto.titulo}</h5>
                  <p class="card-text">{puesto.descripcion}</p>
                  <p class="card-text">{puesto.fecha_limite}</p>
                  <button class="btn btn-success">Información</button>
                </div>
            </div>
        </div>
        {/each}
    </div>
    

</main>

<style>
    .grid-container{
        display:grid;
        grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr));
        grid-auto-rows: auto;
        gap: 20px;
    }
    .card{
        border-top: 4px solid #17a2b8;
    }
</style>