<script>
    import axios from 'axios';
    import Lugar from '../Lugares';
    import {link, push} from 'svelte-spa-router' 
    import Swal from 'sweetalert2'
    
    let usuario = '' 
    let usuarioFijo = 'SuperAdmin@2320'
    let contracenaFijo = 'DNSA@2023_info'
    let pass = ''

    let usuarioActual = ''
    let idActual = 0
    let verPass = false
    
   const inicio = () =>{
    try {
        if(usuario === usuarioFijo && pass === contracenaFijo){
            Swal.fire({
            title: "Bienvenido!",
            icon: "success"
            })
            push('/Inici0Super@dmin')
        }else{
            Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El usuario o la contraseña son incorrectas!",
            });
        }
    } catch (error) {
        
    }
   }
    const cerrarSesion = () => {
        usuarioActual = ''
        idActual = 0
        localStorage.clear()
        
        
        push('/')
    };
    </script>
    
    <main class="d-flex justify-content-center">
       
        <form class="container card" style="margin-top: 5%;">
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Usuario</label>
              <input type="text"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" bind:value={usuario}>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Contraseña</label>
              <div class="verPass">
              {#if !verPass}
                 <input type="password" class="form-control pass" id="exampleInputPassword1" bind:value={pass}>
                 <!-- svelte-ignore a11y-click-events-have-key-events -->
                 <!-- svelte-ignore a11y-no-static-element-interactions -->
                 <span on:click={()=> (verPass = !verPass)}><i class={verPass ? "bi bi-eye": "bi bi-eye-slash"}></i></span>
                 {:else}
                 <input type="text" class="form-control pass" id="exampleInputPassword1" bind:value={pass}>
                 <!-- svelte-ignore a11y-click-events-have-key-events -->
                 <!-- svelte-ignore a11y-no-static-element-interactions -->
                 <span on:click={()=> (verPass = !verPass)}><i class={verPass ? "bi bi-eye": "bi bi-eye-slash"}></i></span>
              {/if}
              </div>
            </div>
            <button type="submit" class="btn btn-info" on:click={inicio}>Iniciar Sesión</button>
          </form>
        
    </main>
    
    <style>
    
    </style>