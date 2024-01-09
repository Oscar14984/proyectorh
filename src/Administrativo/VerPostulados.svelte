<script>
 // @ts-nocheck
// LIBRERIAS O COMPONENTES CON VARIABLE EXTRA
import Spinner from "../Componentes/Spinner.svelte";
let spinner = false
// LIBRERIAS O COMPONENTES SIN VARIABLE EXTRA
import axios from 'axios';
import { saveAs } from 'file-saver';
import Modal from "../Componentes/Modal.svelte";
import { push } from 'svelte-spa-router'
//Scripts
import Lugar from "../Lugares";
// import { idUsuario } from "../idUsuario";
import { idPuesto } from "../idPuesto";
import { idUsuario } from "../idUsuario";
import { verVideo } from "../verVideo";

//FUNCION PARA VER EL ID DE LOS VIDEOS
const setVerIdUsuario = (id_usuario) => {
    idUsuario.update(() => ({
    id_usuario: id_usuario,
  }));
};

//FUNCION PARA VER EL ID_PUESTO
const extraerPuestos = (id_puesto) =>{
  idPuesto.update(() => ({
    id_puesto : id_puesto
  })) 
}

// PAGINADOR
let maxRegsPP = 10
let paginas = 0
let paginaActual = 1
let registroInicial = 1
let registroFinal = 10
let residuo = 0
let pagAd = 0
    
const cambiarMaxRegsPP = () => {
    paginas = Math.floor( rsProfesionistas.length / maxRegsPP )
    residuo = ( rsProfesionistas.length % maxRegsPP )
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
  main()
}

const cambiarPagina = (pagina) => {
    paginaActual = pagina
    registroInicial = (paginaActual * maxRegsPP) - (maxRegsPP - 1)
    registroFinal = paginaActual * maxRegsPP
};

// Para extraer el id_usuario
// Para extraer todos los id_usuario
// let usuarios = [];
// let datosCargados = false;

// const extraerTodosIdUsuario = async () => {
//   if (!datosCargados) {
//     try {
//       const res = await axios.post(Lugar.backend + 'getUsuarios.php');
//       const data = JSON.parse(res.data.d);

//       if (data && data.usuarios) {
//         usuarios = Object.values(data.usuarios);

//         if (usuarios.length > 0) {
//           usuarios.forEach(usuario => {
//             const id_usuario = usuario.id_usuario;
//             console.log(id_usuario);
//             consultarPostulados(id_usuario);
//           });
//           datosCargados = true;
//         } else {
//           console.log("No se encontraron usuarios");
//         }
//       }
//     } catch (error) {
//       console.error("Error al extraer los id_usuario:", error);
//     }
//   } else {
//     console.log("Los datos ya fueron cargados");
//   }
// };
// extraerTodosIdUsuario();

// Para extraer todos los id_puestos
// let dataCargada = false;
// const extraerTodosIdPuestos = async () => {
//   if (!dataCargada) {
//     try {
//       const res = await axios.post(Lugar.backend + 'getPuestosData.php');
//       const data = JSON.parse(res.data.d);

//       if (data && data.puestoSalida) {
//         puestoSalida = Object.values(data.puestoSalida);

//         if (puestoSalida.length > 0) {
//           puestoSalida.forEach(puestoSalida => {
//             const id_puestos = puestoSalida.id_puestos;
//             console.log(id_puestos);
//             postulados(id_puestos);
//           });
//           dataCargada = true;
//         } else {
//           console.log("No se encontraron puestoSalida");
//         }
//       }
//     } catch (error) {
//       console.error("Error al extraer los id_puestos:", error);
//     }
//   } else {
//     console.log("Los datos ya fueron cargados");
//   }
// };
// extraerTodosIdPuestos();

// Para consultar a los postulados
// let jsonSalida = [];
// const consultarPostulados = async (id_usuario) => {
//   try {
//     spinner = true; 
//     const idUsuario = id_usuario;
//     const res = await axios.post(Lugar.backend + 'getPuestosRelacionadosConUsuario.php', {
//       id_usuario: idUsuario 
//     });
//     const data = JSON.parse(res.data.d);
//     spinner = false; 
//     if (res.data && data.jsonSalida) {
//       jsonSalida = Object.values(data.jsonSalida);
//       console.log(jsonSalida);
//     }
//   } catch (error) {
  
//   }
// };

