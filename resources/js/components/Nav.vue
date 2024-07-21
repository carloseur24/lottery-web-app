<script setup>

const emit = defineEmits(['open-modal']); // Define the emitted events

</script>

<template>

    <main class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-12 py-8">

        <div class="bg-white p-6 rounded-lg shadow-lg my-8 sm:my-12 md:my-16 lg:my-20">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Pagina de bienvenida</h1>
            <p class="text-gray-700">Contenido...</p>
        </div>

    </main>

    <div class="lg:ghidden fixed bottom-0 left-0 right-0 bg-slate-700 p-4 flex justify-around">
        <button class="text-white text-sm">Home</button>
        <button class="text-white text-sm">span</button>
        <button class="text-white text-sm" @click="$emit('open-modal', 'deposito')">Depósito</button>
        <button class="text-white text-sm" @click="$emit('open-modal', 'favoritos')">Favoritos</button>
        <button class="text-white text-sm" @click="$emit('open-modal', 'perfil')">Perfil</button>
    </div>

</template>
