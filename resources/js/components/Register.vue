<script setup>
import { ref } from "vue"

const phone_number = ref('')
const password = ref('')

const login = async () => {
    try {
        const response = await fetch('/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            },
            body: JSON.stringify({ phone_number, password })
        })
        if (response.status !== 200) {
            throw new Error('Error al ingresar')
        }
        const data = await response.json()
        console.log(data)
    } catch (error) {
        console.log(error)
    }
}
</script>

<template>
    <form id="register" class="w-full">
        <section class="flex flex-col sm:flex-row gap-2 w-full">
            <div class="mb-4 w-full">
                <label for="nombre" class="block text-slate-700 text-sm font-bold mb-2">Nombre</label>
                <input type="text" id="nombre" name="nombre"
                    class="form shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>

            <div class="mb-4 w-full">
                <label for="cedula_number" class="block text-slate-700 text-sm font-bold mb-2">Cédula</label>
                <input type="text" id="cedula_number" name="cedula_number"
                    class="form shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>
        </section>

        <section class="flex flex-col sm:flex-row gap-2 w-full">
            <div class="mb-4 w-full">
                <label for="phone_number" class="block text-slate-700 text-sm font-bold mb-2">Teléfono</label>
                <input type="tel" id="phone_number" name="phone_number"
                    class="form shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>

            <div class="mb-4 w-full">
                <label for="email" class="block text-slate-700 text-sm font-bold mb-2">
                    Correo Electronico
                    <span class="text-blue-400">(Opcional)</span>
                </label>
                <input type="email" id="email" name="email"
                    class="form shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>
        </section>

        <div class="mb-6">
            <label for="password" class="block text-slate-700 text-sm font-bold mb-2">Contraseña</label>
            <input type="password" id="password" name="password"
                class="form shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:shadow-outline"
                required>
        </div>
        <div class="mb-6">
            <label for="password_confirmation" class="block text-slate-700 text-sm font-bold mb-2">
                Verifica tu Contraseña
            </label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="form shadow appearance-none border rounded w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:shadow-outline"
                required>
        </div>

        <div class="flex items-start justify-between">
            <a href="/login" class="text-blue-500 hover:text-blue-400 text-sm font-bold underline">
                Ya tengo cuenta
            </a>
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-400 w-full sm:w-fit text-white font-bold p-4 px-8 rounded focus:outline-none focus:shadow-outline transition-all duration-200 ease-in uppercase">
                Registrar
            </button>
        </div>
    </form>
</template>
