<script>
    import Router from 'svelte-spa-router';
    import routes from './routes';
    import Menu from './Componentes/Menu.svelte';
    import Footer from './Componentes/Footer.svelte';

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