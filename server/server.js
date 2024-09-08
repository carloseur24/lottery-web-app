const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const cors = require('cors');

const app = express();
app.use(cors()); // Enable CORS for all routes

const server = http.createServer(app);
const io = socketIo(server, {
    cors: {
        origin: '*', // Allow all origins (or specify your Vue.js app's origin, like 'http://localhost:8080')
        methods: ['GET', 'POST']
    }
});

// Animation data and interval setup
let animationData = {
    x: 0,
    y: 0,
    dx: 2, // Movement in x direction
    dy: 2  // Movement in y direction
};
let animationInterval = null;

io.on('connection', (socket) => {
    console.log('New client connected');

    // Send initial animation data to the client
    socket.emit('updateFrame', animationData);

    // Start the animation
    socket.on('startAnimation', () => {
        console.log('Starting animation In console');
        if (!animationInterval) {
            animationInterval = setInterval(() => {
                animationData.x += animationData.dx;
                animationData.y += animationData.dy;

                // Bounce off edges
                if (animationData.x > 480 || animationData.x < 0) animationData.dx *= -1;
                if (animationData.y > 480 || animationData.y < 0) animationData.dy *= -1;

                io.emit('updateFrame', animationData); // Broadcast frame data to all clients
            }, 16); // ~60 FPS
        }
    });

    // Stop the animation
    socket.on('stopAnimation', () => {
        console.log('Stopping animation');
        if (animationInterval) {
            clearInterval(animationInterval);
            animationInterval = null;
        }
        io.emit('stopAnimation'); // Notify all clients to stop the animation
    });

    // Handle other messages
    socket.on('message', (message) => {
        console.log('Message received:', message);
        io.emit('message', message); // Broadcast the message to all connected clients
    });

    socket.on('disconnect', () => {
        console.log('Client disconnected');
    });
});

server.listen(4000, () => {
    console.log('Server is running on port 4000');
});
