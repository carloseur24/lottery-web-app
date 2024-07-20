<script setup>
defineProps({
    name: String,
    icon: String,
    balance: String,
    selected: Boolean,
});

const emit = defineEmits(['select']);
</script>

<template>
    <div class="flex items-center p-2 rounded-md hover:bg-gray-100" :class="{ 'bg-gray-200': selected }"
        @click="emit('select')">
        <!-- <img :src="icon" :alt="`${name} Icon`" class="h-6 w-6 mr-2" /> -->
        <div>
            <p class="font-semibold">{{ name }}</p>
            <p v-if="balance" class="text-sm text-gray-500">Balance: {{ balance }}</p>
        </div>
    </div>
    <Modal>
        <slot />
    </Modal>
</template>
