<script setup>

const emit = defineEmits(['close']);

</script>

<template>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 right-0 w-full h-full z-50 bg-[#000000b0] p-4 pt-32"
        @click.self="emit('close')">
        <slot></slot>
    </div>
</template>
