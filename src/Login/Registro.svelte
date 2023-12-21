<script>
// @ts-nocheck

  //librerias
import axios from "axios";
import Lugar from "../Lugares";
import Swal from 'sweetalert2'

//Componentes
import Spinner from "../Componentes/Spinner.svelte";


let verContra = false;
let verConfirContra = false;
let confirmarContrasena = "";
// let valCorreo = false;
// let contraValidada = false;

let nombre = " ";
let apellido_paterno = "";
let apellido_materno = "";
let correo = "";
let numero = "";
let contrasena = "";
let calle = "";
let CP = "";
let Estado = "";
let Pais = "";
let Num_casa = "";
let resultado = ""; //  almacenar el resultado 

let spinner = false

//Para validar en correo
let correoValido = false
    const validarCorreo = async () => {
        correo = correo.toLowerCase()
        if ( /^\w+([\.\-_]?\w+)*@\w+\.\w+(\.\w+)*$/.test(correo) ) {
            correoValido = true
        } else {
            correoValido = false
        }
    }
//Para validar en contraseña
let claveValida = false
    const validarClave = async () => {
        contrasena = contrasena.trim()
        if ( contarMayusculas(contrasena)>0 && contarMinusculas(contrasena)>0 && contarNumeros(contrasena)>0 && contarEspeciales(contrasena)>0 && contrasena.length>7 ) {
            claveValida =  true
        } else {
            claveValida = false
        }
    }

//Para la confirmacion de contraseña
let claveValida2 = false
    const validarClave2 = async () => {
        contrasena = contrasena.trim()
        if ( contarMayusculas(contrasena)>0 && contarMinusculas(contrasena)>0 && contarNumeros(contrasena)>0 && contarEspeciales(contrasena)>0 && contrasena.length>7 ) {
            claveValida2 =  true
        } else {
            claveValida2 = false
        }
    }



//para validar almenos una de cada una en la contraseña    
const contarMayusculas = (string) =>{
  let out = 0;
  let filtro = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  for (let i=0; i<string.length; i++)
  if (filtro.indexOf(string.charAt(i)) != -1) 
      out++
  return out
};

const contarMinusculas = (string) =>{
  let out = 0;
  let filtro = 'abcdefghijklmnopqrstuvwxyz';
  for (let i=0; i<string.length; i++)
  if (filtro.indexOf(string.charAt(i)) != -1)
      out++
  return out;
};

const contarNumeros = (string) =>{
  let out = 0;
  let filtro = '0123456789';
  for (let i=0; i<string.length; i++)
  if (filtro.indexOf(string.charAt(i)) != -1)
      out++
  return out;
};

const contarEspeciales = (string) =>{
  let out = 0;
  let filtro = '@!#$%&/()=.';
  for (let i=0; i<string.length; i++)
  if(filtro.indexOf(string.charAt(i)) != -1)
      out++
  return out;
};

const registrarUsuario = async () => {
  if (!nombre || !apellido_paterno || !apellido_materno || !correo || !numero || !contrasena || !calle || !CP
  || !Estado || !Pais || !Num_casa) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Es necesario llenar todos los campos!',
      });
  };

if(contrasena !== confirmarContrasena){
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'La contraseña no coincide!',
  });
};
try {
    spinner = true;
    const res = await axios.post(Lugar.backend+"sigInUser.php", {
      nombre,
      apellido_paterno,
      apellido_materno,
      correo,
      numero,
      contrasena,
      calle,
      CP,
      Estado,
      Pais,
      Num_casa,
    });
    spinner = false;
    const data = res.data;

    if (data === "repetido") {
      resultado = "El usuario ya existe en la base de datos.";
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: resultado,
      });
    } else if (data === "success") {
      resultado = "Registrado con éxito.";
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Registrado con éxito',
        showConfirmButton: false,
        timer: 1500,
      });
    } else {
      resultado = "Error desconocido.";
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: resultado,
      });
    }
  } catch (error) {
    console.error("Error al realizar la solicitud:", error);
    resultado = "Error al realizar la solicitud.";
  }
};


  
</script>

