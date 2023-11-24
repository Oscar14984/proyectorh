<script>
import axios from "axios";

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
    // Convertir los arrays a formato JSON
    const requisitosJSON = JSON.stringify(requisitos);
    const ofrecemosJSON = JSON.stringify(ofrecemos);
    const funcionesGeneralesJSON = JSON.stringify(funcionesGenerales);
    const habilidadesConocimientosJSON = JSON.stringify(habilidadesConocimientos);

    const response = await axios.post("http://localhost/RECURSOS_HUMANOS_PROYECTO/backend/registrarPuesto.php", {
      titulo,
      descripcion,
      fecha_limite,
      lugar,
      requisitos: requisitosJSON,
      ofrecemos: ofrecemosJSON,
      funciones_generales: funcionesGeneralesJSON,
      habilidades_conocimientos: habilidadesConocimientosJSON,
    });

    console.log(response.data);
    const trimmedData = response.data.trim();
    console.log(trimmedData);

    // Manejar la respuesta del servidor
    estado = response.data;
    } catch (error) {
      // Manejar errores en la petición
    console.error('Error al enviar el formulario:', error);
    // Agregar esto para ver detalles específicos del error en la consola
    console.error(error.response);
    }
  };
  // Llama a la función para enviar el formulario

</script>
<main>
    <h1>Registrar Puesto de Trabajo</h1>
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
      <textarea bind:value={ofrecemos} rows="4" required></textarea>
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

    <button class="btn btn-info" on:click={enviarFormulario}>Registrar Puesto</button>
  </form>
  </main>
  
  <style>
    main {
      max-width: 600px;
      margin: auto;
      padding: 20px;
    }
  
    h1 {
      text-align: center;
      color: #333;
    }
  
    form {
      display: grid;
      gap: 10px;
    }
  
    label {
      display: block;
      margin-bottom: 5px;
      color: #333;
    }
  
    input,
    textarea {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
    }
  
    button {
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      border: none;
      cursor: pointer;
    }
  
    button:hover {
      background-color: #0056b3;
    }
  </style>