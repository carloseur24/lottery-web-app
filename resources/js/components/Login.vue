<script setup>
import { ref } from "vue"
import { SwalIcons, SwalTitles } from '../swalMethods.js'
import { inject } from 'vue'
const swal = inject('$swal')

function showDialog(icon, title, message = '', confirmButtonStatus = false) {
    swal.fire({
        icon: icon,
        title: title,
        text: message,
        showConfirmButton: confirmButtonStatus,
        timer: 2500
    });
}


const phone_number = ref('')
const password = ref('')

const nombre_register = ref('')
const cedula_number_register = ref('')
const phone_number_register = ref('')
const email_register = ref('')
const password_register = ref('')
const password_confirmation_register = ref('')


const login = async (e) => {
    e.preventDefault()
    try {
        const response = await fetch('/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            },
            body: JSON.stringify({ phone_number: phone_number.value, password: password.value })
        })
        if (response.status !== 200) {
            showDialog(SwalIcons.ERROR, SwalTitles.ERROR, 'Algo salió mal, intenta de nuevo')
            throw new Error('Error al ingresar')
        }
        const data = await response.json()
        console.log(data)
        if (data.message === 'user authenticated successfully') {
            showDialog(SwalIcons.SUCCESS, SwalTitles.SUCCESS, 'Sesión iniciada exitosamente')
            setTimeout(() => {
                location.href = '/dashboard'
            }, 500)
        }
    } catch (error) {
        showDialog(SwalIcons.ERROR, SwalTitles.ERROR, 'Algo salió mal, intenta de nuevo')
        console.log(error)
    }
}

const register = async (e) => {
    e.preventDefault()
    try {
        const response = await fetch('/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            },
            body: JSON.stringify({
                nombre: nombre_register.value,
                cedula_number: cedula_number_register.value,
                phone_number: phone_number_register.value,
                email: email_register.value,
                password: password_register.value,
                password_confirmation: password_confirmation_register.value
            })
        })
        if (response.status !== 200) {
            showDialog(SwalIcons.ERROR, SwalTitles.ERROR, 'Algo salió mal, intenta de nuevo')
            throw new Error('Error al registrarse')
        }
        const data = await response.json()
        // console.log(data)
        if (data.cedula_number[0] === "The cedula number has already been taken.") {
            showDialog(SwalIcons.WARNING, SwalTitles.WARNING, 'Ya te encuentras registrado, inicia sesión para continuar')
            toggleFormsRegisterLogin()
            return false
        }
        showDialog(SwalIcons.SUCCESS, SwalTitles.SUCCESS, 'Registro exitoso')
        toggleFormsRegisterLogin()
        return true

    } catch (error) {
        showDialog(SwalIcons.ERROR, SwalTitles.ERROR, 'Algo salió mal, intenta de nuevo')
        // console.log(error)
    }
}

const toggleFormsRegisterLogin = () => {
    document.getElementById('login').classList.toggle('hidden')
    document.getElementById('register').classList.toggle('hidden')
}


</script>

<template>
    <!-- Login Form -->
    <form id="login" class="w-full">
        <div class="mb-4">
            <label for="phone_number" class="block text-slate-700 text-sm font-bold mb-2">Teléfono</label>
            <input v-model="phone_number" type="tel" id="phone_number" name="phone_number"
                class="form shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                required>
        </div>

        <div class="mb-6">
            <label for="password" class="block text-slate-700 text-sm font-bold mb-2">Contraseña</label>
            <input v-model="password" type="password" id="password" name="password"
                class="form shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                required>
        </div>

        <div class="flex items-start justify-between">
            <div class="text-blue-500 hover:text-blue-400 text-sm font-bold underline cursor-pointer"
                @click="toggleFormsRegisterLogin">
                No tengo cuenta
            </div>
            <button @click="login"
                class="bg-blue-500 hover:bg-blue-400 w-full sm:w-fit text-white font-bold p-4 px-8 rounded focus:outline-none focus:shadow-outline transition-all duration-200 ease-in uppercase">
                Ingresar
            </button>
        </div>
    </form>

    <!-- Register Form -->
    <form id="register" class="w-full hidden">
        <section class="flex flex-col sm:flex-row gap-2 w-full">
            <div class="mb-4 w-full">
                <label for="nombre" class="block text-slate-700 text-sm font-bold mb-2">Nombre</label>
                <input v-model="nombre_register" type="text" id="nombre" name="nombre"
                    class="form shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>

            <div class="mb-4 w-full">
                <label for="cedula_number" class="block text-slate-700 text-sm font-bold mb-2">Cédula</label>
                <input v-model="cedula_number_register" type="text" id="cedula_number" name="cedula_number"
                    class="form shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>
        </section>

        <section class="flex flex-col sm:flex-row gap-2 w-full">
            <div class="mb-4 w-full">
                <label for="phone_number_register" class="block text-slate-700 text-sm font-bold mb-2">Teléfono</label>
                <input v-model="phone_number_register" type="tel" id="phone_number_register"
                    name="phone_number_register"
                    class="form shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>

            <div class="mb-4 w-full">
                <label for="email" class="block text-slate-700 text-sm font-bold mb-2">
                    Correo Electronico
                    <span class="text-blue-400">(Opcional)</span>
                </label>
                <input v-model="email_register" type="email" id="email" name="email"
                    class="form shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>
        </section>

        <div class="mb-6">
            <label for="password_register" class="block text-slate-700 text-sm font-bold mb-2">Contraseña</label>
            <input v-model="password_register" type="password" id="password_register" name="password_register"
                class="form shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:shadow-outline"
                required>
        </div>
        <div class="mb-6">
            <label for="password_confirmation" class="block text-slate-700 text-sm font-bold mb-2">
                Verifica tu Contraseña
            </label>
            <input v-model="password_confirmation_register" type="password" id="password_confirmation"
                name="password_confirmation"
                class="form shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:shadow-outline"
                required>
        </div>

        <div class="flex items-start justify-between">
            <div class="text-blue-500 hover:text-blue-400 text-sm font-bold underline cursor-pointer"
                @click="toggleFormsRegisterLogin">
                Ya tengo cuenta
            </div>
            <button @click="register"
                class="bg-blue-500 hover:bg-blue-400 w-full sm:w-fit text-white font-bold p-4 px-8 rounded focus:outline-none focus:shadow-outline transition-all duration-200 ease-in uppercase">
                Registrar
            </button>
        </div>
    </form>

</template>
