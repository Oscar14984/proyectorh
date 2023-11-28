<script>
import axios from "axios";
import Lugar from "../Lugares";

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
</script>

<main>

</main>

<style>

</style>