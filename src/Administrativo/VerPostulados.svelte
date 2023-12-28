<script>
 // @ts-nocheck
// LIBRERIAS O COMPONENTES CON VARIABLE EXTRA
import Spinner from "../Componentes/Spinner.svelte";
let spinner = false
// LIBRERIAS O COMPONENTES SIN VARIABLE EXTRA
import axios from 'axios';
import Modal from "../Componentes/Modal.svelte";
import { push } from 'svelte-spa-router'
//Scripts
import Lugar from "../Lugares";
import { idUsuario } from "../idUsuario";
import { idPuesto } from "../idPuesto";

//Funcion para ver el id de los videos
const setVerIdUsuario = (id_usuario) => {
    idUsuario.update(() => ({
    id_usuario: id_usuario,
  }));
};

//Función para ver el id_puestos
const extraerPuestos = (id_puesto) =>{
  idPuesto.update(() => ({
    id_puesto : id_puesto
  })) 
}


// Para extraer el id_usuario
// Para extraer todos los id_usuario
// let usuarios = [];
// let datosCargados = false;

// const extraerTodosIdUsuario = async () => {
//   if (!datosCargados) {
//     try {
//       const res = await axios.post(Lugar.backend + 'getUsuarios.php');
//       const data = JSON.parse(res.data.d);

//       if (data && data.usuarios) {
//         usuarios = Object.values(data.usuarios);

//         if (usuarios.length > 0) {
//           usuarios.forEach(usuario => {
//             const id_usuario = usuario.id_usuario;
//             console.log(id_usuario);
//             consultarPostulados(id_usuario);
//           });
//           datosCargados = true;
//         } else {
//           console.log("No se encontraron usuarios");
//         }
//       }
//     } catch (error) {
//       console.error("Error al extraer los id_usuario:", error);
//     }
//   } else {
//     console.log("Los datos ya fueron cargados");
//   }
// };
// extraerTodosIdUsuario();

// Para extraer todos los id_puestos
// let dataCargada = false;
// const extraerTodosIdPuestos = async () => {
//   if (!dataCargada) {
//     try {
//       const res = await axios.post(Lugar.backend + 'getPuestosData.php');
//       const data = JSON.parse(res.data.d);

//       if (data && data.puestoSalida) {
//         puestoSalida = Object.values(data.puestoSalida);

//         if (puestoSalida.length > 0) {
//           puestoSalida.forEach(puestoSalida => {
//             const id_puestos = puestoSalida.id_puestos;
//             console.log(id_puestos);
//             postulados(id_puestos);
//           });
//           dataCargada = true;
//         } else {
//           console.log("No se encontraron puestoSalida");
//         }
//       }
//     } catch (error) {
//       console.error("Error al extraer los id_puestos:", error);
//     }
//   } else {
//     console.log("Los datos ya fueron cargados");
//   }
// };
// extraerTodosIdPuestos();

// Para consultar a los postulados
// let jsonSalida = [];
// const consultarPostulados = async (id_usuario) => {
//   try {
//     spinner = true; 
//     const idUsuario = id_usuario;
//     const res = await axios.post(Lugar.backend + 'getPuestosRelacionadosConUsuario.php', {
//       id_usuario: idUsuario 
//     });
//     const data = JSON.parse(res.data.d);
//     spinner = false; 
//     if (res.data && data.jsonSalida) {
//       jsonSalida = Object.values(data.jsonSalida);
//       console.log(jsonSalida);
//     }
//   } catch (error) {
  
//   }
// };

//Componente Modal
let openModal = false;
const postulados = async (data) => {
  openModal = false;
  if(data == 'save'){
    try {
      const res = await axios.post(Lugar.backend + 'getPuestoDataIDPuesto.php',{
        id_puesto: idPuesto
      });
      const data = JSON.parse(res.data.d)
      spinner = false;
      if(res.data && data.jsonSalida){
        jsonSalida = Object.values(data.jsonSalida)
        console.log(jsonSalida)
      }
    } catch (error) {
      
    };
  };
};

