<script setup>
import { defineProps, ref } from 'vue';
import { inject } from 'vue'
// import { SwalIcons, SwalTitles } from '../swalMethods';
import { mask } from 'vue-the-mask'
// Register the directive
defineExpose({ mask });
const props = defineProps({
    common_classes_modal: {
        type: String,
        default: ''

    },
    bankOptions: {
        type: Object,
        default: {}
    },
})

const swal = inject('$swal')
const Toast = swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = swal.stopTimer;
        toast.onmouseleave = swal.resumeTimer;
    }
});

const bankData = ref({
    banco: '',
    telefono: '',
    fecha: '',
    referencia: '',
});
const pagoMovil = ref({
    banco: 'Banco Nacional de Crédito BNC - 0424',
    identificacion: 'J-500969210',
    identificacion_to_copy: '500969210',
    tipo_identificacion: 'RIF',
    telefono: '0412-0498278',
    telefono_to_copy: '04120498278',
    saldo: '616.09'
});

const emit = defineEmits(['updateSaldo']);

const copyRef = ref(null);
const created = () => {
    copyRef.value = !!navigator.clipboard;
}

created();
const copy = async (e, s) => {
    await navigator.clipboard.writeText(s);
    e.target.classList.add('bg-gray-200');
    Toast.fire({
        icon: "info",
        title: "Copiado al portapapeles",
    });
}

const validatePayment = async () => {
    const dataTransfer = { ...bankData.value, saldo: pagoMovil.value.saldo, id: window.user.id }
    if (bankData.value.banco !== '' && bankData.value.telefono !== '' && bankData.value.fecha !== '' && bankData.value.referencia !== '' && pagoMovil.value.saldo !== '') {

        try {
            const response = await fetch('/payment/pago-movil/validate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                },
                body: JSON.stringify(dataTransfer)
            })
            if (response.status !== 200) {
                throw new Error('Error al validar el pago')
            }
            const data = await response.json()
            // console.log(data)
            // console.log(dataTransfer)
            if (data.message === 'Payment validated successfully') {
                Toast.fire({
                    icon: "success",
                    title: "Pago validado exitosamente",
                });
                emit('updateSaldo', dataTransfer.saldo);
            } else {
                Toast.fire({
                    icon: "error",
                    title: "Error al validar el pago",
                });
            }
        } catch (error) {
            console.log(error)
        }
    } else {
        Toast.fire({
            icon: "error",
            title: "Datos incompletos",
        });
    }
}
</script>

<template>
    <section :class="'container ' + props.common_classes_modal">
        <article class="bg-white p-6 sm:p-10 rounded-lg shadow-lg">
            <h3 class="text-sm mb-2 font-bold">Haz el pago movil al:</h3>
            <section class="flex items-start flex-col w-full h-full">
                <!-- <div class="header mb-4 bg-blue-500 p-4 px-5 rounded-full w-fit text-white">
                    <span class="fas fa-mobile-alt text-2xl"></span>
                </div> -->
                <p class="font-semibold text-sm">{{ pagoMovil.banco }}</p>
                <p class="font-semibold text-sm">Numero de telefono: {{ pagoMovil.telefono }}
                    <button v-if="copyRef" @click="(e) => copy(e, pagoMovil.telefono_to_copy)">
                        <span
                            class="fa-regular fa-copy hover:bg-gray-300 p-2 rounded-full duration-150 ease-in transition-all"
                            title="copiar"></span>
                    </button>
                </p>
                <p class="font-semibold text-sm">{{ pagoMovil.tipo_identificacion }}: {{ pagoMovil.identificacion }}
                    <button v-if="copyRef" @click="(e) => copy(e, pagoMovil.identificacion_to_copy)">
                        <span
                            class="fa-regular fa-copy hover:bg-gray-300 p-2 rounded-full duration-150 ease-in transition-all"
                            title="copiar"></span>
                    </button>
                </p>
                <!-- <div class="payment-details mb-6">
                </div> -->
            </section>

            <hr class="opacity-50 my-3">
            <article class="">
                <h2 class="text-sm font-semibold mb-2 !text-slate-900 uppercase">Cantidad a pagar</h2>
                <p class="text-sm font-bold mb-4">Bs. {{ pagoMovil.saldo }}</p>
            </article>

            <hr class="opacity-50 my-3">
            <h2 class="text-sm font-medium mb-2 underline">Ingresa la información del pago móvil realizado</h2>
            <form @submit.prevent="validatePayment">
                <div class="mb-4">
                    <label for="bank" class="block text-gray-700 text-sm font-bold mb-2">Banco remitente</label>
                    <select id="bank" v-model="bankData.banco"
                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option v-for="(item, code) in props.bankOptions" :key="code" :value="code"
                            :selected="code === '' ? true : false"
                            :disabled="item === 'Seleccione un banco' ? true : false">
                            {{ item }}
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Número de telefono</label>
                    <input type="tel" id="phone" v-model="bankData.telefono"
                        v-mask="['+## (###) ###-####', '+# (###) ###-####']"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Fecha de pago</label>
                    <input type="date" id="date" v-model="bankData.fecha"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="2024-07-20">
                </div>

                <div class="mb-6">
                    <label for="reference" class="block text-gray-700 text-sm font-bold mb-2">Últimos 4 dígitos de la
                        referencia</label>
                    <input type="text" id="reference" v-model="bankData.referencia" maxlength="4" v-mask="['####']"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="flex justify-end w-full">
                    <button @click="validatePayment"
                        class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline w-full sm:w-fit duration-150 ease-in transition-all uppercase">
                        Validar Pago
                    </button>
                </div>
            </form>
        </article>
    </section>
</template>
