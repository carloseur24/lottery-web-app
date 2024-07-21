<script setup>
import { defineProps } from 'vue';
const props = defineProps({
    common_classes_modal: String,
})
</script>
<template>
    <article :class="'bg-white p-14 rounded-lg shadow-lg ' + props.common_classes_modal">
        <form action="/register" method="POST">
            <div class="mb-4">
                <label for="nombre" class="block text-slate-700 text-sm font-bold mb-2">Nombre:</label>
                <input type="text" id="nombre" name="nombre"
                    class="shadow appearance-none border border-gray-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>

            <div class="mb-4">
                <label for="cedula_number" class="block text-slate-700 text-sm font-bold mb-2">Cédula:</label>
                <input type="text" id="cedula_number" name="cedula_number"
                    class="shadow appearance-none border border-gray-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>

            <div class="mb-4">
                <label for="phone_number" class="block text-slate-700 text-sm font-bold mb-2">Teléfono:</label>
                <input type="tel" id="phone_number" name="phone_number"
                    class="shadow appearance-none border border-gray-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-slate-700 text-sm font-bold mb-2">Contraseña:</label>
                <input type="password" id="password" name="password"
                    class="shadow appearance-none border border-gray-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>
            <div class="mb-6">
                <label for="password_confirmation" class="block text-slate-700 text-sm font-bold mb-2">Verifica
                    tu
                    Contraseña:</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="shadow appearance-none border border-gray-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Registrar
                </button>
            </div>
        </form>
    </article>
</template>
