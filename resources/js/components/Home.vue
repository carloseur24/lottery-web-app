<script setup>
import { nextTick, onMounted, ref } from "vue";

import TopNav from "./TopNav.vue";
import BottomNav from "./Nav.vue";
import PagoMovil from "./PagoMovil.vue";
import Deposito from "./Deposito.vue";
import Modal from "./Modal.vue";
import Perfil from "./Perfil.vue";
import Ann from "./Animation.vue";


const activeModal = ref(null);
const modalState = ref({
    perfil: false,
    pagomovil: false,
    deposito: false,
    favoritos: false,
    // Add more modals as needed
});
const selectedMethod = ref(null);
const isLoading = ref(true);
const paymentMethods = ref([
    { name: 'Pago móvil', icon: 'fa-solid fa-mobile-screen-button', payment: 'pagomovil' },
    // { name: 'Cash', icon: 'cash-icon.png', component: '' },
    // { name: 'International card', icon: 'international-card-icon.png', component: '' },
    // { name: 'Debit Card', icon: 'debit-card-icon.png', component: '' },
    // { name: 'Zelle', icon: 'zelle-icon.png', component: '' },
]);

const user_data = ref({});

const perfil_data = async (id, formData = { nombre: null, cedula_number: null, phone_number: null, banco_id: null, email: null }, isLoading = ref(true)) => {
    try {

        const response = await fetch('/perfil/usuario', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            },
            body: JSON.stringify({ id })
        })
        if (response.status !== 200) {
            throw new Error('Error al obtener datos del perfil')
        }
        const data = await response.json()
        // console.dir(data)
        const { nombre, cedula_number, phone_number, banco_id, email, saldo } = data
        user_data.value = { nombre, cedula_number, phone_number, banco_id, email, saldo };
        // console.dir(user_data.value)
        if (formData.nombre !== null) {
            formData.nombre = nombre;
            formData.cedula_number = cedula_number;
            formData.phone_number = phone_number;
            formData.banco_id = banco_id;
            formData.email = email;
        }
        isLoading.value = false;
    } catch (error) {
        console.log(error)
    }
}

const balance = 'KM 0.16';

const toggleModal = async (modalName) => {
    if (activeModal.value) {
        modalState.value[activeModal.value] = false;
    }

    // Set the new active modal
    activeModal.value = modalName;

    await nextTick();

    // Open the new modal
    if (modalName) {
        modalState.value[modalName] = true;
    }
};

// onMounted(() => {
//     console.log(); // or other user properties
// });
const bankOptions = ref({
    "": "Seleccione un banco",
    "0156": "100%BANCO",
    "0196": "ABN AMRO BANK",
    "0172": "BANCAMIGA BANCO MICROFINANCIERO, C.A.",
    "0171": "BANCO ACTIVO BANCO COMERCIAL, C.A.",
    "0166": "BANCO AGRICOLA",
    "0175": "BANCO BICENTENARIO",
    "0128": "BANCO CARONI, C.A. BANCO UNIVERSAL",
    "0164": "BANCO DE DESARROLLO DEL MICROEMPRESARIO",
    "0102": "BANCO DE VENEZUELA S.A.I.C.A.",
    "0114": "BANCO DEL CARIBE C.A.",
    "0149": "BANCO DEL PUEBLO SOBERANO C.A.",
    "0163": "BANCO DEL TESORO",
    "0176": "BANCO ESPIRITO SANTO, S.A.",
    "0115": "BANCO EXTERIOR C.A.",
    "0003": "BANCO INDUSTRIAL DE VENEZUELA.",
    "0173": "BANCO INTERNACIONAL DE DESARROLLO, C.A.",
    "0105": "BANCO MERCANTIL C.A.",
    "0191": "BANCO NACIONAL DE CREDITO",
    "0116": "BANCO OCCIDENTAL DE DESCUENTO.",
    "0138": "BANCO PLAZA",
    "0108": "BANCO PROVINCIAL BBVA",
    "0104": "BANCO VENEZOLANO DE CREDITO S.A.",
    "0168": "BANCRECER S.A. BANCO DE DESARROLLO",
    "0134": "BANESCO BANCO UNIVERSAL",
    "0177": "BANFANB",
    "0146": "BANGENTE",
    "0174": "BANPLUS BANCO COMERCIAL C.A",
    "0190": "CITIBANK.",
    "0121": "CORP BANCA.",
    "0157": "DELSUR BANCO UNIVERSAL",
    "0151": "FONDO COMUN",
    "0601": "INSTITUTO MUNICIPAL DE CRÉDITO POPULAR",
    "0169": "MIBANCO BANCO DE DESARROLLO, C.A.",
    "0137": "SOFITASA"
});
const modal_classes = 'modal-content w-[95%] sm:w-[85%] md:mx-0 md:max-w-[800px]'

const handleUpdateSaldo = (newSaldo) => {
    user_data.value.saldo = newSaldo;
    console.log(user_data.value.saldo);
};

onMounted(async () => {
    try {
        await perfil_data(window.user.id);
    } catch (error) {
        console.error('Error on mounted:', error); // Improved error handling
    }
})

</script>

<template>
    <div v-if="isLoading">Loading...</div>
    <TopNav :saldoValue="parseFloat(user_data.saldo)" />
    <main class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-12 py-8">

        <div class="bg-white p-6 rounded-lg shadow-lg my-8 sm:my-12 md:my-16 lg:my-20">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Pagina de bienvenida</h1>
            <p class="text-gray-700">Contenido...</p>
        </div>

        <ann />

    </main>

    <!-- Modals -->
    <div class="relative w-full h-full">
        <BottomNav v-on="$attrs" @open-modal="toggleModal" />
        <Modal v-if="activeModal === 'perfil'" @close="activeModal = null">
            <Perfil :common_classes_modal="modal_classes" :bankOptions="bankOptions" :perfil_data="perfil_data"
                :userData="user_data" />
        </Modal>
        <Modal v-if="activeModal === 'deposito'" @close="activeModal = null">
            <article :class="'bg-white p-10 rounded-lg shadow-lg h-[1000px]' + modal_classes">
                <h2 class="pb-2 font-bold">Selecciona un método de pago</h2>
                <p class="text-sm text-gray-500">Balance: {{ balance }}</p>
                <hr class="pt-2">
                <Deposito v-for="method in paymentMethods" :key="method.name" :name="method.name" :icon="method.icon"
                    :selected="selectedMethod === method.name" v-on="{
                        'open-modal': () => toggleModal(method.payment)
                    }" :payment="method.payment" />
            </article>
        </Modal>
        <Modal v-if="activeModal === 'pagomovil'" @close="activeModal = null">
            <PagoMovil :common_classes_modal="modal_classes" :bankOptions="bankOptions"
                @update-saldo="handleUpdateSaldo" />
        </Modal>
    </div>
</template>
