<script>
// @ts-nocheck
//Librerias o componentes con variables extra
import Spinner from './../Componentes/Spinner.svelte';
let spinner = false;
//Librerias o componentes sin variables extra
import { push } from 'svelte-spa-router';
import axios from "axios";
import { verVideo } from '../verVideo';
//Scrips
import Lugar from '../Lugares';

//Función para cargar a los usuarios
let tieneUsuarios;
let usuarios = [];
const cargarUsuarios = async () => {
    try {
    spinner = true;
    const res = await axios.post(Lugar.backend + 'getUsuarios.php')
    const data = JSON.parse(res.data.d);
    spinner = false;
    if(res.data){
      usuarios = Object.values(data.usuarios);
      console.log(usuarios)
      
      //verificar si tiene usuarios
      if(tieneUsuarios = usuarios.length > 0){
        paginas = Math.floor( usuarios.length / maxRegsPP )
        residuo = ( usuarios.length % maxRegsPP )
        if ( residuo > 0 ) {
            pagAd = 1
        } else {
            pagAd = 0
        }
            paginas = paginas + pagAd
            paginaActual = 1
            registroInicial = 1
            registroFinal = maxRegsPP
        } 
    }
  } catch (error) {
    
  }
};
cargarUsuarios();

// PAGINADOR
let maxRegsPP = 10
    let paginas = 0
    let paginaActual = 1
    let registroInicial = 1
    let registroFinal = 10
    let residuo = 0
    let pagAd = 0
    
    const cambiarMaxRegsPP = () => {
        paginas = Math.floor( usuarios.length / maxRegsPP )
        residuo = ( usuarios.length % maxRegsPP )
        if ( residuo > 0 ) {
            pagAd = 1
        } else {
            pagAd = 0
        }
        paginas = paginas + pagAd
        paginaActual = 1
        registroInicial = 1
        registroFinal = maxRegsPP
    }

    const cambiarEstatus = () => {
        cargarUsuarios()
    }

    const cambiarPagina = (pagina) => {
        paginaActual = pagina
        registroInicial = (paginaActual * maxRegsPP) - (maxRegsPP - 1)
        registroFinal = paginaActual * maxRegsPP
    };

    //boton para ir a inicio
    const inicio = () =>{
        push('/InicioAdmin')
    }
    //Para guardar el id_usuario en el scrip de verVideos
    const verVideos = (id_usuario) =>{
        push('/Videos')
        verVideo.update( ()=> ({
            id_usuario:id_usuario,
        }));
    };

//Funcion para filtar nombres de usuarios
let terminoBusqueda = '';
const filtrarUsuarios = () =>{
    return usuarios.filter(usuario =>
      usuario.nombre.toLowerCase().includes(terminoBusqueda.toLowerCase()) ||
      usuario.apellido_paterno.toLowerCase().includes(terminoBusqueda.toLowerCase()) ||
      usuario.apellido_materno.toLowerCase().includes(terminoBusqueda.toLowerCase()) ||
      usuario.correo.toLowerCase().includes(terminoBusqueda.toLowerCase()) ||
      usuario.numero.toLowerCase().includes(terminoBusqueda.toLowerCase())
    );
};

</script>

<main>
    {#if spinner == true}
         <Spinner />
    {/if}

<div class="container">
    <div class="boton-inicio">
        <button class="btn btn-success" on:click={inicio}>Inicio</button>
    </div>

    <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Buscar</button>
    </form>

    <table class="table table-hover" on:change="{cambiarEstatus}">
        <thead>
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Primer Apellido</th>
            <th scope="col">Segundo Apellido</th>
            <th scope="col">Correo</th>
            <th scope="col">Número</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        {#each  usuarios.slice(registroInicial - 1, registroFinal) as usuario (usuario.id_usuario)}
            <tbody>
                <tr>
                    <td>{usuario.nombre}</td>
                    <td>{usuario.apellido_paterno}</td>
                    <td>{usuario.apellido_materno}</td>
                    <td>{usuario.correo}</td>
                    <td>{usuario.numero}</td>
                    <td>
                    
                    <button class="btn btn-success" on:click={() => verVideos(usuario.id_usuario)}>Ver Videos</button>
                    <button class="btn btn-success" >Ver Documentos</button>
                    <button class="btn borrar" ><i class="bi bi-trash3"></i></button>
                    </td>
                </tr>
            </tbody>
        {/each}
        </table>

        <div class="col-6 col-lg-4 col-xxl-3">
            <div class="input-group mb-3 bg-light">
                <span class="input-group-text"><strong>Registros por página:</strong></span>
                <select class="form-select" bind:value={maxRegsPP} on:change="{cambiarMaxRegsPP}">
                    <option value={10}>10</option>
                    <option value={20}>20</option>
                    <option value={50}>50</option>
                </select>
            </div>
        </div>

        {#if tieneUsuarios }
            <div class="input-group mb-1">
                <div role="group">
                    {#if paginaActual != 1}
                        <button type="button" class="btn btn-primary" on:click={()=>cambiarPagina(1)}>{'<<'}</button>
                    {:else}
                        <button type="button" class="btn btn-primary" disabled>{'<<'}</button>
                    {/if}
                    {#if paginaActual != 1}
                        <button type="button" class="btn btn-primary" on:click={()=>cambiarPagina(paginaActual-1)}>{'<'}</button>
                    {:else}
                        <button type="button" class="btn btn-primary" disabled>{'<'}</button>
                    {/if}
                    {#each Array(paginas) as _, i}
                        {#if i+1 == paginaActual - 1 || i+1 == paginaActual || i+1 == paginaActual + 1}
                            <button type="button" class="btn {paginaActual == i+1 ? 'btn-primary' : 'btn-light'}" on:click={()=>cambiarPagina(i+1)}>{i+1}</button>
                        {/if}
                    {/each}
                    {#if paginaActual < paginas}
                        <button type="button" class="btn btn-primary" on:click={()=>cambiarPagina(paginaActual+1)}>{'>'}</button>
                    {:else}
                        <button type="button" class="btn btn-primary" disabled>{'>'}</button>
                    {/if}
                    {#if paginaActual < paginas}
                        <button type="button" class="btn btn-primary" on:click={()=>cambiarPagina(paginas)}>{'>>'}</button>
                    {:else}
                        <button type="button" class="btn btn-primary" disabled>{'>>'}</button>
                    {/if}
                </div>
            </div>
        {/if}

    </div>
</main>

<style>
.table{
    background-color: rgb(198, 244, 255);
}

/* Boton para borrar */
.borrar{
  border: 1px solid red;
  color: red;
}
.borrar:hover{
  background-color: red;
  color: white;
}
</style>