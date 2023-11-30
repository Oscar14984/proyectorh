<script>
	import { idVideo } from './../idVideo.js';
// @ts-nocheck

import Spinner from './../Componentes/Spinner.svelte';
import axios from "axios";
import Lugar from "../Lugares";
import {verVideo} from '../verVideo'
import { onMount } from 'svelte';


const setVerIdVideo = (id_video) => {
    idVideo.update(() => ({
        id_video: id_video,
    }));
};
let spinner = false
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
        
    }
};

  onMount(() =>{
      consultarVideos();
  });
let localidad = []
  const descargaVideo = async () => {
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
    }
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
                    <button class="btn btn-success" on:click={descargaVideo}>Descargar Video</button>
                </th>
              </tr>
            </tbody>
            {/each}
          </table>
    </div>
</main>

<style>

</style>