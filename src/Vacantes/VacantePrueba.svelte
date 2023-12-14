<script>
  // @ts-nocheck
// LIBRERIAS O COMPONENTES CON VARIABLE EXTRA
import Spinner from './../Componentes/Spinner.svelte';
let spinner = false;
// LIBRERIAS O COMPONENTES SIN VARIABLE EXTRA
import axios from "axios";
import { onMount } from 'svelte';
import Modal from '../Componentes/Modal.svelte';
import { push } from 'svelte-spa-router';
//SCRIPTS
import Lugar from "../Lugares";
import { session } from "../session";

  
    
//Para exportar el id_usuario cuando hace inicio de sesión.
let idUsuario = null;
idUsuario = $session.id_usuario;
console.log(idUsuario)
  
let tienePuestos;
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
        
      });
      console.log(jsonSalida)
      tienePuestos = jsonSalida.length > 0;
    
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
};

//Para hacer llamada de los puestos
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

//Modal Para ver información de las vacantes
let openModal = false;
let cargo = null;
const modalOpen = async (data) => {
    openModal = false;
    if(data == 'save'){
         
    }
}
//Para mostrar mensaje cuando se pasa el cursor sobre el div de fecha limite
let mostrarMensaje = false;
let mensaje = '';

//Función para registrarse y postularse
const registrarPostular = () =>{
  push('/Registro')
}
  </script>

<main>
    {#if spinner == true}
         <Spinner />
    {/if}
    <h1 class="text-info" style="text-shadow: 1px 1px 2px black;">OPORTUNIDADES DE EMPLEO</h1>
    <p>Siempre estamos buscando personas entusiastas y apasionadas para unirse a nuestro equipo, encuentra la vacante ideal para ti.</p>
    <div class="container">
      {#if tienePuestos}
         {#each jsonSalida as puesto (puesto.id_puesto)}
             <div class="card shadow p-3 mb-5 bg-body rounded">
                 <div class="card-header">
                   Vacante en:
                 </div>
                 <div class="card-body">
                   <h5 class="card-title">{puesto.titulo}</h5>
                   <p class="card-text">{puesto.descripcion}</p>
                   <p class="card-text">{puesto.lugar}</p>
                   <p class="card-text">{puesto.doctor_solicitante}</p>
                   {#if idUsuario == null}
                   <div>
                     <button class="btn btn-warning" on:click={registrarPostular}>¡Regístrate y Postúlate!</button>
                   </div>
                   {:else}
                   <button class="btn btn-info" on:click={() => {openModal = true; cargo = puesto;}}>Información</button>
                   {/if}
                 </div>
                 <div class="card-footer {getFecha(puesto.diferenciaDias)}" style="cursor: pointer;">
                   Fecha limite: {puesto.fecha_limite}
                 </div>
             </div>
         {/each}
      {/if}
    </div>
    <!-- Modal para mostrar información adicional  -->
    {#if openModal == true}
        <Modal
        open={openModal}
        onClosed={(data) => modalOpen(data)}
        modalSize="modal-ms"
        title=" vacante en:"
        saveButtonText="Postularse"
        closeButtonText="Cerrar"
        >
        <h6 class="card-subtitle mt-3 mb-2 text-muted">Requisitos:</h6>
        <ul class="list-group">
          {#each cargo.requisitos as requisito}
              <li class="list-group-item">{requisito.linea}</li>
          {/each}
        </ul>

        <h6 class="card-subtitle mt-3 mb-2 text-muted">Ofrecemos:</h6>
        <ul class="list-group">
          {#each cargo.ofrecemos as ofrecemo}
            <li class="list-group-item">{ofrecemo.linea}</li>
          {/each}
        </ul>

        <h6 class="card-subtitle mt-3 mb-2 text-muted">Funciones Generales:</h6>
        <ul class="list-group">
          {#each cargo.funcionesGenerales as funcionGeneral}
            <li class="list-group-item">{funcionGeneral.linea}</li>
          {/each}
        </ul>

        <h6 class="card-subtitle mt-3 mb-2 text-muted">Habilidades y Conocimientos:</h6>
        <ul class="list-group">
          {#each cargo.habilidadesConocimientos as habilidadConocimiento}
            <li class="list-group-item">{habilidadConocimiento.linea}</li>
          {/each}
        </ul>
        </Modal>
    {/if}

</main>

<style>
    /* colores para del semaforo */
    .verde { background-color: green; color: white;}
    .amarillo { background-color: #FFC107; color: black;}
    .rojo { background-color: red; color: white;}

    .container{
        display:grid;
        grid-template-columns: repeat(auto-fill, minmax(25rem, 1fr));
        grid-auto-rows: auto;
        gap: 20px;
    }
    .card{
        border-top: 4px solid #17a2b8;
    }
    .card-footer:hover::after {
      content: 'Los colores verde, amarillo y rojo indican el estado en que se encuentra el puesto.';
      color: black;
      position: absolute;
      background-color: #ffffff;
      border: 1px solid #ccc;
      padding: 10px;
      min-width: 200px;
      z-index: 100;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
    }
</style>