// Consultar profecionistas
let tieneProfesionistas = false;
let rsProfesionistas = [];
let cargo = []
const profecionistas = async () =>{
spinner = true
const res = await axios.post(Lugar.backend + 'getPuestosDataID.php');
const data = JSON.parse(res.data.d);
spinner = false
  
tieneProfesionistas = data.tieneProfesionistas;
  if (tieneProfesionistas == true) {
    rsProfesionistas = Object.values(data.rsProfesionistas);
  } else {
    rsProfesionistas = "";
  }
  
  filtrarPuestosDeTrabajo()
};

// Función para filtrar los datos de los puestos de trabajo
let puestosFiltrados = [];
const filtrarPuestosDeTrabajo = () => {
 if (tieneProfesionistas && Array.isArray(rsProfesionistas) && rsProfesionistas.length > 0) {
    let titulosUnicos = new Set();
    
    rsProfesionistas.forEach((puesto) => {
      if (!titulosUnicos.has(puesto.titulo)) {
        titulosUnicos.add(puesto.titulo);
        puestosFiltrados.push({
          titulo: puesto.titulo,
          lugar: puesto.lugar,
          fecha_limite: puesto.fecha_limite,
        });
      }
      mostrarDetallePuesto(puesto)
    });
 };
 
 console.log(puestosFiltrados);
 return puestosFiltrados;
};

// Llamado de la función profecionistas
profecionistas();

/**
 * Función para mostrar los detalles de las personas postuladas a un puesto específico.
 * @param {Object} puesto - El objeto del puesto seleccionado del cual se mostrarán los detalles.
 * @returns {Array} - Un array de objetos con los detalles de las personas postuladas al puesto.
 */
let detallePuestoSeleccionado = [];
const mostrarDetallePuesto = (puesto) => {
  if (tieneProfesionistas && Array.isArray(rsProfesionistas) && rsProfesionistas.length > 0) {
    const idPuestoSeleccionado = puesto.id_puesto; 
    const personasPostuladas = rsProfesionistas.filter(item => item.id_puesto === idPuestoSeleccionado);
    
    detallePuestoSeleccionado = personasPostuladas.map(persona => ({
      nombre: persona.nombre,
      apellido_paterno: persona.apellido_paterno,
      apellido_materno: persona.apellido_materno
    }));
    
    console.log(detallePuestoSeleccionado);
    return detallePuestoSeleccionado;
  }
};

</script>

<main>
  {#if spinner == true}
     <Spinner />
  {/if}
    <div class="container">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Puesto</th>
              <th scope="col">Lugar</th>
              <th scope="col">Fecha limite</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            {#if tieneProfesionistas == true}
              {#each puestosFiltrados as puesto,i}
                <tr>
                  <th scope="row">{puesto.titulo}</th>
                  <th scope="row">{puesto.lugar}</th>
                  <th scope="row">{puesto.fecha_limite}</th>
                  <td>
                    <button class="btn btn-success" on:click={() => {openModal = true, cargo = puesto}}>Ver Puestos</button>
                  </td>
                </tr>
              {/each}
            {:else}
              <div><strong>No tiene profesionistas</strong></div>
            {/if}
          </tbody>
        </table>

          {#if openModal == true}
            <Modal
            open={openModal}
            onClosed={(data) => postulados(data)}
            modalSize="modal-lg"
            title="Ver postulados"
            saveButtonText="ok"
            closeButtonText="cerrar"
            >
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Lugar</th>
                  <th>Nombre</th>
                  <th>Priemr apellido</th>
                  <th>Segundo apellido</th>
                  <th>Acciones Descargar</th>
                </tr>
              </thead>
              <tbody>
                {#each detallePuestoSeleccionado as persona}
                   <tr>
                     <td>{cargo.lugar}</td>
                     <td>{persona.nombre}</td>
                     <td>{persona.apellido_paterno}</td>
                     <td>{persona.apellido_materno}</td>
                     <td>
                       <button class="btn"><i class="bi bi-camera-video"></i></button>
                       <button class="btn"><i class="bi bi-file-earmark-arrow-down"></i></button>
                     </td>
                   </tr>
                {/each}
              </tbody>
            </table>
            </Modal>
          {/if}
    </div>
</main>

<style>
.btn:hover{
  background-color: green;
  color: white;
}
</style>