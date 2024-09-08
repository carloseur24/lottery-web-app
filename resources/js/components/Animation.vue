<template>
    <div class="bg-yellow-500 p-6 rounded-lg shadow-lg my-8 sm:my-12 md:my-16 lg:my-20">
        Animations
        <canvas ref="canvas" id="animationCanvas" width="500" height="500"
            :style="{ display: isAnimating ? 'block' : 'none' }"></canvas>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import io from 'socket.io-client';

// Setup for socket connection
const socket = io('http://localhost:4000', {
    transports: ['websocket'], // Ensure WebSocket transport
});

// Canvas and context
const canvas = ref(null);
const context = ref(null);
const isAnimating = ref(false);

// Initialize the canvas context
const setupCanvas = () => {
    if (canvas.value) {
        context.value = canvas.value.getContext('2d');
    }
};

// Handle incoming animation frames
const updateFrame = (frameData) => {
    if (context.value) {
        context.value.clearRect(0, 0, canvas.value.width, canvas.value.height);
        context.value.fillStyle = 'blue';
        context.value.fillRect(frameData.x, frameData.y, 50, 50);
        console.log('Frame updated:', frameData);
    }
};

// Handle animation start
const startAnimation = () => {
    isAnimating.value = true;
    console.log('Animation started But not working');
};

// Handle animation stop
const stopAnimation = () => {
    isAnimating.value = false;
    console.log('Animation stopped');
};

// Listen for server events
onMounted(() => {
    setupCanvas();
    startAnimation();
    socket.on('updateFrame', updateFrame);
    socket.emit('startAnimation', startAnimation);
    socket.on('stopAnimation', stopAnimation);

    // Start the animation initially
});
</script>
