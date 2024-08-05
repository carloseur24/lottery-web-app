<script setup>

const emit = defineEmits(['close']);

</script>

<template>
    <div class="fixed top-0 left-1/2 -translate-x-1/2 right-0 w-full h-full z-50 bg-[#000000b0] flex justify-center items-center"
        @click.self="emit('close')">
        <slot></slot>
    </div>
</template>
