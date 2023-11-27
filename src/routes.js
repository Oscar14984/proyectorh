// @ts-ignore
import Inicio from './UsuarioFinal/Inicio.svelte'
// @ts-ignore
import VacantesMexico from './Vacantes/VacantesMexico.svelte'
// @ts-ignore
import LoginAdmin from './Login/LoginAdmin.svelte'
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
// @ts-ignore
import InicioAdmin from './Administrativo/InicioAdmin.svelte'
// @ts-ignore
import LoginSuperAdmin from './AdminSuper/LoginSuperAdmin.svelte'
// @ts-ignore
import InicioSuperADmin from './AdminSuper/InicioSuperADmin.svelte'
// Errores
// @ts-ignore
import Error404 from "./Errores/Error404.svelte";

const routes ={
    //Usuarios
    '/':Inicio,
    '/Registro':Registro,
    '/VacantesMexico':VacantesMexico,
    '/VacantesColombia':VacantesColombia,
    '/Perfil':Perfiles,
    //Administrativos
    '/L0gAdm1n':LoginAdmin,
    '/Postulados':Postulados,
    '/RegistroPuesto':RegistroPuesto,
    '/RegistrarPuesto':RegistrarPuesto,
    '/InicioAdmin':InicioAdmin,
    //SuperAdministrativo
    '/Inici0Super@dmin':InicioSuperADmin,
    '/Rut@S3gur1d@d!2023':LoginSuperAdmin,
    // Errores
    '*': Error404
}

export default routes