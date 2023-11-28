<script>
// @ts-nocheck

	import { push } from 'svelte-spa-router';
    import axios from 'axios'
    import Lugar from '../Lugares';
import Modal from '../Componentes/Modal.svelte'
    

let ofrecemos = ['Oferta inicial'];
let requisitos = ['Requisito inicial'];
let funcionesGenerales = ['Función general inicial'];
let habilidadesConocimientos = ['Habilidad/conocimiento inicial'];

const agregarOferta = () =>{
  ofrecemos = [...ofrecemos, ''];
}

const eliminarOferta=(index)=> {
  ofrecemos = ofrecemos.filter((_, i) => i !== index);
}

  const agregarRequisito = () =>{
    requisitos = [...requisitos, ''];
  }

  const eliminarRequisito = (index)=> {
    requisitos = requisitos.filter((_, i) => i !== index);
  }

  const agregarFuncionGeneral =()=> {
    funcionesGenerales = [...funcionesGenerales, ''];
  }

  const eliminarFuncionGeneral=(index)=> {
    funcionesGenerales = funcionesGenerales.filter((_, i) => i !== index);
  }

  const agregarHabilidadConocimiento=()=> {
    habilidadesConocimientos = [...habilidadesConocimientos, ''];
  }

  const eliminarHabilidadConocimiento=(index)=> {
    habilidadesConocimientos = habilidadesConocimientos.filter((_, i) => i !== index);
  }

//Para agregar un puesto nuevo
let estado = null;
let titulo= ''
let descripcion= ''
let fecha_limite= ''
let lugar= ''
// let ofrecemos= []
// let requisitos= []
// let funcionesGenerales= []
// let habilidadesConocimientos= []

const enviarFormulario = async () => {
  try {
    // Asegurarse de que las variables sean siempre arrays
    requisitos = Array.isArray(requisitos) ? requisitos : [];
    ofrecemos = Array.isArray(ofrecemos) ? ofrecemos : [];
    funcionesGenerales = Array.isArray(funcionesGenerales) ? funcionesGenerales : [];
    habilidadesConocimientos = Array.isArray(habilidadesConocimientos) ? habilidadesConocimientos : [];
    
    const response = await axios.post(Lugar.backend+"registrarPuesto.php", {
      titulo,
      descripcion,
      fecha_limite,
      lugar,
      requisitos,
      ofrecemos,
      funciones_generales: funcionesGenerales,
      habilidades_conocimientos: habilidadesConocimientos,
    }, {
        headers: {
            'Content-Type': 'application/json',
        },
    });
    // Manejar la respuesta del servidor
    estado = response.data;
    } catch (error) {
      // Manejar errores en la petición
    console.error('Error al enviar el formulario:', error);
    // Agregar esto para ver detalles específicos del error en la consola
    console.error(error.response);
    }
  };
//para ver los puestos
  let tienePuestos;
  let rsPuestos;
  let jsonSalida = []
  const puestos = async () => {
    try {
    const res = await axios.post(Lugar.backend + 'getPuestosData.php')
    const data = JSON.parse(res.data.d);
    // if(tienePuestos){
      jsonSalida = Object.values(data.jsonSalida);
      console.log(jsonSalida)
    // } 
  } catch (error) {
    
  }
  };
  puestos();
  //push a inicio
  const inicio = () =>{
    push('/InicioAdmin')
  }
//modal para ediar
let openModal = false;
let cargo = null;
const modalOpen = async (data) => {
    openModal = false;
};

const editar = () =>{

}
//Eliminar puesto
let id_puesto = 0
const eliminarPuesto = async (id_puestoT) =>{
  try {
    const res = await axios.post(Lugar.backend + 'deletePuesto.php',{
      id_puesto: id_puestoT,
    })
    puestos();
  } catch (error) {
    
  }
}
</script>

