<script setup>
import { defineProps, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { inject } from 'vue'
import { SwalIcons, SwalTitles } from '../swalMethods';
import { toRefs } from 'vue';
const swal = inject('$swal')

const props = defineProps({
    userData: {
        type: Object,
        default: {}
    },
    perfil_data: {
        type: Function,
        default: () => { }
    },
    bankOptions: {
        type: Object,
        default: {}
    },
    common_classes_modal: {
        type: [String], // This defines the prop as either String or null
        default: ''
    }
})
const { userData: user_data } = toRefs(props)


function showDialog(icon, title, message = '', confirmButtonStatus = false) {
    swal.fire({
        icon: icon,
        title: title,
        text: message,
        showConfirmButton: confirmButtonStatus,
        timer: 2500
    });
}

const token = window.Laravel.csrfToken;

const isLoading = ref(true);
const open_update_profile_view = ref(false);

const old_password = ref('');
const new_password = ref('');
const password_confirmation = ref('');

const data = ref({});

const nombre = ref('') // is a reactive reference to store the value of the input.
const cedula_number = ref('') // is a reactive reference to store the value of the input.
const phone_number = ref('') // is a reactive reference to store the value of the input.
const email = ref('') // is a reactive reference to store the value of the input.
const banco_id = ref("") // is a reactive reference to store the value of the input.
const formData = ref({
    nombre,
    cedula_number,
    phone_number,
    banco_id,
    email
})




const handle_open_update_profile_view = () => {
    open_update_profile_view.value = true;
}
const handle_close_update_profile_view = () => {
    open_update_profile_view.value = false;
}

const updatePerfil = async () => {
    data.value = {
        id: window.user.id,
        nombre: nombre.value,
        cedula_number: cedula_number.value,
        phone_number: phone_number.value,
        email: email.value,
        banco_id: banco_id.value,
        old_password: old_password.value,
        new_password: new_password.value,
        password_confirmation: password_confirmation.value
    }

    if (data.value.old_password !== data.value.new_password || data.value.nombre !== user_data.value.nombre || data.value.cedula_number !== user_data.value.cedula_number || data.value.phone_number !== user_data.value.phone_number || data.value.banco_id !== user_data.value.banco_id || data.value.email !== user_data.value.email) {
        try {
            const response = await fetch('/perfil/usuario/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ data: data.value })
            })
            if (response.status !== 200) {
                throw new Error('Error al actualizar el perfil')
            }
            const responseData = await response.json()
            // console.log(responseData)
            if (responseData.message === 'User data updated successfully') {
                const { nombre, cedula_number, phone_number, banco_id, email } = data.value
                user_data.value = { nombre, cedula_number, phone_number, banco_id, email };
                open_update_profile_view.value = false;
                showDialog(SwalIcons.SUCCESS, SwalTitles.SUCCESS, 'Perfil actualizado exitosamente')
            }
        } catch (error) {
            showDialog(SwalIcons.ERROR, SwalTitles.ERROR, 'Algo salió mal, intenta de nuevo')
            // console.log(error)
        }
    } else {
        showDialog(SwalIcons.WARNING, SwalTitles.WARNING, 'Tus datos no han cambiado')
        return true
    }
    if (data.value.old_password !== '' && data.value.new_password !== '' && data.value.old_password === data.value.new_password) {
        // console.log('Tu nueva contraseña no es valida')
        showDialog(SwalIcons.ERROR, SwalTitles.ERROR, 'Tu nueva contraseña no es valida')
        return true
    }
}
const logout = async () => {
    try {
        const response = await fetch('/perfil/usuario/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
        })
        if (response.status !== 200) {
            throw new Error('Error al cerrar el perfil')
        }

        const data = await response.json();
        // console.log(data); // Optional: log the response data

        location.href = '/login';
    } catch (error) {
        console.log(error)
    }
}
// Use sweetalert2
onMounted(async () => {
    try {
        await props.perfil_data(window.user.id, formData.value, isLoading);
    } catch (error) {
        console.error('Error on mounted:', error); // Improved error handling
    }
})


