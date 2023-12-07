<script>
 // @ts-nocheck
    // LIBRERIAS O COMPONENTES CON VARIABLE EXTRA
    import Spinner from "../Componentes/Spinner.svelte";
    let spinner = false

    // LIBRERIAS O COMPONENTES SIN VARIABLE EXTRA
    import axios from 'axios';
    import Lugar from "../Lugares";
    import { push } from 'svelte-spa-router'
    import { idUsuario } from "../idUsuario";

const setVerIdUsuario = (id_usuario) => {
    idUsuario.update(() => ({
    id_usuario: id_usuario,
  }));
};

let usuarios = [];

// Para extraer el id_usuario
// const extraerIdUsuario = async () => {
//   try {
//     const res = await axios.post(Lugar.backend + 'getUsuarios.php');
//     const data = JSON.parse(res.data.d);

//     if (data && data.usuarios) {
//       usuarios = Object.values(data.usuarios);

//       if (usuarios.length > 0) {
//         const id_usuario = usuarios[0].id_usuario;
//         setVerIdUsuario(id_usuario);
//         console.log(id_usuario);
//         consultarPostulados(id_usuario);
//       } else {
//         console.log("No se encontraron usuarios");
//       }
//     }
//   } catch (error) {
//     console.error("Error al extraer el id_usuario:", error);
//   }
// };

// Para consultar a los postulados
let jsonSalida = [];
const consultarPostulados = async () => {
  try {
    // console.log(id_usuario); // Mostrar el id_usuario
    // spinner = true; 
    const idUsuario = 60;
    const res = await axios.post(Lugar.backend + 'getPuestosRelacionadosConUsuario.php', {
      id_usuario: idUsuario // Pasar el id_usuario en la solicitud
    });
    const data = JSON.parse(res.data.d);
    // spinner = false; 
    if (res.data && data.jsonSalida) {
      jsonSalida = Object.values(data.jsonSalida);
      console.log(jsonSalida);
    }
  } catch (error) {
    // Manejo de errores
    console.error("Error al consultar los postulados:", error);
  }
};
consultarPostulados();



</script>

<main>
  {#if spinner == true}
     <Spinner />
  {/if}
    <div class="container">
        <table class="table table-hover">
          {#each jsonSalida as puestos (puestos.id_puesto)}
             <thead>
               <tr>
                 <th scope="col"></th>
                 <th scope="col">First</th>
                 <th scope="col">Last</th>
                 <th scope="col">Handle</th>
               </tr>
             </thead>
             <tbody>
               <tr>
                 <th scope="row">{puestos.titulo}</th>
                 <td>hola</td>
                 <td>Otto</td>
                 <td>@mdo</td>
               </tr>
             </tbody>
          {/each}
          </table>
    </div>
</main>

<style>

</style>