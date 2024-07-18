<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    status: Boolean,
    default: false
});

const emit = defineEmits(['update:status']);

const togglePerfil = () => {
    emit('update:status', !props.status);
};

</script>

<template>

    <main class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-12 py-8">

        <div class="bg-white p-6 rounded-lg shadow-lg my-8 sm:my-12 md:my-16 lg:my-20">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Pagina de bienvenida</h1>
            <p class="text-gray-700">Contenido...</p>
        </div>

    </main>

    <div class="sm:hidden fixed bottom-0 left-0 right-0 bg-slate-700 p-4 flex justify-around">
        <button class="text-white text-sm">Home</button>
        <button class="text-white text-sm">Span 1</button>
        <button class="text-white text-sm">Depósito</button>
        <button class="text-white text-sm">Favorites</button>
        <button class="text-white text-sm" @click="togglePerfil">Perfil</button>
    </div>

</template>
