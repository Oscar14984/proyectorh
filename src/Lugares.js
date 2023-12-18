let carpeta = 'PROYECTORH'
let protocol = window.location.protocol
let hostname = window.location.hostname

const Lugar = {
    backend: protocol+'//'+hostname+'/'+carpeta+'/backend/',
}

export default Lugar