<script setup>
import { defineProps } from 'vue';
const bankData = {
    bank: '0424',
    phone: '',
    date: '2024-07-20',
    reference: ''
};
const validatePayment = (e) => {
}
const props = defineProps({
    common_classes_modal: String,
})
</script>

<template>
    <section :class="'container ' + props.common_classes_modal">
        <article class="bg-white p-6 rounded-lg shadow-lg">
            <div class="header mb-4">
                <!-- <img src="logo.png" alt="Pago Móvil Logo" class="h-12 w-auto mx-auto" /> -->
                <span class="fas fa-mobile-alt text-2xl"></span>
            </div>

            <h2 class="text-lg font-semibold mb-2">Amount to be paid</h2>
            <p class="text-2xl font-bold mb-4">Bs. 616.09</p>

            <div class="bank-logo mb-4 hidden"> <!-- añadir imagen de banco si es necesario -->
                <img alt="Banco Nacional de Crédito Logo" class="h-10 w-auto mx-auto" />
            </div>

            <h3 class="text-base font-medium mb-2">MAKE A PAGO MÓVIL TO:</h3>
            <div class="payment-details mb-6">
                <p class="font-semibold">Phone number: 0412 0498278</p>
                <p class="font-semibold">RIF: J-500969210</p>
                <p class="font-semibold">Bank: Banco Nacional de Crédito BNC</p>
            </div>

            <h4 class="text-sm font-medium mb-2">Ingresa la información del pago móvil realizado</h4>
            <form @submit.prevent="validatePayment">
                <div class="mb-4">
                    <label for="bank" class="block text-gray-700 text-sm font-bold mb-2">Bank:</label>
                    <select id="bank" v-model="bankData.bank"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="0424">0424</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone number:</label>
                    <input type="tel" id="phone" v-model="bankData.phone"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Payment date:</label>
                    <input type="date" id="date" v-model="bankData.date"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="2024-07-20">
                </div>

                <div class="mb-6">
                    <label for="reference" class="block text-gray-700 text-sm font-bold mb-2">Reference's last 4
                        digits:</label>
                    <input type="text" id="reference" v-model="bankData.reference"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Validate
                    payment</button>
            </form>
        </article>
    </section>
</template>