//CONSULTAR PROFESIONISTAS
let tieneProfesionistas = false;
let rsProfesionistas = [];
let cargo = []
const main = async () =>{
spinner = true
const res = await axios.post(Lugar.backend + 'getPuestosDataID.php');
const data = JSON.parse(res.data.d);
spinner = false
  
tieneProfesionistas = data.tieneProfesionistas;
  if (tieneProfesionistas == true) {
    rsProfesionistas = Object.values(data.rsProfesionistas);
  } else {
    rsProfesionistas = "";
  }

  //VERIFICAR SI TIENE USUARIOS
  if(tieneProfesionistas = rsProfesionistas.length > 0){
        paginas = Math.floor( rsProfesionistas.length / maxRegsPP )
        residuo = ( rsProfesionistas.length % maxRegsPP )
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
  
  filtrarPuestosDeTrabajo();
  // obtenerIdUsuario();
};

//FUNCION PARA FILTRAR LOS DATOS DE LOS PUESTOS DE TRABAJO
let puestosFiltrados = [];
const filtrarPuestosDeTrabajo = () => {
 if (tieneProfesionistas && Array.isArray(rsProfesionistas) && rsProfesionistas.length > 0) {
    let titulosUnicos = new Set();
    
    rsProfesionistas.forEach((puesto) => {
      if (!titulosUnicos.has(puesto.titulo)) {
        titulosUnicos.add(puesto.titulo);
        puestosFiltrados.push({
          titulo: puesto.titulo,
          lugar: puesto.lugar,
          fecha_limite: puesto.fecha_limite,
        });
      }
      mostrarDetallePuesto(puesto)
    });
 };
 
 console.log('Para ver los puestos filtrados',puestosFiltrados);
 return puestosFiltrados;
};

//LLAMADO DE LA FUNCION MAIN (PROFESIONISTAS)
main();

//AGREGAR REGISTRO
let id_puesto = "";
let titulo = "";
let descripcion = "";
let fecha_limite = "";
let lugar = "";
let pais = "";
let doctor_solicitante = "";

//DATOS DE USUARIO
let id_usuario = "";
let id_video = "";
let id_doc = "";
let nombre = "";
let localidad = ""
let apellido_paterno = "";
let apellido_materno = "";
let correo = "";
let numero = "";

//FUNCION PARA MOSTRAR LOS DETALLES DE LAS PERSONAS POSTULADOS A UN UESTO ESPECIFICO.
let detallePuestoSeleccionado = [];
const mostrarDetallePuesto = (puesto) => {
  if (tieneProfesionistas && Array.isArray(rsProfesionistas) && rsProfesionistas.length > 0) {
    const idPuestoSeleccionado = puesto.id_puesto; 
    const personasPostuladas = rsProfesionistas.filter(item => item.id_puesto === idPuestoSeleccionado);
    
    detallePuestoSeleccionado = personasPostuladas.map(persona => ({
      nombre: persona.nombre,
      apellido_paterno: persona.apellido_paterno,
      apellido_materno: persona.apellido_materno,
      id_usuario: persona.id_usuario,
    }));
    
    console.log('Para ver las personas postulados a un puesto específico',detallePuestoSeleccionado);
    return detallePuestoSeleccionado;
  }
};

//FUNCION PARA EXTRAER ID_USUARIO
const obtenerIdUsuario = (id_usuarioT) =>{
  id_usuario = id_usuarioT;
  console.log(id_usuario)
  VisibilizarVideos(id_usuarioT)
  openModalVideos = true
};

//FUNCION PARA EXTRAER ID_USUARIO PARA DOCUMENTOS
const obtenerIdUsuarioDocumentos = (id_usuarioT) =>{
  id_usuario = id_usuarioT;
  console.log(id_usuario)
  visibilizarDocumentos(id_usuarioT)
  openDocumento = true
};

//FUNCION PARA EXTRAER EL ID_VIDEO
const obtenerIdVideo = (id_videoT) =>{
  id_video = id_videoT
  console.log(id_video)
  descargarVideo(id_videoT)
}

//FUNCION PARA EXTRAER EL ID_DOC
const obtenerIdDoc = (id_docT) =>{
  id_doc = id_docT
  console.log(id_doc)
  descargarDocumentos(id_docT)
}

//FUNCION PARA VISIBILIZAR VIDEOS
let tieneVideos;
let rsVideos = [];
const VisibilizarVideos = async (id_usuarioT, id_videoT) => {
  try {
    spinner = true
    const res = await axios.post(Lugar.backend + 'getVideosInfo.php', {
      id_usuario: id_usuarioT,
      id_video: id_videoT,
    });
    spinner = false
    const data = JSON.parse(res.data.d);

    if (data && data.rsVideos) {
      rsVideos = Object.values(data.rsVideos);
      console.log('Para ver la info de videos', id_usuarioT, rsVideos);
      tieneVideos = rsVideos.length > 0;
    }
  } catch (error) {
    console.error('Error al obtener los videos:', error);
  }
};

//FUNCION PARA DESCARGAR VIDEOS
const descargarVideo = async (id_videoT) => {
  try {
    const response = await axios.post(Lugar.backend + 'downloadVideo.php', {
      id_video: id_videoT,
    });

    const data = response.data;

    // Crear un blob con el contenido descargado
    const blob = new Blob([data], { type: 'video/mp4' });

    // Guardar el blob como un archivo
    saveAs(blob, data.d.nombre);

    // const localidadMP4 = data.d.localidad.replace('.tmp', '.mp4');

    // const a = document.createElement('a');
    // a.href = localidadMP4;
    // a.download = data.d.nombre;
    // document.body.appendChild(a);
    // a.click();
    // document.body.removeChild(a);

    // const a = document.createElement('a');
    // a.href = data.d.localidad;
    // a.download = data.d.nombre;
    // document.body.appendChild(a);
    // a.click();
    // document.body.removeChild(a);

   } catch (error) {
     console.error('Error al descargar el video:', error);
  }
};

//FUNCIÓN PARA VISIBILIZAR DOCUMENTOS
let tieneDocumentos;
let rsDocumentos = [];
const visibilizarDocumentos = async (id_usuarioT, id_docT) => {
  try {
    spinner = true
    const res = await axios.post(Lugar.backend + 'getDocumentosInfo.php', {
      id_usuario: id_usuarioT,
      id_doc: id_docT,
    });
    spinner = false
    const data = JSON.parse(res.data.d);

    if (data && data.rsDocumentos) {
      rsDocumentos = Object.values(data.rsDocumentos);
      console.log('Para ver la info de documentos', id_usuarioT, rsDocumentos);
      tieneDocumentos = rsDocumentos.length > 0;
    }
  } catch (error) {

  }
};

//FUNCIÓN PARA DESCARGAR DOCUMENTOS
const descargarDocumentos = async (id_docT) => {
  try {
    const res = await axios.post(Lugar.backend + 'downloadDocument.php', {
      id_documento: id_docT,
    });
    const data = res.data;
    
     localidad = data.d.localidad;
     console.log(localidad)
     
     const blob = new Blob([data], { type: 'application/pdf' });
     localidad = URL.createObjectURL(blob);

     
    // const a = document.createElement('a');
    // a.href = data.d.localidad;
    // a.download = data.d.nombre;
    // document.body.appendChild(a);
    // a.click();
    // document.body.removeChild(a);

    // const response = await axios.get(localidad, {
    //   responseType: 'blob' 
    // });

    const linkDescarga = document.createElement('a');
    linkDescarga.href = localidad;
    linkDescarga.download = data.d.nombre; 
    linkDescarga.textContent = 'Haz clic aquí para descargar el archivo';
    document.body.appendChild(linkDescarga);
    linkDescarga.click();


    // saveAs(blob, data.d.nombre);
    
  } catch (error) {
    console.error('Error al descargar el documento:', error);
  }
};

//COMPONENTE MODAL
let openModal = false;
const postulados = async (data) => {
  openModal = false;
  if(data == 'save'){
    try {
      const res = await axios.post(Lugar.backend + 'getPuestoDataIDPuesto.php',{
        id_puesto: id_puestoT
      });
      const data = JSON.parse(res.data.d)
      spinner = false;
      if(res.data && data.jsonSalida){
        jsonSalida = Object.values(data.jsonSalida)
        console.log(jsonSalida)
      }
    } catch (error) {
      
    };
  };
};

//MODAL VIDEOS
let openModalVideos = false;
const setOpenVideo = async (data) => {
  openModalVideos = false;
  if(data == 'save'){

  }
};

//MODAL DOCUMENTOS
let openDocumento = false;
const setOpenDocumento = async (data) => {
  openDocumento = false;
  if(data == 'save'){

  }
};
</script>





<main>
  {#if spinner == true}
     <Spinner />
  {/if}
    <div class="container">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Puesto</th>
              <th scope="col">Lugar</th>
              <th scope="col">Fecha limite</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            {#if tieneProfesionistas == true}
              {#each puestosFiltrados.slice(registroInicial - 1, registroFinal) as puesto,i}
                <tr>
                  <th scope="row">{puesto.titulo}</th>
                  <th scope="row">{puesto.lugar}</th>
                  <th scope="row">{puesto.fecha_limite}</th>
                  <td>
                    <button class="btn btn-success" on:click={() => {openModal = true, cargo = puesto}}>Ver Puestos</button>
                  </td>
                </tr>
              {/each}
            {:else}
              <div><strong>No tiene profesionistas</strong></div>
            {/if}
          </tbody>
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

      {#if tieneProfesionistas }
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
        <!-- Modal para ver a los usuarios -->
          {#if openModal == true}
            <Modal
            open={openModal}
            onClosed={(data) => postulados(data)}
            modalSize="modal-lg"
            title="Ver postulados"
            saveButtonText="ok"
            closeButtonText="cerrar"
            >
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Lugar</th>
                  <th>Nombre</th>
                  <th>Priemr apellido</th>
                  <th>Segundo apellido</th>
                  <th>Acciones Descargar</th>
                </tr>
              </thead>
              <tbody>
                {#each detallePuestoSeleccionado as persona}
                   <tr>
                     <td>{cargo.lugar}</td>
                     <td>{persona.nombre}</td>
                     <td>{persona.apellido_paterno}</td>
                     <td>{persona.apellido_materno}</td>
                     <td>
                       <button class="btn" on:click={() => obtenerIdUsuario(persona.id_usuario)}><i class="bi bi-camera-video"></i></button>
                       <button class="btn" on:click={() => obtenerIdUsuarioDocumentos(persona.id_usuario)}><i class="bi bi-file-earmark-arrow-down"></i></button>
                     </td>
                   </tr>
                {/each}
              </tbody>
            </table>
            </Modal>
          {/if}

          <!-- Modal para ver los videos de los usuarios -->
          {#if openModalVideos == true}
             <Modal
             open={openModalVideos}
             onClosed={(data)=> setOpenVideo (data)}
             modalSize= "modal-lg"
             title= "Ver Videos"
             saveButtonText="ok"
             closeButtonText="Cerrar"
             >
             <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Nombre</th>
                  <th scope="col">Localidad</th>
                  <th scope="col">Descarga</th>
                </tr>
              </thead>
             {#if tieneVideos == true && rsVideos.length > 0}
                {#each rsVideos as rsVideo}
                  <tbody>
                    <tr>
                      <td>{rsVideo.file_name}</td>
                      <td>{rsVideo.localidad}</td>
                      <td><button class="btn btn_descarga" on:click={() => obtenerIdVideo(rsVideo.id_video)}><i class="bi bi-download"></i></button></td>
                    </tr>
                  </tbody>
                {/each}
              {:else}
                <strong>Ningun video para mostrar</strong>
              {/if}
               
              </table>
             </Modal>
          {/if}

          <!-- Modal para ver los documentos de los usuarios -->
          {#if openDocumento == true}
          <Modal
          open={openDocumento}
          onClosed={(data)=>setOpenDocumento(data)}
          modalSize= "modal-lg"
          title= "ver Documentos"
          saveButtonText="ok"
          closeButtonText="Cerrar"
          >
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Localidad</th>
                <th scope="col">Descarga</th>
              </tr>
            </thead>
           {#if tieneDocumentos == true && rsDocumentos.length > 0}
              {#each rsDocumentos as rsDocumento}
                <tbody>
                  <tr>
                    <td>{rsDocumento.file_name}</td>
                    <td>{rsDocumento.localidad}</td>
                    <td><button class="btn btn_descarga" on:click={() => obtenerIdDoc(rsDocumento.id_doc)}><i class="bi bi-download"></i></button></td>
                  </tr>
                </tbody>
              {/each}
            {:else}
              <strong>Ningun documento para mostrar</strong>
            {/if}

            </table>
          </Modal>
          {/if}
    </div>
</main>

<style>
  /* Para los botones de ver videos y documentos */
.btn:hover{
  background-color: green;
  color: white;
}

/* Para el botón de descarga de video */
.btn_descarga{
  border: 1px solid green;
  color: green;
}

.btn_descarga:hover{
  background-color: green;
  color: white;
}
</style>