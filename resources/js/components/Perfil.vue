<script setup>
import { defineProps, onMounted, ref } from 'vue';
const props = defineProps({
    common_classes_modal: String,
})

const token = window.Laravel.csrfToken;
const user_data = ref({});
const isLoading = ref(true);

const perfil_data = async (id) => {
    try {
        const response = await fetch('/perfil/usuario', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ id })
        })
        const data = await response.json()
        if (response.status !== 200) {
            throw new Error('Error al obtener datos del perfil')
        }
        const { nombre, cedula_number, phone_number, banco_id } = data
        user_data.value = { nombre, cedula_number, phone_number, banco_id };
        isLoading.value = false;
    } catch (error) {
        console.log(error)
    }

}
onMounted(async () => {
    await perfil_data(window.user.id);
    try {
        // Assuming window.user.id exists and is valid
        // await get_users_data()
    } catch (error) {
        console.error('Error on mounted:', error); // Improved error handling
    }
})




// const get_users_data = async () => {
//     try {
//         const response = await fetch('/perfil/usuario', {
//             method: 'GET',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': token
//             }
//         })
//         const data = await response.json()
//         // console.log(data)
//         if (response.status !== 200) {
//             throw new Error('Error al obtener datos del perfil')
//         }
//         return data
//     } catch (error) {
//         console.log(error)
//     }
// }



</script>
<template>
    <div v-if="isLoading">Loading...</div>
    <article :class="'bg-white p-14 rounded-lg shadow-lg ' + props.common_classes_modal" v-else>
        <h2 class="text-xl font-bold mb-4">Información del usuario</h2>
        <div class="flex flex-col gap-2 mb-4">
            <article class="font-bold">Cédula: <span class="font-medium">{{ user_data.nombre }}</span>
            </article>
            <article class="font-bold">Teléfono: <span class="font-medium">{{ user_data.phone_number }} </span>
            </article>
            <article class="font-bold">Contraseña: <button
                    class="font-medium bg-slate-400 text-slate-50 rounded p-2 hover:opacity-80 transition-opacity duration-150 ease-in-out">{{
                        'Cambiar contraseña' }}</button>
            </article>
            <article class="font-bold">Pago Movil: <span class="font-medium">
                    {{ '0102 - ' + user_data.cedula_number + ' - ' + user_data.phone_number }}
                </span>
            </article>
        </div>
        <!-- <form action="/register" method="POST">
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
        </form> -->
    </article>
</template>
