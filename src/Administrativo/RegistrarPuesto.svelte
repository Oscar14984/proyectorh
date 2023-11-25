<script>
    import axios from 'axios'
    import Lugar from '../Lugares';

// let ofertas = ['Oferta inicial'];

// function agregarOferta() {
//     ofertas = [...ofertas, ''];
//     actualizarOfrecemos();
//   }

//   function eliminarOferta(index) {
//     ofertas = ofertas.filter((_, i) => i !== index);
//     actualizarOfrecemos();
//   }

//   function actualizarOfrecemos() {
//     ofrecemos = ofertas.join('; ');
//   }

//Para agregar un puesto nuevo
let estado = null;
let titulo= ''
let descripcion= ''
let fecha_limite= ''
let lugar= ''
let requisitos= []
let ofrecemos= []
let funcionesGenerales= []
let habilidadesConocimientos= []

const enviarFormulario = async () => {
  try {
    const response = await axios.post(Lugar.backend+"registrarPuesto.php", {
      titulo,
      descripcion,
      fecha_limite,
      lugar,
      requisitos,
      ofrecemos,
      funciones_generales: funcionesGenerales,
      habilidades_conocimientos: habilidadesConocimientos,
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
  const puestos = async () => {
    const res = await axios.post(Lugar.backend+'getPuestosData.php');
    const data = JSON.parse(res.data.d);
    tienePuestos = data.tienePuestos;
    if (tienePuestos == true ) {
      rsPuestos = Object.values(data.rsPuestos);
    } else {
      rsPuestos = "";
    }
  };
  puestos();
</script>

<main>
    <div class="container">
        <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Titulo</th>
                <th scope="col">Lugar</th>
                <th scope="col">Fecha limite</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            {#if tienePuestos}
                 {#each rsPuestos as puesto(puesto.id_puesto)}
                     <tbody>
                         <tr>
                             <td>{puesto.titulo}</td>
                             <td>{puesto.lugar}</td>
                             <td>{puesto.fecha_limite}</td>
                             <td>
                                 <button class="btn btn-info">Editar</button>
                                 <button class="btn btn-info">Eliminar</button>
                             </td>
                         </tr>
                     </tbody>
                 {/each}
            {/if}
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
                            <!-- {#each ofertas as oferta, index (index)}
                                <div class="input-group mb-3">
                                <input type="text" class="form-control" bind:value={oferta} placeholder="Nueva oferta" />
                                <button class="btn btn-outline-secondary" type="button" on:click={() => eliminarOferta(index)}>-</button>
                                {#if index === ofertas.length - 1}
                                    <button class="btn btn-outline-secondary" type="button" on:click={agregarOferta}>+</button>
                                {/if}
                                </div>
                            {/each} -->
                            <input bind:value={ofrecemos} type="text" required />
                            </label>
                        
                            <label>
                            Habilidades y Conocimientos Necesarios:
                            <textarea bind:value={habilidadesConocimientos} rows="4" required></textarea>
                            </label>
                        
                            <label>
                            Requisitos:
                            <textarea bind:value={requisitos} rows="4" required></textarea>
                            </label>
                        
                            <label>
                            Funciones Generales:
                            <textarea bind:value={funcionesGenerales} rows="4" required></textarea>
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