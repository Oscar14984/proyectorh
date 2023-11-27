<script>
// @ts-nocheck

  //librerias
import axios from "axios";
import Lugar from "../Lugares";
import Swal from 'sweetalert2'

//Componentes
import Spinner from "../Componentes/Spinner.svelte";


let verContra = false;
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


const correoValido = () => {
        correo=correo.trim()
        correo=correo.toLowerCase()
        correo = validarCorreo(correo)
        if (especialesCorreo(correo)>1) {
          // valCorreo = true
        } else {
          // valCorreo = false
        }
    }

const validarContrasena = (contrasena) => {
  if ( contrasena.length > 7 ) {
            // contraValidada = true
        } else {
            // contraValidada = false
        }
};
//Para validar en correo
const validarCorreo = (string) => {
    let out = '';
    let filtro = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_@.-';
    for (let i=0; i<string.length; i++)
    if (filtro.indexOf(string.charAt(i)) != -1) 
        out += string.charAt(i);
    return out
};
 function especialesCorreo(string){
        let out = 0;
        let filtro = '@.';
        for (let i=0; i<string.length; i++)
        if (filtro.indexOf(string.charAt(i)) != -1) 
            out++
        return out
    }

//para validar almenos una de cada una en la contraseña    
const contarAltas = (string) =>{
  let out = 0;
  let filtro = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  for (let i=0; i<string.length; i++)
  if (filtro.indexOf(string.charAt(i)) != -1) 
      out++
  return out
};

const ContarBajas = (string) =>{
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
  let filtro = '@!#$%&/()=';
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
  spinner = false;
  Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'La contraseña no coincide!',
      });
};
spinner = true;
  try {
    const response = await axios.post(Lugar.backend+"sigInUser.php", {
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

    if (response.data === "insertado") {
      resultado = "Usuario insertado con éxito.";
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Usuario registrado con éxito',
        showConfirmButton: false,
        timer: 1500
      });
      spinner = false;
    } else if (response.data === "repetido") {
      resultado = "El usuario ya existe en la base de datos.";
      spinner = false;
    } else {
      resultado = "Error desconocido.";
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
            <input type="email" class="form-control" bind:value={correo} on:input={correoValido} placeholder="Correo" aria-label="Recipient's username" aria-describedby="basic-addon2" required >
          </div>

          <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" on:click={()=> (verContra = !verContra)}><i class={verContra ? "bi-eye-slash" : "bi bi-eye"} ></i></button>
            {#if !verContra}
                <input type="password" class="form-control" bind:value={contrasena}  pattern="^(?=.*[0-9](?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{8,16})$" placeholder=" Contraseña" aria-describedby="basic-addon1" required>
            {:else}
                <input type="text" class="form-control" bind:value={contrasena} pattern="^(?=.*[0-9](?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{8,16})$" placeholder=" Contraseña" aria-describedby="basic-addon1" required>
            {/if}
          </div>

          <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" on:click={()=> (verContra = !verContra)}><i class={verContra ? "bi-eye-slash" : "bi bi-eye"} ></i></button>
            {#if !verContra}
                <input type="password" class="form-control" bind:value={confirmarContrasena } placeholder=" Contraseña" aria-describedby="basic-addon1" required>
            {:else}
                <input type="text" class="form-control" bind:value={confirmarContrasena } placeholder=" Contraseña" aria-describedby="basic-addon1" required>
            {/if}
          </div>
          
          <label for="basic-url" class="form-label">Por favor, proporcione la dirección de su domicilio</label>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon3">Calle:</span>
            <input type="text" class="form-control" bind:value={calle} id="basic-url" aria-describedby="basic-addon3" required >
          </div>
          
          <div class="input-group mb-3">
            <span class="input-group-text">Número de casa</span>
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
  border: 2px dashed red;
}
</style>