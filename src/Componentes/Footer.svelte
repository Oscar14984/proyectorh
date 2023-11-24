<script>
let year = new Date().getFullYear();
</script>

<div class=" text-light text-light  footer" style="background-color: #36364B;">
    <div class="container">
      <div class="row flex-center py-4 imgFoter">
        <div class="">
          <img class="imagen" src="https://dentalnetwork.com.mx/img/DentalNetwork_Logo_Color.png" alt="Imagen de ejemplo">
          <h1 class="text-white">Empieza ahora</h1>
        </div>
      </div>

      <div class="row info">
        <div class="formacion">
          <h5 class="mb-5 text-white">Houston, EE.UU</h5>
          <ul class="list-unstyled mb-md-4 mb-lg-0">
            <li class="mb-3"><a class="text-decoration-none" href="https://goo.gl/maps/pXSAZLMTXppj3NQE8" target="_blank">3050 Post Oak Blvd, Suite 510 Houston Tx 77056</a></li>
            <li class="mb-3"><a class="text-decoration-none" href="#!">+52 5527117420</a></li>
            <li class="mb-3"><a class="text-decoration-none" href="#!">contacto@dentalnetwork.com.mx</a></li>
          </ul>
        </div>

        <div class="formacion">
          <h5 class="mb-5 text-white">Bogotá, Colombia</h5>
          <ul class="list-unstyled mb-md-4 mb-lg-0">
            <li class="mb-3"><a class="text-decoration-none" href="https://goo.gl/maps/3JxbW5cjYHaNobd16" target="_blank">Cra. 11 #79-66, Barrio Nogal,Bogotá.</a></li>
            <li class="mb-3"><a class="text-decoration-none" href="#!">6533063 Ext 3063</a></li>
            <li class="mb-3"><a class="text-decoration-none" href="#!">contacto@dentalnetwork.com.mx</a></li>
          </ul>
        </div>

        <div class="formacion">
          <h5 class="mb-5 text-white">CDMX, México</h5>
          <ul class="list-unstyled mb-md-4 mb-lg-0">
            <li class="mb-3"><a class=" text-decoration-none" href="https://goo.gl/maps/aBDQR9XvEPZwenf18" target="_blank">Puebla 237, Roma Nte. Cuauhtemoc</a></li>
            <li class="mb-3"><a class="text-decoration-none" href="#!">+52 5527117420</a></li>
            <li class="mb-3"><a class="text-decoration-none" href="#!">contacto@dentalnetwork.com.mx</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="text-center py-3 bg-dark" >
      &copy; {year} DentalNetwork. Todos los derechos reservados.
    </div>
</div>

<style>
a:hover{
color:white;
}
.info{
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr));
  grid-auto-rows: 200px;
  margin-left: 30px;

}


@media (min-width: 300px) and (max-width: 1000px){
  .footer{
    width: 100%;
  }

  img,h1{
   margin-left: auto;
  }

  img{
    width: 70%;
  }

  .info{
      margin-left: auto;
  }
}

</style>