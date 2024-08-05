<script setup>

const props = defineProps({
    saldoValue: {
        type: Number,
        default: 0
    }
})

</script>

<template>

    <div class="fixed top-0 left-0 right-0 bg-slate-700 p-4 flex justify-around">
        <button class="text-white text-sm">span</button>
        <div class="text-white text-sm p-2 px-4 bg-blue-400 rounded-md">saldo: Bs. {{ props.saldoValue }}</div>
        <button class="text-white text-sm">span</button>
    </div>

</template>
