<template>
    <div class="modal" v-if="showModal">
        <div class="modal-content">
            <h2>Modal Title</h2>
            <p>Modal content goes here.</p>
            <button @click="$emit('close-modal')">Close Modal</button>
        </div>
    </div>
</template>
  
<script>
export default {
    props: {
        showModal: Boolean
    }
};
</script>
  
<style scoped>
.modal {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
}

.modal-content {
    background-color: white;
    padding: 20px;
    max-width: 80%;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Add media queries for responsive behavior if needed */
</style>
  