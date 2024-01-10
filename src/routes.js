// @ts-nocheck
import Inicio from './UsuarioFinal/Inicio.svelte'

//Vacantes
import VacantesMexico from './Vacantes/VacantesMexico.svelte'
import VacantesColombia from './Vacantes/VacantesColombia.svelte'
import VacantesPrueba from './Vacantes/VacantePrueba.svelte'

//login y registro usuarios
import LoginAdmin from './Login/LoginAdmin.svelte'
import Registro from './Login/Registro.svelte'
import Perfiles from './UsuarioFinal/Perfiles.svelte'

//administrativo
import Postulados from './Administrativo/Postulados.svelte'
import VerPostulados from './Administrativo/verPostulados.svelte'
import RegistroPuesto from './Administrativo/RegistroPuesto.svelte'
import RegistrarPuesto from './Administrativo/RegistrarPuesto.svelte'
import InicioAdmin from './Administrativo/InicioAdmin.svelte'
import LoginSuperAdmin from './AdminSuper/LoginSuperAdmin.svelte'
import InicioSuperAdmin from './AdminSuper/InicioSuperAdmin.svelte'
import ExamenTecnico from './ExamenTecnico/ExamenTecnico.svelte'
import Videos from './Administrativo/Videos.svelte'

// Errores
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
    '/Videos':Videos,
    //SuperAdministrativo
    '/Inici0Super@dmin':InicioSuperAdmin,
    '/Rut@S3gur1d@d!2023':LoginSuperAdmin,
    // Errores
    '*': Error404
}

export default routes