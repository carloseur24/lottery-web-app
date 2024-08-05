<script setup>

const emit = defineEmits(['open-modal']); // Define the emitted events

</script>

<template>

    <div class="lg:ghidden fixed bottom-0 left-0 right-0 bg-slate-700 p-4 flex justify-around">
        <button class="text-white text-sm">Home</button>
        <button class="text-white text-sm">span</button>
        <button class="text-white text-sm" @click="$emit('open-modal', 'deposito')">Depósito</button>
        <button class="text-white text-sm" @click="$emit('open-modal', 'favoritos')">Favoritos</button>
        <button class="text-white text-sm" @click="$emit('open-modal', 'perfil')">Perfil</button>
    </div>

</template>