</script>
<template>
    <div v-if="isLoading">Loading...</div>
    <article :class="'bg-white p-14 rounded-md drop-shadow-md shadow-lg ' + props.common_classes_modal ?? ''" v-else>

        <!-- Form Buttons -->
        <section class="flex items-center justify-between gap-4  mb-4">
            <h2 class="text-xl font-bold uppercase w-full h-full text-start">{{ open_update_profile_view === true ?
                'Actualizar información' : 'Información del perfil' }}</h2>

            <button
                :class="open_update_profile_view === true ? 'hidden' : 'font-medium bg-blue-600 text-slate-50 rounded-md p-2 py-3 w-52 hover:opacity-90 transition-opacity duration-150 ease-in'"
                @click="handle_open_update_profile_view">
                {{ 'Actualizar perfil' }}
            </button>
        </section>

        <hr class="mb-3 opacity-50">
        <!-- User information -->
        <div :class="open_update_profile_view === true ? 'hidden' : ''">

            <div class="flex flex-col gap-2 mb-4">
                <article class="font-bold">
                    Nombre:
                    <span class="font-medium">
                        {{ user_data.nombre }}
                    </span>
                </article>
                <article class="font-bold">
                    Cédula:
                    <span class="font-medium">
                        {{ user_data.cedula_number }}
                    </span>
                </article>
                <article class="font-bold">
                    Teléfono:
                    <span class="font-medium">
                        {{ user_data.phone_number }}
                    </span>
                </article>
                <article class="font-bold">
                    Correo Electrónico:
                    <span class="font-medium">
                        {{ user_data.email ?? 'No registrado' }}
                    </span>
                </article>

                <article class="font-bold">Pago Movil: <span class="font-medium">
                        {{
                            (user_data.banco_id ?? 'Banco por definir') + ' - ' + user_data.cedula_number + ' - '
                            + user_data.phone_number
                        }}
                    </span>
                </article>
            </div>
        </div>

        <!-- Updating form -->
        <section :class="open_update_profile_view === true ? '' : 'hidden'">
            <section class="flex flex-col sm:flex-row gap-2 w-full">
                <div class="mb-4 w-full">
                    <label for="nombre" class="block text-slate-700 text-sm font-bold mb-2">Nombre</label>
                    <input v-model="nombre" type="text" id="nombre" name="nombre"
                        class="form shadow appearance-none border border-gray-500 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>
                <div class="mb-4 w-full">
                    <label for="cedula_number" class="block text-slate-700 text-sm font-bold mb-2">Cédula</label>
                    <input v-model="cedula_number" type="text" id="cedula_number" name="cedula_number"
                        class="form shadow appearance-none border border-gray-500 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>
            </section>

            <!-- this bug is getting from here -->
            <section class="flex flex-col sm:flex-row gap-2 w-full">

                <div class="mb-4 w-full">
                    <label for="phone_number" class="block text-slate-700 text-sm font-bold mb-2">Teléfono</label>
                    <input v-model="phone_number" type="tel" id="phone_number" name="phone_number"
                        class="form shadow appearance-none border border-gray-500 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>
                <div class="mb-4 w-full">
                    <label for="email" class="block text-slate-700 text-sm font-bold mb-2">Correo Electrónico</label>
                    <input v-model="email" type="email" id="email" name="email"
                        class="form shadow appearance-none border border-gray-500 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>
            </section>
            <div class="mb-4 w-full">
                <label for="banco_id" class="block text-slate-700 text-sm font-bold mb-2">Banco</label>
                <select v-model="banco_id" id="banco_id" name="banco_id"
                    class="form shadow  border border-gray-500 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
                    <!-- <option selected disabled>Seleccione un banco</option> -->
                    <option v-for="(item, code) in props.bankOptions" :key="code" :value="code"
                        :selected="code === '' ? true : false"
                        :disabled="item === 'Seleccione un banco' ? true : false">
                        {{ item }}
                    </option>
                </select>
            </div>


            <hr class="opacity-50 my-3">
            <h2 class="text-lg font-bold text-center">Actualiza tu contraseña</h2>
            <hr class="opacity-50 my-3">
            <div class="mb-6">
                <label for="old_password" class="block text-slate-700 text-sm font-bold mb-2">Contraseña Actual</label>
                <input type="password" id="old_password" name="old_password" v-model="old_password"
                    class="form shadow appearance-none border border-gray-500 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>

            <section class="flex flex-col sm:flex-row gap-2 w-full">
                <div class="mb-6 w-full">
                    <label for="new_password" class="block text-slate-700 text-sm font-bold mb-2">
                        Nueva Contraseña
                    </label>
                    <input type="password" id="new_password" name="new_password" v-model="new_password"
                        class="form shadow appearance-none border border-gray-500 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>
                <div class="mb-6 w-full">
                    <label for="password_confirmation" class="block text-slate-700 text-sm font-bold mb-2">
                        Verifica tu Contraseña
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        v-model="password_confirmation"
                        class="form shadow appearance-none border border-gray-500 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>
            </section>

        </section>

        <hr class="opacity-50">
        <!-- Logout Button -->
        <section class="flex items-center justify-between gap-4 mt-4">
            <button
                :class="open_update_profile_view === true ? 'hidden' : 'font-medium bg-transparent hover:bg-black hover:text-slate-50 border hover:border-transparent border-slate-700 text-slate-700 rounded-md p-2 py-3 w-52 hover:opacity-90 transition-all duration-200 ease-in'"
                @click="logout">
                {{ 'Cerrar sesión' }}
            </button>
            <button
                :class="open_update_profile_view === true ? 'font-medium bg-transparent hover:bg-black hover:text-slate-50 border hover:border-transparent border-slate-700 text-slate-700 rounded-md p-2 py-3 w-full hover:opacity-90 transition-all duration-150 ease-in ' : 'hidden'"
                @click="handle_close_update_profile_view">
                {{ 'Cancelar' }}
            </button>
            <button
                :class="open_update_profile_view === true ? 'font-medium bg-blue-600 border border-transparent text-slate-50 rounded-md p-2 py-3 w-full hover:opacity-90 transition-all duration-200 ease-in ' : 'hidden'"
                @click="updatePerfil">
                {{ 'Guardar Cambios' }}
            </button>
        </section>
    </article>
</template>
