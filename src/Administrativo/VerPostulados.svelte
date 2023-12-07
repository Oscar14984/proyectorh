<script>
 // @ts-nocheck
    // LIBRERIAS O COMPONENTES CON VARIABLE EXTRA
    import Spinner from "../Componentes/Spinner.svelte";
    let spinner = false

    // LIBRERIAS O COMPONENTES SIN VARIABLE EXTRA
    import axios from 'axios';
    import Lugar from "../Lugares";
    import { push } from 'svelte-spa-router'

   let usuarios = []
    //Para extraer el id_usuario
    const extraerIdUsuario = async () =>{
    try {
        const res = await axios.post(Lugar.backend + 'getUsuarios.php');
        const data = JSON.parse(res.data.d);
         if(res.data){
            usuarios = Object.values(data.usuarios);
            console.log(usuarios)

            //verificar si tiene usuarios
              tieneUsuarios = usuarios.length > 0;
              if (tieneUsuarios) {
                
                const idUsuario = usuarios[0].id_usuario;
                
                consultarPostulados(idUsuario);
                console.log(idUsuario)
            }
          } 
      

    } catch (error) {
        // Manejo de errores
    }
};
extraerIdUsuario();
    //Para consultar a los pustulados
    let jsonSalida = [];
const consultarPostulados = async (idUsuario) => {
    try {
        // spinner = true; 
        const res = await axios.post(Lugar.backend + 'getPuestosRelacionadosConUsuario.php', {
            id_usuario: idUsuario // Pasar el id_usuario en la solicitud
          });
          console.log(idUsuario)
        const data = JSON.parse(res.data.d);
        // spinner = false; 
        if (res.data) {
            jsonSalida = Object.values(data.jsonSalida);
            console.log(jsonSalida);
        }
    } catch (error) {
        // Manejo de errores
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
                 <th scope="row">1</th>
                 <td>hola</td>
                 <td>Otto</td>
                 <td>@mdo</td>
               </tr>
             </tbody>
         
          </table>
    </div>
</main>

<style>

</style>