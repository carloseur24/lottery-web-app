<script setup>
import Nav from "/resources/js/components/Nav.vue";
import PagoMovil from "/resources/js/components/PagoMovil.vue";
import Deposito from "/resources/js/components/Deposito.vue";
import Modal from "/resources/js/components/Modal.vue";
import Perfil from "/resources/js/components/Perfil.vue";
import { ref } from "vue";

const modalState = ref({
    perfil: false,
    pagomovil: false,
    deposito: false,
    favoritos: false,
    // Add more modals as needed
});

const selectedMethod = ref(null);
const paymentMethods = ref([
    // { name: 'KM in favor', icon: 'km-icon.png', balance: 'KM 0.16', component: '' },
    { name: 'Pago móvil', icon: 'pago-movil-icon.png', component: PagoMovil },
    // { name: 'Cash', icon: 'cash-icon.png', component: '' },
    // { name: 'International card', icon: 'international-card-icon.png', component: '' },
    // { name: 'Debit Card', icon: 'debit-card-icon.png', component: '' },
    { name: 'Zelle', icon: 'zelle-icon.png', component: '' },
]);

const toggleModal = (modalName) => {
    modalState.value[modalName] = !modalState.value[modalName];
};
</script>

<template>
    <div class="relative w-full h-full">
        <Nav v-on="$attrs" @open-modal="toggleModal" />
        <Modal v-if="modalState.perfil" @close="modalState.perfil = false">
            <Perfil />
        </Modal>
        <Modal v-if="modalState.deposito" @close="modalState.deposito = false">
            <article class="bg-white p-6 rounded-lg shadow-lg modal-content">
                <h2 class="pb-2 font-bold">Selecciona un método de pago</h2>
                <hr class="pt-2">
                <Deposito v-for="method in paymentMethods" :key="method.name" :name="method.name" :icon="method.icon"
                    :balance="method.balance" :selected="selectedMethod === method.name"
                    @select="selectedMethod = method.name" />
            </article>
        </Modal>
        <Modal v-if="modalState.pagomovil" @close="modalState.pagomovil = false">
            <PagoMovil />
        </Modal>
    </div>
</template>
