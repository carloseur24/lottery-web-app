<script setup>
import { nextTick } from "vue";

const props = defineProps({
    name: String,
    icon: String,
    selected: Boolean,
    payment: {
        type: String,
        default: '', // Provide a default empty string
    },
});

// const emit = defineEmits(['select', 'open-modal']);
const emit = defineEmits(['open-modal']);

const selectAndOpenModal = async () => {
    try {
        await nextTick();
        // Check if props.payment exists and is a string
        if (typeof props.payment === 'string') {
            emit('open-modal', props.payment.toString());
        } else {
            console.error('Invalid payment type:', props.payment);
        }
    } catch (error) {
        console.error('Error in selectAndOpenModal:', error);
    }
};
</script>

<template>
    <div class="flex items-center p-2 rounded-md hover:bg-gray-100" :class="{ 'bg-gray-200': selected }"
        @click="selectAndOpenModal">
        <span :class="'' + icon" />
        <div>
            <p class="font-semibold">{{ name }}</p>
        </div>
    </div>
</template>
