<script>
// @ts-nocheck

import axios from "axios";
import Lugar from "../Lugares";
import Modal from '../Componentes/Modal.svelte'
import Swal from "sweetalert2";

let nombre = "";
let apellido_materno = "";
let apellido_paterno = "";
let correo = "";
let numero = "";
let contrasena = "";
let foto = "";


const RegistrarAdmin = async () =>{
    try {
        const res = await axios.post(Lugar.backend + 'insertarUsuarioAdmin.php', {
            nombre,
            apellido_paterno,
            apellido_materno,
            correo,
            numero,
            contrasena,

        });
    } catch (error) {
        
    }
};

let openModal = false;
const modalOpen = async (data) => {
openModal = false;
}

</script>

<main>
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
            <tbody>
                <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                </tr>
            </tbody>
        </table>
        <div class="boton_agregar">
            <button class="btn btn-success" on:click={() => {openModal = true} }>Agregar Adiministrador</button>
        </div>
        </div>
        {#if openModal == true}
            <Modal
            open={openModal}
            onClosed={(data) => modalOpen(data)}
            modalSize="modal-lg"
            title="Agregar Administrador:"
            saveButtonText="Agregar"
            closeButtonText="Cerrar"
            >

            </Modal>
        {/if}
</main>

<style>

</style>