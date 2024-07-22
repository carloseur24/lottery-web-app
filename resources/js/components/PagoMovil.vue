<script setup>
import { defineProps, ref } from 'vue';
const bankData = {
    banco: '0424',
    teleforno: '',
    fecha: '2024-07-20',
    referencia: ''
};
const pagoMovil = {
    banco: 'Banco Nacional de Crédito BNC - 0424',
    identificacion: 'J-500969210',
    tipo_identificacion: 'RIF',
    telefono: '0412 0498278',
}
const validatePayment = (e) => {
}
const props = defineProps({
    common_classes_modal: String,
})

const copyRef = ref(null);
const created = () => {
    copyRef.value = !!navigator.clipboard;
}
created();
const copy = async (e, s) => {
    await navigator.clipboard.writeText(s);
    e.target.classList.add('bg-gray-200');
}
</script>

<template>
    <section :class="'container ' + props.common_classes_modal">
        <article class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-base mb-2 font-bold">Haz el pago movil al:</h3>
            <section class="flex items-center gap-5">
                <div class="header mb-4 bg-blue-500 p-4 px-5 rounded-full w-fit text-white">
                    <span class="fas fa-mobile-alt text-2xl"></span>
                </div>
                <div class="payment-details mb-6">
                    <p class="font-semibold">{{ pagoMovil.banco }}</p>
                    <p class="font-semibold">Numero de telefono: {{ pagoMovil.telefono }} <button v-if="copyRef"
                            @click="(e) => copy(e, bankData.banco)"><span
                                class="fa-regular fa-copy hover:bg-gray-300 p-2 rounded-full"></span></button>
                    </p>
                    <p class="font-semibold">{{ pagoMovil.tipo_identificacion }}: {{ pagoMovil.identificacion }} <button
                            v-if="copyRef" @click="(e) => copy(e, bankData.banco)"><span
                                class="fa-regular fa-copy hover:bg-gray-300 p-2 rounded-full"></span></button>
                    </p>
                </div>
            </section>


            <article class="">
                <h2 class="text-lg font-semibold mb-2">Cantidad a pagar</h2>
                <p class="text-2xl font-bold mb-4">Bs. 616.09</p>
            </article>

            <h2 class="text-sm font-medium mb-2 underline">Ingresa la información del pago móvil realizado</h2>
            <form @submit.prevent="validatePayment">
                <div class="mb-4">
                    <label for="bank" class="block text-gray-700 text-sm font-bold mb-2">Banco:</label>
                    <select id="bank" v-model="bankData.banco"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option :value="bankData.banco">{{ bankData.banco }}</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Número de telefono:</label>
                    <input type="tel" id="phone" v-model="bankData.teleforno"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Fecha de pago:</label>
                    <input type="date" id="date" v-model="bankData.fecha"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="2024-07-20">
                </div>

                <div class="mb-6">
                    <label for="reference" class="block text-gray-700 text-sm font-bold mb-2">Últimos 4 dígitos de la
                        referencia:</label>
                    <input type="text" id="reference" v-model="bankData.referencia"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Validate
                    payment</button>
            </form>
        </article>
    </section>
</template>
