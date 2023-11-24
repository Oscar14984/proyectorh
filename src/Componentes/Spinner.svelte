<script>
    export let tipo = 'border'
    export let color = 'dark'
</script>

<div class="d-flex justify-content-center vertical-centered fondo-transparente">
    <div class="spinner-{tipo} text-{color} loader" role="status">
      <span class="sr-only">Loading...</span>
    </div>
</div>

<style>
    .vertical-centered {
        display: flex;
        align-items: center;
    }

    .fondo-transparente {
		position: fixed;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		margin-top: 0px;
		margin-bottom: 0px;
        z-index: 10000;
	}

    .loader {
        width: 6rem;
        height: 6rem;
    }
</style>