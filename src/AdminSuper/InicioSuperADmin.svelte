<script>
// @ts-nocheck

import axios from "axios";
import Lugar from "../Lugares";
import Swal from "sweetalert2";
//Componentes
import Modal from '../Componentes/Modal.svelte';
import Spinner from "../Componentes/Spinner.svelte";

let nombre = "";
let apellido_materno = "";
let apellido_paterno = "";
let correo = "";
let numero = "";
let contrasena = "";
let foto = "";

let spinner = false;

//Registro de admin
let openModal = false;
const RegistrarAdmin = async (data) =>{
    openModal = false;
    if(data == 'save'){
        spinner = true;
        try {
            const res = await axios.post(Lugar.backend + 'insertarUsuarioAdmin.php', {
                nombre,
                apellido_paterno,
                apellido_materno,
                correo,
                numero,
                contrasena,
                foto,
            });
            if(res.data){
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Administrador registrado con éxito',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        } catch (error) {
            
        }
    }
};
//Consultar Administradores
let tieneAdmins;
let jsonDataUsuariosAdmin =[];
const consultarAdmin = async () =>{
    try {
        const res = await axios.post(Lugar.backend + 'getAdminUser.php')
        const data = JSON.parse(res.data.d);
        if(res.data){
            jsonDataUsuariosAdmin = Object.values(data.jsonDataUsuariosAdmin);
          console.log(jsonDataUsuariosAdmin)
            //verificar si tiene administradores
            tieneAdmins = jsonDataUsuariosAdmin.length > 0
        }
    } catch (error) {
        
    }
};
consultarAdmin();

</script>

<main>
    {#if spinner}
         <Spinner />
    {/if}
    <div class="container">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Primer apellido</th>
                <th scope="col">Segundo apellido</th>
                <th scope="col">Correo</th>
                <th scope="col">Número</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody>
                {#if tieneAdmins}
                     <!-- content here -->
                     {#each jsonDataUsuariosAdmin as admin}
                          <tr>
                              <th >{admin.nombre}</th>
                              <th >{admin.apellido_paterno}</th>
                              <th >{admin.apellido_materno}</th>
                              <th >{admin.correo}</th>
                              <th >{admin.numero}</th>
                              <th>
                                <button class="btn btn-success">Editar</button>
                                <button class="btn btn-success">Eliminar</button>
                              </th>
                          </tr>
                     {/each}
                {/if}
            </tbody>
        </table>
        <div class="boton_agregar">
            <button class="btn btn-success" on:click={() => {openModal = true} }>Agregar Adiministrador</button>
        </div>
        </div>
        {#if openModal == true}
            <Modal
            open={openModal}
            onClosed={(data) => RegistrarAdmin(data)}
            modalSize="modal-md"
            title="Agregar Administrador:"
            saveButtonText="Agregar"
            closeButtonText="Cerrar"
            >
                <form >
                    <!-- svelte-ignore a11y-label-has-associated-control -->
                    <label>Nombre:</label>
                    <input bind:value={nombre} />
                    <!-- svelte-ignore a11y-label-has-associated-control -->
                    <label>Primer apellido:</label>
                    <input bind:value={apellido_paterno} />
                    <!-- svelte-ignore a11y-label-has-associated-control -->
                    <label>Segundo apellido:</label>
                    <input bind:value={apellido_materno} />
                    <!-- svelte-ignore a11y-label-has-associated-control -->
                    <label>Correo:</label>
                    <input bind:value={correo} />
                    <!-- svelte-ignore a11y-label-has-associated-control -->
                    <label>Contraseña:</label>
                    <input bind:value={contrasena} />
                    <!-- svelte-ignore a11y-label-has-associated-control -->
                    <label>Número:</label>
                    <input bind:value={numero} />
                </form>
            </Modal>
        {/if}
</main>

<style>
/* Ajustes generales para el formulario */
form {
    max-width: 500px;
    margin: 0 auto;
}

/* Alineación de etiquetas y campos del formulario */
label {
    display: block;
    margin-bottom: 10px;
}
input{
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    box-sizing: border-box;
}
</style>