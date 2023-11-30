<script>
import Spinner from './../Componentes/Spinner.svelte';
import axios from "axios";
import Lugar from "../Lugares";
import {verVideo} from '../verVideo'
import { onMount } from 'svelte';

let spinner = false
let infoVideos = [];
const consultarVideos = async (id_usuario) => {
    try {
    spinner = true;
    const res = await axios.post(Lugar.backend + 'getVideosInfo.php',{id_usuario})
    const data = JSON.parse(res.data.d);
    id_usuario = $verVideo.id_usuario;
    if(res.data){
      spinner = true;
      infoVideos = Object.values(data.infoVideos);
      console.log(infoVideos)
    } 
    spinner = false;
    } catch (error) {
        
    }
  };
  onMount(() =>{

      consultarVideos();
  })
const descargaVideo = async () =>{
        try {
        const res = await axios.post(Lugar.backend + 'downloadVideo.php')
            
        const responseData = res.data;

        const localidad = responseData.d.localidad;
        const nombre = responseData.d.nombre;

        console.log('Información de descarga:', localidad, nombre);
        } catch (error) {
            
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
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
              </tr>
            </thead>
            {#each infoVideos as infoVideo(infoVideo.id_videos)}
            <tbody>
              <tr>
                <th >{infoVideo.file_name}</th>
              </tr>
            </tbody>
            {/each}
          </table>
    </div>
</main>

<style>

</style>