import { writable } from "svelte/store";


export const session = writable({
    id_usuario: null,
    nombre: null,
    apellido_paterno: null,
    apellido_materno: null,
    correo:null,
    foto:null,
 });