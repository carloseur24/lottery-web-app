<script setup>
import { nextTick, onMounted, ref } from "vue";

import Nav from "./Nav.vue";
import PagoMovil from "./PagoMovil.vue";
import Deposito from "./Deposito.vue";
import Modal from "./Modal.vue";
import Perfil from "./Perfil.vue";

const activeModal = ref(null);
const modalState = ref({
    perfil: false,
    pagomovil: false,
    deposito: false,
    favoritos: false,
    // Add more modals as needed
});
const selectedMethod = ref(null);
const paymentMethods = ref([
    { name: 'Pago móvil', icon: 'fa-solid fa-mobile-screen-button', payment: 'pagomovil' },
    // { name: 'Cash', icon: 'cash-icon.png', component: '' },
    // { name: 'International card', icon: 'international-card-icon.png', component: '' },
    // { name: 'Debit Card', icon: 'debit-card-icon.png', component: '' },
    // { name: 'Zelle', icon: 'zelle-icon.png', component: '' },
]);

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

const modal_classes = 'modal-content w-[95%] sm:w-[85%] md:mx-0 md:max-w-[800px]'
</script>

<template>
    <div class="relative w-full h-full">
        <Nav v-on="$attrs" @open-modal="toggleModal" />
        <Modal v-if="activeModal === 'perfil'" @close="activeModal = null">
            <Perfil :common_classes_modal="modal_classes" />
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
            <PagoMovil :common_classes_modal="modal_classes" />
        </Modal>
    </div>
</template>
