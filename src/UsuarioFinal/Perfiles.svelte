<script>
// @ts-nocheck

import { onMount } from "svelte";
import { session } from "../session";
import axios from 'axios';
import Lugar from "../Lugares";
import Swal from 'sweetalert2'

  let idUsuario = null; 
  let correoUsuario = null;
  let selectedFile;
  let verTexto = false;
  let file = null;


const mostrarTexto = () =>{
  verTexto = !verTexto;
}

//funcion para seleccionar archivo
function handleFileChange(event) {
    selectedFile = event.target.files[0];
  }

  idUsuario = $session.id_usuario;
  correoUsuario = $session.correo;
  
  //función para subir imagen
  const subirImagen =  async  () => {
    if (selectedFile) {
      const formData = new FormData();
      formData.append('file', selectedFile);
      formData.append('idUsuario', idUsuario);
      formData.append('correoUsuario', correoUsuario);

      try {
        const response = await axios.post(Lugar.backend+'insertProfilePhoto.php', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });

        if (response.status === 200) {
          // La imagen se ha subido correctamente
          Swal.fire({
            title: "Excelente!",
            // text: "!",
            icon: "success"
          });
        }
      } catch (error) {
        // Maneja los errores de la subida de la imagen, si los hay
        console.error('Error al subir la imagen:', error);
      }
    }
  };
  //Función para subir video
  const subirVideo = async () => {
  if (selectedFile) {
    const formData = new FormData();
    formData.append('file', selectedFile);
    formData.append('idUsuario', idUsuario);

    try {
      const response = await axios.post(Lugar.backend+'insertVideo.php', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });

      if (response.status === 200) {
        
        Swal.fire({
          title: "¡Excelente!",
          text: "El video se ha subido correctamente",
          icon: "success"
        });
      }
    } catch (error) {
      // Handle video upload errors
      console.error('Error al subir el video:', error);
    }
  }
};
  //Función para subir documento
  const subirDocumento = async () => {
  if (selectedFile) {
    const formData = new FormData();
    formData.append('file', selectedFile);
    formData.append('idUsuario', idUsuario);

    try {
      const response = await axios.post(Lugar.backend+'insertDocument.php', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });

      if (response.status === 200) {
        
        Swal.fire({
          title: "¡Excelente!",
          text: "El Documento se ha subido correctamente",
          icon: "success"
        });
      }
    } catch (error) {
      // error de subir documento
      console.error('Error al subir el Documento:', error);
    }
  }
};
//barra
let pasoActual = 1;

  const cambiarPaso = (paso) =>{
    pasoActual = paso;
  };
  
</script>

<main>
    <div>
      <h1 class="titulo text-info" style="text-transform: uppercase;">Perfil</h1>
         <div class="card mb-3" style="max-width: 540px;"> <!-- inicio de carta -->
          <div class="row g-0">
            <div class="col-md-4 imagen">
              <label class="image-container" for="file-input" on:mouseenter={mostrarTexto} on:mouseleave={mostrarTexto}>
                <img src={$session.foto} class="card-img-top" alt="...">
                {#if verTexto}
                   <div class="edit-text">Editar</div>
                {/if}
              </label>
              <input type="file" id="file-input" name="img" accept="image/*"  on:change={handleFileChange}>
            </div>
            <div class="col-md-8">
              <div class="card-body ">
                {#if $session}
                  <p>Nombre: {$session.nombre}</p>
                  <p>Apellido Paterno: {$session.apellido_paterno}</p>
                  <p>Apellido Materno: {$session.apellido_materno}</p>
                  <p>Correo Electrónico: {$session.correo}</p>
                  <!-- <p>Foto: {rutaNueva}</p> -->
                  <!-- <img  class="fotoUsuario" src={$session.foto} alt="Imagen de perfil" /> -->
                  
                  <button class="btn btn-info" on:click={subirImagen}>Subir Imagen</button> 
                {:else}
                  <p>No has iniciado sesión.</p>
                {/if}
              </div>
            </div>
          </div>
        </div>
      </div> <!--Fin de la carta-->
      
      <div class="container">
        <h1 class="pendientes text-info" style="margin-top: 4%; margin-left: 10%; ">Pendientes</h1>
        <!-- Barra de progreso -->
        <div class="d-flex justify-content-between">
          {#each [1, 2, 3, 4, 5, 6, 7, 8] as numero (numero)}
            <!-- svelte-ignore a11y-click-events-have-key-events -->
            <!-- svelte-ignore a11y-no-static-element-interactions -->
            <div class={`circulo ${numero <= pasoActual ? 'activo' : ''}`} style="cursor: pointer;" on:click={() => cambiarPaso(numero)}>
              {numero}
            </div>
          {/each}
        </div>
      
        <!-- Contenido según el paso actual -->
        {#if pasoActual === 1}
          <div>
            <h2>Paso 1: Subir Video y Documento</h2>
            <!--  formulario para subir video y documento -->
            <div class="grid-container">
              <!-- para subir videos -->
              <input type="file" id="file-input" name="video" accept="video/*"  on:change={handleFileChange}>
              <button class="btn btn-success" on:click={subirVideo}>Subir video</button>
              <!-- para subir documentos -->
              <input type="file" id="file-input" name="cv" accept="application/pdf" on:change={handleFileChange}>
              <button class="btn btn-success" on:click={subirDocumento}>Subir CV</button>
            </div>
          </div>
        {/if}
      
        {#if pasoActual === 2}
          <div>
            <h2>Paso 2: Descripción Personal</h2>
            <!-- Aquí colocar el formulario para la descripción personal -->
          </div>
        {/if}
      
        <!-- Repite lo mismo para los demás pasos -->
      
      </div>

      <!-- <div>
        <h1 class="pendientes text-info" style="margin-top: 4%; margin-left: 10%; ">Pendientes</h1>
        para subir videos
        <input type="file" id="file-input" name="video" accept="video/*"  on:change={handleFileChange}>
        <button class="btn btn-success" on:click={subirVideo}>Subir video</button>
        para subir documentos
        <input type="file" id="file-input" name="cv" accept="application/pdf" on:change={handleFileChange}>
        <button class="btn btn-success" on:click={subirDocumento}>Subir CV</button>
      </div> -->
</main>

<style>
.titulo{
  border-bottom: 2px solid #65c5f1;
  width: 10%;
  text-shadow: 3px 3px 3px black;
} 

  
.card,.titulo{
  margin-left: 10%;
}
.imagen > input{
  display: none;
}

.card-img-top{
  border-radius: 50% 50% 50% 50%;
  pointer-events: auto;
  margin-top: 15%;
  width: 100%;
}
  /* .image-container{
    width: 100%;
    height: 50%;
  } */

.card-img-top:hover{
  opacity: 0.07;
  -webkit-transition: opacity 500ms;
  -moz-transition: opacity 500ms;
  -o-transition: opacity 500ms;
  -ms-transition: opacity 500ms;
  transition: opacity 500ms;
}
.edit-text {
    position: absolute;
    bottom: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.7);
    color: #fff;
    padding: 5px 10px;
    display: none;
  }
  .image-container:hover .edit-text {
    display: block;
  }

  @media (min-width: 300px) and (max-width: 900px)  {
   .card{
    width: 50%;
  }

  .image-container{
    margin-left: 30%;
  }
}
/* para la barra */
.circulo {
    width: 30px;
    height: 30px;
    background-color: #ccc;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
  }

  .activo {
    background-color: #007bff;
  }

  .grid-container{
    display: grid;
    
    grid-template-columns: repeat(auto-fill, minmax(35rem, 1fr));
    gap: 1rem;
  }
 
</style>