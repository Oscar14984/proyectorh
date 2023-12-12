// @ts-ignore
import Inicio from './UsuarioFinal/Inicio.svelte'
// @ts-ignore

//Vacantes
import VacantesMexico from './Vacantes/VacantesMexico.svelte'
// @ts-ignore
import VacantesColombia from './Vacantes/VacantesColombia.svelte'
// @ts-ignore
import VacantesPrueba from './Vacantes/VacantePrueba.svelte'

//login y registro usuarios
// @ts-ignore
import LoginAdmin from './Login/LoginAdmin.svelte'
// @ts-ignore
import Registro from './Login/Registro.svelte'
// @ts-ignore
import Perfiles from './UsuarioFinal/Perfiles.svelte'

//administrativo
// @ts-ignore
import Postulados from './Administrativo/Postulados.svelte'
// @ts-ignore
import VerPostulados from './Administrativo/verPostulados.svelte'
// @ts-ignore
import RegistroPuesto from './Administrativo/RegistroPuesto.svelte'
// @ts-ignore
import RegistrarPuesto from './Administrativo/RegistrarPuesto.svelte'
// @ts-ignore
import InicioAdmin from './Administrativo/InicioAdmin.svelte'
// @ts-ignore
import LoginSuperAdmin from './AdminSuper/LoginSuperAdmin.svelte'
// @ts-ignore
import InicioSuperAdmin from './AdminSuper/InicioSuperAdmin.svelte'
// @ts-ignore
import ExamenTecnico from './ExamenTecnico/ExamenTecnico.svelte'
// @ts-ignore
import Videos from './Administrativo/Videos.svelte'

// Errores
// @ts-ignore
import Error404 from "./Errores/Error404.svelte";

const routes ={
    //Usuarios
    '/':Inicio,
    '/Registro':Registro,
    '/VacantesMexico':VacantesMexico,
    '/VacantesColombia':VacantesColombia,
    '/VacantesPrueba':VacantesPrueba,
    '/Perfil':Perfiles,
    '/ExamenTecnico':ExamenTecnico,
    //Administrativos
    '/L0gAdm1n':LoginAdmin,
    '/Postulados':Postulados,
    '/VerPostulados':VerPostulados,
    '/RegistroPuesto':RegistroPuesto,
    '/RegistrarPuesto':RegistrarPuesto,
    '/InicioAdmin':InicioAdmin,
    '/Vidos':Videos,
    //SuperAdministrativo
    '/Inici0Super@dmin':InicioSuperAdmin,
    '/Rut@S3gur1d@d!2023':LoginSuperAdmin,
    // Errores
    '*': Error404
}

export default routes