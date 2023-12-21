<script>
  //LIBRERIAS O COMPONENTES CON VARIABLES EXTRA
  import Spinner from './Spinner.svelte';
  let spinner = false;
  //LIBRERIAS O COMPONENTES SIN VARIABLES EXTRA
  import Swal from 'sweetalert2';
  import { link, push } from 'svelte-spa-router';
  import axios from 'axios';
  //SCRIPTS
	import { session } from './../session.js';
  import Lugar from '../Lugares.js';
  

  
  let imgaFoto = "";
  let nombreUsuario = "";
  
  let sesion = false;
  let lookPass = false;

const Registro = () =>{
  push('/Registro')
}
// Funcion para hacer log in
let correo = '';
let contrasena = '';
const iniciarSesion = async () => {
  if(!correo || !contrasena){
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Ingresa una un correo y contraseña!',
    });
    return;
  };
    try {
      spinner = true
      const response = await axios.post(Lugar.backend+"logInUser.php", {
        correo,
        contrasena,
      });
      if (response.data) {
        // El inicio de sesión fue exitoso
        Swal.fire('Acceso exitoso');
        push("/");
        sesion = true
        if(response.data.foto){
          const nuevaRuta = response.data.foto.replace("C:/xampp/htdocs", "http://localhost" )
            session.update(_ => ({
              id_usuario:response.data.id_usuario,
              nombre: response.data.nombre,
              apellido_paterno: response.data.apellido_paterno,
              apellido_materno: response.data.apellido_materno,
              correo: response.data.correo,
              foto:nuevaRuta,
            }));
            // Guardar datos de inicio de sesión
            localStorage.setItem('id_usuario', response.data.id_usuario);
            localStorage.setItem('nombre', response.data.nombre);
            localStorage.setItem('apellido_paterno', response.data.apellido_paterno);
            localStorage.setItem('apellido_materno', response.data.apellido_materno);
            localStorage.setItem('correo', response.data.correo);
            localStorage.setItem('foto', nuevaRuta);
        };
        spinner = false
      } else {
        // Mostrar un mensaje de error o manejar el inicio de sesión fallido
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'La contraseña o el correo son incorrectos!',
        });
        spinner = false
      };
    } catch (error) {
      console.error("Error al iniciar sesión:", error);
    };
  };

  //Para mandar al componente perfil
  const perfil = () =>{
    push('/perfil')
  };

//Funcion para hacer cerrar sesión
const desLogueo = () =>{
  sesion = false
  push("/")
};

const enterLogin = e => {
    if (e.charCode === 13) iniciarSesion();
};
</script>

<main style="background-color: rgba(255, 255, 255, 0.2);">
  {#if spinner}
    <Spinner />
  {/if}
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
          <a class="navbar-brand d-flex align-items-center fw-bolder fs-2 fst-italic" href="!#">
            <div class="text-info">DentalNetwork</div>
            <div class="text-warning">Job</div>
        </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" use:link href="/">Inicio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" use:link href="/VacantesMexico">Vacantes México</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" use:link href="/VacantesColombia">Vacantes Colombia</a>
              </li>
             
            </ul> 
            <!--Ocultar botones-->
            {#if !sesion}
            <form class="d-flex" role="search">
              <div class="btn-group " role="group" aria-label="Basic mixed styles example">
                  <button type="button" class="btn btn-info botonInicio" data-bs-toggle="modal" data-bs-target="#exampleModal">{sesion ? "Cerrar Sesión" : "Iniciar sesión"}</button>
                  <button type="button" on:click={Registro} class="btn btn-warning botonRegistro">Registrarse</button>
              </div>
            </form>
            {:else}
            <form class="d-flex" role="search">
              <div class="btn-group " role="group" aria-label="Basic mixed styles example">
                  <button type="button" class="btn btn-danger botonCerrar" on:click={desLogueo} >{sesion ? "Cerrar sesión" : "Iniciar sesión"}</button>
                  <button type="button" class="btn btn-warning botonCerrar" on:click={perfil} >Perfil</button>
              </div>
            </form>
            {/if}
            

          
          </div>
        </div>
      </nav>
      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Inicio de Sesión</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Correo:</label>
                  <input type="email" class="form-control" bind:value={correo}  id="exampleInputEmail1" aria-describedby="emailHelp" on:keypress={enterLogin}>
                </div>
    
                <label for="exampleInputPassword1" class="form-label">Contraseña:</label>
                <div class="input-group mb-3">
                  {#if !lookPass}
                  <input type="password" class="form-control" bind:value={contrasena}  aria-describedby="basic-addon1" on:keypress={enterLogin}>
                  {:else}
                  <input type="text" class="form-control"  bind:value={contrasena}   aria-describedby="basic-addon1" on:keypress={enterLogin}>
                  {/if}
                  <button class="btn btn-outline-secondary" on:click={()=> (lookPass = !lookPass)}><i class="bi {lookPass ? 'bi-eye-fill' : 'bi-eye-fill'} {lookPass ? 'text-danger' : 'text-success'}"></i></button>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" on:click={iniciarSesion}  class="btn btn-primary" data-bs-dismiss="modal">Iniciar Sesión</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
      <!--Fin modal-->
</main>

<style>
main{
  margin-bottom: 10px;
}

.navbar-expand-lg{
  position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      background-color: rgba(149, 230, 255, 0.3);
      /* color: white; */
      text-align: center;
      z-index: 1;
}

@media(min-width: 300px) and (max-width: 1000px){
  .navbar-brand {
    width: 50%;
  }
}
</style>