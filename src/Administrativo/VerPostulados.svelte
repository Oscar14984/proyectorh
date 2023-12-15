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

let usuarios = [];

// Para extraer el id_usuario
// Para extraer todos los id_usuario
let datosCargados = false;

const extraerTodosIdUsuario = async () => {
  if (!datosCargados) {
    try {
      const res = await axios.post(Lugar.backend + 'getUsuarios.php');
      const data = JSON.parse(res.data.d);

      if (data && data.usuarios) {
        usuarios = Object.values(data.usuarios);

        if (usuarios.length > 0) {
          usuarios.forEach(usuario => {
            const id_usuario = usuario.id_usuario;
            console.log(id_usuario);
            consultarPostulados(id_usuario);
          });
          datosCargados = true;
        } else {
          console.log("No se encontraron usuarios");
        }
      }
    } catch (error) {
      console.error("Error al extraer los id_usuario:", error);
    }
  } else {
    console.log("Los datos ya fueron cargados");
  }
};

extraerTodosIdUsuario();

// Para consultar a los postulados
let jsonSalida = [];
const consultarPostulados = async (id_usuario) => {
  try {
    // console.log(id_usuario); // Mostrar el id_usuario
    spinner = true; 
    const idUsuario = id_usuario;
    const res = await axios.post(Lugar.backend + 'getPuestosRelacionadosConUsuario.php', {
      id_usuario: idUsuario // Pasar el id_usuario en la solicitud
    });
    const data = JSON.parse(res.data.d);
    spinner = false; 
    if (res.data && data.jsonSalida) {
      jsonSalida = Object.values(data.jsonSalida);
      console.log(jsonSalida);
    }
  } catch (error) {
    // Manejo de errores
    console.error("Error al consultar los postulados:", error);
  }
};

//Componente Modal
let openModal = false;
const postulados = async () => {
  openModal = false;
  if(data == 'save'){
    try {
      const res = await axios.post(Lugar.backend + 'getPuestoDataIDPuesto.php',{
        id_puesto: idPuesto
      });
      const data = JSON.parse(res.data.d)
    } catch (error) {
      
    }
  }
}
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
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          {#each jsonSalida as puestos (puestos.id_puesto)}
             <tbody>
               <tr>
                 <th scope="row">{puestos.titulo}</th>
                 <td>
                  <button class="btn btn-success" on:click={()=> {openModal = true}}>Ver postulados</button>
                 </td>
               </tr>
             </tbody>
          {/each}
          </table>
          {#if openModal == true}
          <Modal
          open={openModal}
          onClose={(data)=>postulados(data)}
          modalSize="model-ms"
          title="Ver postulados"
          saveButtonText="ok"
          closeButtonText="cerrar"
          >
      
          </Modal>
          {/if}
    </div>
</main>

<style>

</style>