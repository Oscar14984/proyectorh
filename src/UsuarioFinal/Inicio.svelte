<script>
import CartasVacantes from "../Componentes/CartasVacantes.svelte";
</script>

<main>
    <sectidon>
        <div class="oportunidad ">
            <h1 class="text-info" style="font-size: 3rem; width: 70%; margin-bottom:20px; ">Oportunidades de empleo</h1>
            <p class="mb-4" style="width: 50%; color:black; font-size: 1.5rem;">Siempre estamos buscando personas entusiastas y apasionadas para unirse a nuestro equipo, encuentra la vacante ideal para ti.</p>
            <button class="btn btn-lg btn-success rounded-pill bg-gradient order-0 botonPos" style="margin-left: 25px;">¡Postularse!</button>
        </div>
    </sectidon>
<br>

<div class="bg">
    <img src="./img/bg.png" alt="">
</div>
<!--Imagen de join-->
    <section class="ImgJoin" >
        <img src="./img/come-on-join.png" alt="">
        <div class="container">
            <div class="row align-items-center">
              <div class="col-12 text-center">
                <h6 class="fw-bold fs-3 fs-lg-5 lh-sm text-info">Forma parte de nuestro equipo!</h6>
                <p >Dental Network.</p>
              </div>
            </div>
          </div>
    </section>
    <br>
    <!--Cartas de vacantes-->
    <div class="container cartasVacantes">
        <CartasVacantes />
    </div>

    
</main>

<style>
    .oportunidad{
        width: 100%;
        margin-left: 8%;
        margin-top: 20px;
    }
    .ImgJoin img{
        width: 100%;
        height: auto;
    }
    .cartasVacantes{
        margin-left: 255px;
    }
 @media (min-width: 300px) and (max-width: 900px){
 .cartasVacantes{
   margin: auto;
 }
 .oportunidad{
    margin-left: 3%;
 }
}
   
/* animaciones */
.botonPos:hover{
    animation:jello-horizontal .9s linear both}
     @keyframes jello-horizontal{0%
        {transform:scale3d(1,1,1)}
        30%{transform:scale3d(1.25,.75,1)}
        40%{transform:scale3d(.75,1.25,1)}
        50%{transform:scale3d(1.15,.85,1)}
        65%{transform:scale3d(.95,1.05,1)}
        75%{transform:scale3d(1.05,.95,1)}
        100%{transform:scale3d(1,1,1)}
    }
   
</style>