<script>
    import Router from 'svelte-spa-router';
    import routes from './routes';
    import Menu from './Componentes/Menu.svelte';
    import Footer from './Componentes/Footer.svelte';
    //Verifica si la URL actual no termina con '#/'
    if (window.location.hash !== '#/') {
        window.location.href = '?#' + window.location.hash.slice(1);
    }
</script>

<main>
   
<Menu />
<div class="principal">
    <Router {routes} />
</div>
<Footer />
</main>

<style>
main{
    margin: 0;
    background:url(/img/hero-bg.png); 
    background-position:right top;
    background-size: 50% ;
    background-repeat: no-repeat;
    background-color: white;
    font-family: sans-serif;
    display: grid;
    min-height: 100vh;
    grid-template-rows: auto 1fr auto;
}
.principal{
    margin-bottom: 10px;
}
</style>