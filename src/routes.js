// @ts-ignore
import Inicio from './UsuarioFinal/Inicio.svelte'
// @ts-ignore
import VacantesMexico from './Vacantes/VacantesMexico.svelte'
// @ts-ignore
import Login from './Login/Login.svelte'
// @ts-ignore
import Registro from './Login/Registro.svelte'
// @ts-ignore
import VacantesColombia from './Vacantes/VacantesColombia.svelte'
// @ts-ignore
import Perfiles from './Componentes/Perfiles.svelte'
// @ts-ignore
import Postulados from './Administrativo/Postulados.svelte'
// @ts-ignore
import RegistroPuesto from './Administrativo/RegistroPuesto.svelte'
// @ts-ignore
import RegistrarPuesto from './Administrativo/RegistrarPuesto.svelte'
// Errores
// @ts-ignore
import Error404 from "./Errores/Error404.svelte";

const routes ={
    //Usuarios
    '/':Inicio,
    '/Login':Login,
    '/Registro':Registro,
    '/VacantesMexico':VacantesMexico,
    '/VacantesColombia':VacantesColombia,
    '/Perfil':Perfiles,
    //Administrativos
    '/Postulados':Postulados,
    '/RegistroPuesto':RegistroPuesto,
    '/RegistrarPuesto':RegistrarPuesto,
    // Errores
    '*': Error404
}

export default routes