<script>
    //componentes de js
import { idVideo } from './../idVideo.js';
import {verVideo} from '../verVideo'
//componentes con variables extra
import Spinner from './../Componentes/Spinner.svelte';
import Modal from '../Componentes/Modal.svelte';
//Componentes sin varables extra
import { onMount } from 'svelte';
import {push} from 'svelte-spa-router'
// @ts-nocheck
import axios from "axios";
import Lugar from "../Lugares";

let spinner = false

const setVerIdVideo = (id_video) => {
    idVideo.update(() => ({
        id_video: id_video,
    }));
};
//Función para consultar videos
let infoVideos = [];
const consultarVideos = async () => {
    try {
        spinner = true;
        const id_usuario = $verVideo.id_usuario; // Obtener el id_usuario del store
        const res = await axios.post(Lugar.backend + 'getVideosInfo.php', { id_usuario });
        const data = JSON.parse(res.data.d);

        if (res.data) {
            spinner = true;
            infoVideos = Object.values(data.infoVideos);

            const id_video = infoVideos[0].id_video; 
            
            // Almacena la id_video en el nuevo store
            setVerIdVideo(id_video);
            console.log(infoVideos);
            
        }
        spinner = false;
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
const modalOpen = async (data) =>{
    openModal =false;
    if(data == 'save'){
        try {
        const id_video = $idVideo.id_video; // Obtener el id_video del store
        const res = await axios.post(Lugar.backend + 'downloadVideo.php', { id_video });
        const data = JSON.parse(res.data.d);
        if (res.data&& id_video) {
            localidad = Object.values(data.localidad);
            // const responseData = res.data;
            // const localidad = responseData.d.localidad;
            // const nombre = responseData.d.nombre;

            // console.log(localidad)
            // console.log(nombre)
            console.log('Información de descarga:', localidad);
        } else {
            console.log('No hay id_video disponible para la descarga.');
        }
        } catch (error) {
            // Manejar el error según tus necesidades
        };
    };
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
                <th scope="col">Nombre video</th>
                <th scope="col">Localidad</th>
                <th scope="col">Acciones</th>
                
              </tr>
            </thead>
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
            <button class="btn btn-success" on:click={Regresar}>Regresar</button>
          </table>
          {#if openModal ==true}
             <Modal
             open={openModal}
             onClosed={(data) => modalOpen(data)}
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