<script setup>
import Nav from "/resources/js/components/Nav.vue";
import Perfil from "/resources/js/components/Perfil.vue";
import { ref } from "vue";

const perfilState = ref(false);
</script>

<template>
    <div class="relative w-full h-full">
        <Nav :status="perfilState" @update:status="perfilState = $event" />
        <Perfil :status="perfilState" @update:status="perfilState = $event" />
    </div>
</template>