<main>
  {#if spinner}
    <Spinner />
  {/if}
    <div class="card">
        <div class="card-header">
          Registro
        </div>
        <div class="card-body">
          <h5 class="card-title" style="text-align: center;">Proporcione la siguiente información</h5>
          

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-circle"></i></span>
            <input type="text" class="form-control" bind:value={nombre} placeholder="Nombre" aria-label="Username" aria-describedby="basic-addon1" required >
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-circle"></i></span>
            <input type="text" class="form-control" bind:value={apellido_paterno} placeholder="Primer apellido" aria-label="Username" aria-describedby="basic-addon1" required >
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-circle"></i></span>
            <input type="text" class="form-control" bind:value={apellido_materno} placeholder="Segundo apellido" aria-label="Username" aria-describedby="basic-addon1" required >
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-phone"></i></span>
            <input type="tel" class="form-control" bind:value={numero} placeholder="Teléfono" aria-label="Amount (to the nearest dollar)" required >
          </div>
          
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon2"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control {correoValido ? 'is-valid' : 'is-invalid'}" bind:value={correo}  on:input={validarCorreo}  placeholder="Correo" aria-label="Recipient's username" aria-describedby="basic-addon2" required >
          </div>

          <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" on:click={()=> (verContra = !verContra)}><i class={verContra ? "bi-eye-slash" : "bi bi-eye"} ></i></button>
            {#if !verContra}
                <input type="password" class="form-control {claveValida ? 'is-valid' : 'is-invalid'}" bind:value={contrasena}  on:input={validarClave} placeholder=" Contraseña" aria-describedby="basic-addon1" required>
            {:else}
                <input type="text" class="form-control {claveValida ? 'is-valid' : 'is-invalid'}" bind:value={contrasena} on:input={validarClave}  placeholder=" Contraseña" aria-describedby="basic-addon1" required>
            {/if}
          </div>
          <!--Confirmar contraseña-->
          <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" on:click={()=> (verConfirContra = !verConfirContra)}><i class={verConfirContra ? "bi-eye-slash" : "bi bi-eye"} ></i></button>
            {#if !verConfirContra}
                <input type="password" class="form-control {claveValida2 ? 'is-valid' : 'is-invalid'}" bind:value={confirmarContrasena} on:input={validarClave2}  placeholder=" Contraseña" aria-describedby="basic-addon1" required>
            {:else}
                <input type="text" class="form-control {claveValida2 ? 'is-valid' : 'is-invalid'}" bind:value={confirmarContrasena} on:input={validarClave2}  placeholder=" Contraseña" aria-describedby="basic-addon1" required>
            {/if}
          </div>
          
          <label for="basic-url" class="form-label">Por favor, proporcione la dirección de su domicilio</label>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon3">Calle:</span>
            <input type="text" class="form-control" bind:value={calle} id="basic-url" aria-describedby="basic-addon3" required >
          </div>
          
          <div class="input-group mb-3">
            <span class="input-group-text">Número de casa:</span>
            <input type="text" class="form-control" bind:value={Num_casa} aria-label="Amount (to the nearest dollar)" required >
          </div>
          
          <div class="input-group mb-3">
            <span class="input-group-text">CP:</span>
            <input type="text" class="form-control" bind:value={CP} aria-label="Amount (to the nearest dollar)" required >
          </div>
          
          <div class="input-group mb-3">
            <span class="input-group-text">Estado:</span>
            <input type="text" class="form-control" bind:value={Estado} aria-label="Amount (to the nearest dollar)" required >
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text">Pais:</span>
            <input type="text" class="form-control" bind:value={Pais} aria-label="Amount (to the nearest dollar)" required >
          </div>

          
          
          <!-- <div class="input-group">
            <span class="input-group-text">With textarea</span>
            <textarea class="form-control" aria-label="With textarea"></textarea>
          </div> -->
          <div class="d-flex justify-content-center">
              <button class="btn btn-info " on:click={registrarUsuario}>Registrarse</button>
          </div>
        </div>
      </div>
</main>

<style>
.card-header{
    text-align: center;
    font-weight: bold;
    text-transform: uppercase;
}
input:invalid {
  border: 1px solid red;
}
</style>