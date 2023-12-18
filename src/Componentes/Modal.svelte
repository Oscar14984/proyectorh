<script>
    import { fade, fly } from "svelte/transition"
    import { quintOut } from "svelte/easing"
    import { createEventDispatcher } from 'svelte'
    let dispatch = createEventDispatcher()
  
    export let open = false
    export let showBackdrop = true
    export let onClosed
    export let title = 'Modal title'
    export let cancelButton = "on"
    export let closeButtonText = "Close"
    export let saveButton = "on"
    export let saveButtonText = "Save changes"
    export let denyButton = "off"
    export let denyButtonText = "Deny"
    export let modalSize = "modal-md" // modal-sm, modal-md, modal-lg, modal-xl
  
    export const closeModal = () => {
        dispatch('modalClose')
    }
  
    const modalClose = (data) => {
      open = false;
      if (onClosed) {
        onClosed(data);
      }
    }
  
  </script>
  
  {#if open}
    <div class="modal modal-dialog-scrollable" id="sampleModal" tabindex="-1" role="dialog" aria-labelledby="sampleModalLabel" aria-hidden={false}>
      <div class="modal-dialog {modalSize}" role="document" in:fly={{ y: -50, duration: 300 }} out:fly={{ y: -50, duration: 300, easing: quintOut }}>
        <div class="modal-content">
          <div class="modal-header bg-azul-5 text-light">
            <h5 class="modal-title" id="sampleModalLabel">{title}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" on:click={() => modalClose('close')}>
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <slot></slot>
          </div>
          <div class="modal-footer bg-azul-5">
            {#if saveButton == "on"}
               <button type="button" class="btn btn firmar"                    on:click={() => modalClose('save')}>{saveButtonText}</button>
            {/if}
            {#if cancelButton == "on"}
              <button type="button" class="btn btn-secondary" data-dismiss="modal" on:click={() => modalClose('cancel')}>{closeButtonText}</button>
            {/if}
            {#if denyButton == "on"}
               <button type="button" class="btn btn-primary"                    on:click={() => modalClose('deny')}>{denyButtonText}</button>
            {/if}
          </div>
        </div>
      </div>
    </div>
    {#if showBackdrop}
      <div class="modal-backdrop show" transition:fade={{ duration: 150 }} />
    {/if}
  {/if}
  
  <style>
  
    .modal-title{
      color: black;
    }
    
    .modal-header, .modal-footer {
      background-color: #18d1ff;
      color: white;
      }
  
    .modal-footer {
      padding-top: 5px;
      padding-bottom: 15px;
    }
  
    .modal {
      display: block;
    }
  
    .firmar {
      background-color: #fade00;
      color: black;
    }
    
  </style>