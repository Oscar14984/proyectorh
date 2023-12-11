<script>
import axios from 'axios';
import Lugar from '../Lugares';
import { push} from 'svelte-spa-router' 
import Swal from 'sweetalert2'

let correo = '' 
let correoValido = false
let contrasenaValida = false
let contrasena = ''
let usuarioActual = ''
let idActual = 0
let lookPass = false

async function iniciarSesion() {
    try {
      const response = await axios.post(Lugar.backend+"logInAdmin.php", {
        correo,
        contrasena,
      });
   
      if (response.data) {
        // El inicio de sesión fue exitoso, puedes redirigir al usuario o realizar otras acciones aquí
        Swal.fire('Acceso exitoso')
        push('/InicioAdmin')
      } else {
        // Mostrar un mensaje de error o manejar el inicio de sesión fallido
        console.log("Inicio de sesión fallido");
      }
    } catch (error) {
      console.error("Error al iniciar sesión:", error);
    }
  };

// const login = async () => {
//         const res = await axios.post('http://localhost/RECURSOS_HUMANOS_PROYECTO/backend/logInUser.php', {
//             correo: correo,
//             contrasena: contrasena
//         })
//         const data = JSON.parse( res.data.d )
//         if ( data.correoExistente == 1 ) {
//             usuarioActual = data.nombre
//             idActual = parseInt(data.id_usuario)
//             localStorage.setItem('idActual',idActual.toString())
//             localStorage.setItem('usuarioActual',usuarioActual)
//             Swal.fire('Acceso exitoso')
            
//         } else {
//             Swal.fire('El correo no existe en nuestra base de datos.')
//         }
//     };

    const cerrarSesion = () => {
        usuarioActual = ''
        idActual = 0
        localStorage.clear()
        
        
        push('/')
    };
</script>

<main class="d-flex justify-content-center">
    <div class="card" style="width: 25rem;">
        <div class="card-header">
          Iniciar Sesión
        </div>
        <div class="card-body">
          <form>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Correo:</label>
              <input type="email" class="form-control" bind:value={correo} placeholder="Correo" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>

            <label for="exampleInputPassword1" class="form-label">Contraseña:</label>
            <div class="input-group mb-3">
              {#if !lookPass}
              <!-- content here -->
              <input type="password" class="form-control" bind:value={contrasena} aria-describedby="basic-addon1">
              {:else}
              <!-- else content here -->
              <input type="text" class="form-control"  bind:value={contrasena} aria-describedby="basic-addon1">
              {/if}
              <button class="btn btn-outline-secondary" on:click={()=> (lookPass = !lookPass)}><i class={lookPass ? "bi-eye-slash" : "bi bi-eye"} ></i></button>
            </div>

            <div class="d-flex justify-content-center">
                <button type="button" on:click={iniciarSesion} class="btn btn-primary ">Iniciar</button>
            </div>
          </form>
        </div>
      </div>
    
</main>

<style>

</style>