<script>
// @ts-nocheck
//Scrips
import { idVideo } from './../idVideo.js';
import {verVideo} from '../verVideo'
import Lugar from "../Lugares";
//componentes con variables extra
import Spinner from './../Componentes/Spinner.svelte';
let spinner = false
//Componentes sin varables extra
import { onMount } from 'svelte';
import {push} from 'svelte-spa-router'
import axios from "axios";
import Modal from '../Componentes/Modal.svelte';


const setVerIdVideo = (id_video) => {
    idVideo.update(() => ({
        id_video: id_video,
    }));
};

//Función para consultar videos
let tieneVideos;
let infoVideos = [];
const consultarVideos = async () => {
    try {
        spinner = true;
        const id_usuario = $verVideo.id_usuario; // Obtener el id_usuario del store
        const res = await axios.post(Lugar.backend + 'getVideosInfo.php', { id_usuario });
        const data = JSON.parse(res.data.d);
        spinner = false;

        if (res.data) {
            infoVideos = Object.values(data.infoVideos);

            const id_video = infoVideos[0].id_video; 
            
            // Almacena la id_video en el nuevo store
            setVerIdVideo(id_video);
            console.log(infoVideos);
            //verificar si tiene videos
        tieneVideos = infoVideos.length > 0;
            
        }
    } catch (error) {
        
    };
};

  onMount(() =>{
      consultarVideos();
  });

//descarga de video
const descargaVideo = async () => {
   
};

//Función para regresar al menú de postulados
const Regresar = () =>{
    push('/Postulados')
};

//Función para modal de descarga de videos
let openModal = false;
let localidad = []
const descargarVideo = async (data) =>{
    openModal =false;
    if(data == 'save'){
        try {
        const id_video = $idVideo.id_video; // Obtener el id_video del store
        const res = await axios.post(Lugar.backend + 'downloadVideo.php', { id_video });
        const data = JSON.parse(res.data.d);
        if (res.data && id_video) {
            localidad = Object.values(data.localidad);
            // const responseData = res.data;
            // const localidad = responseData.d.localidad;
            // const nombre = responseData.d.nombre;

            console.log('Información de descarga:', localidad);
        } else {
            console.log('No hay id_video disponible para la descarga.');
        }
        } catch (error) {
            // Manejar el error según tus necesidades
        };
    };
}; 

  // Función para descargar el video utilizando la localidad
  const descargarVideoLocalidad = () => {
    if (localidad.localidad) {
      const videoURL = localidad.localidad;

      // Crear un enlace temporal para iniciar la descarga
      const link = document.createElement('a');
      link.href = videoURL;
      link.setAttribute('download', `${localidad.nombre}.mp4`); // Usar el nombre del video obtenido
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    } else {
      console.error('No se pudo obtener la localidad del video.');
    }
  };
</script>

<main>
    {#if spinner == true}
         <Spinner />
    {/if}
    <button on:click={descargarVideoLocalidad}>descarga</button>
    <div class="container">
        <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Nombre video</th>
                <th scope="col">Localidad</th>
                <th scope="col">Acciones</th>
                
              </tr>
            </thead>
            {#if tieneVideos}
                 {#each infoVideos as infoVideo(infoVideo.id_video)}
                 <tbody>
                   <tr>
                     <th >{infoVideo.file_name}</th>
                     <th >{infoVideo.localidad}</th>
                     <th>
                         <button class="btn btn-success" on:click={() => {openModal = true}}>Descargar Video</button>
                     </th>
                   </tr>
                 </tbody>
                 {/each}
            {:else}
                 <p style="border-bottom: 2px solid black;"><strong>Sin videos que mostrar.</strong></p>
            {/if}
            <button class="btn btn-success" on:click={Regresar}>Regresar</button>
          </table>
          {#if openModal == true}
             <Modal
             open={openModal}
             onClosed={(data) => descargarVideo(data)}
             modalSize="modal-ms"
             title=" Descargar video"
             saveButtonText="Descargar"
             closeButtonText="Cerrar"
             >
            <h2>Deseas descarga el video?</h2>
             </Modal>
          {/if}
    </div>
</main>

<style>

</style>