<main>
    <div class="container">
      <div class="boton-inicio">
        <button class="btn btn-success" on:click={inicio}>Inicio</button>
      </div>
        <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Titulo</th>
                <th scope="col">Lugar</th>
                <th scope="col">Fecha limite</th>
                <th scope="col">Requisitos</th>
                <th scope="col">Ofrecemos</th>
                <th scope="col">Habilidades Conociminetos</th>
                <th scope="col">Funciones generales</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            
                 {#each jsonSalida as puesto,i}
                     <tbody>
                         <tr>
                             <td>{puesto.titulo}</td>
                             <td>{puesto.lugar}</td>
                             <td>{puesto.fecha_limite}</td>
                             {#each puesto.requisitos as requisito}
                               <td>{requisito.linea}</td>
                             {/each}
                             {#each puesto.ofrecemos as ofrecemo}
                               <td>{ofrecemo.linea}</td>
                             {/each}
                             {#each puesto.funcionesGenerales as funcionesGenerale}
                               <td>{funcionesGenerale.linea}</td>
                             {/each}
                             {#each puesto.habilidadesConocimientos as habilidadesConocimiento}
                               <td>{habilidadesConocimiento.linea}</td>
                             {/each}
                             <td>
                                 <button class="btn btn-info" on:click={() => {openModal = true; cargo = puesto; }}>Editar</button>
                                 <button class="btn btn-info" on:click={eliminarPuesto(puesto.id_puesto)}>Eliminar</button>
                             </td>
                         </tr>
                     </tbody>
                 {/each}
            
          </table>
    </div>

    <div class="container boton">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Agregar nuevo
        </button>
        
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Registrar Puesto de Trabajo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <label>
                            Título del Puesto:
                            <input bind:value={titulo} type="text" required />
                            </label>
                        
                            <label>
                            Descripción:
                            <textarea bind:value={descripcion} rows="4" required></textarea>
                            </label>
                        
                            <label>
                            Fecha Límite:
                            <input bind:value={fecha_limite} type="date" required />
                            </label>
                        
                            <label>
                            Lugar:
                            <input bind:value={lugar} type="text" required />
                            </label>
                        
                            <label>
                            Ofrecemos:
                            <!-- Sección de ofrecemos -->
                                {#each ofrecemos as oferta, index (index)}
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" bind:value={ofrecemos[index]} placeholder="Nueva oferta" />
                                        <button class="btn btn-outline-secondary" type="button" on:click={() => eliminarOferta(index)}>-</button>
                                        {#if index === ofrecemos.length - 1}
                                            <button class="btn btn-outline-secondary" type="button" on:click={agregarOferta}>+</button>
                                        {/if}
                                    </div>
                                {/each}
                            <!-- <input bind:value={ofrecemos} type="text" required /> -->
                            </label>
                        
                            <label>
                            Habilidades y Conocimientos Necesarios:
                            <!-- Sección de habilidades y conocimientos -->
                            {#each habilidadesConocimientos as habilidad, index (index)}
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" bind:value={habilidadesConocimientos[index]} placeholder="Nueva habilidad/conocimiento" />
                                    <button class="btn btn-outline-secondary" type="button" on:click={() => eliminarHabilidadConocimiento( index)}>-</button>
                                    {#if index === habilidadesConocimientos.length - 1}
                                        <button class="btn btn-outline-secondary" type="button" on:click={agregarHabilidadConocimiento}>+</button>
                                    {/if}
                                </div>
                            {/each}
                            </label>
                        
                            <label>
                            Requisitos:
                            <!-- Sección de requisitos -->
                                {#each requisitos as requisito, index (index)}
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" bind:value={requisitos[index]} placeholder="Nuevo requisito" />
                                        <button class="btn btn-outline-secondary" type="button" on:click={() => eliminarRequisito(index)}>-</button>
                                        {#if index === requisitos.length - 1}
                                            <button class="btn btn-outline-secondary" type="button" on:click={ agregarRequisito}>+</button>
                                        {/if}
                                    </div>
                                {/each}
                            </label>
                        
                            <label>
                            Funciones Generales:
                            <!-- Sección de funciones generales -->
                                {#each funcionesGenerales as funcion, index (index)}
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" bind:value={funcionesGenerales[index]} placeholder="Nueva función general" />
                                        <button class="btn btn-outline-secondary" type="button" on:click={() => eliminarFuncionGeneral(index)}>-</button>
                                        {#if index === funcionesGenerales.length - 1}
                                            <button class="btn btn-outline-secondary" type="button" on:click={ agregarFuncionGeneral}>+</button>
                                        {/if}
                                        </div>
                                {/each}
                            </label>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" on:click={enviarFormulario}>Registrar Puesto</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {#if openModal == true}
      <Modal
      open={openModal}
      onClosed={(data) => modalOpen(data)}
      modalSize="modal-xl"
      title=" Editar puesto :"
      saveButtonText="Editar"
      closeButtonText="Cerrar"
      >
     
      </Modal>
    {/if}
</main>

<style>
/* Ajustes generales para el formulario */
form {
    max-width: 500px;
    margin: 0 auto;
}

/* Alineación del título del modal */
.modal-title {
    text-align: center;
}

/* Alineación de etiquetas y campos del formulario */
label {
    display: block;
    margin-bottom: 10px;
}

input,
textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    box-sizing: border-box;
}

/* Estilo para los botones del formulario */
.btn-secondary,
.btn-primary {
    padding: 10px 20px;
    margin-right: 10px;
}

/* Ajuste de estilo para el cuerpo del modal */
.modal-body {
    padding: 20px;

    overflow-y: auto;
    max-height: 400px;
}
</style>