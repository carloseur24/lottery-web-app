import { io } from "socket.io-client";

// Create a socket instance connecting to your Node.js backend
const socket = io('http://localhost:4000', {
    transports: ['websocket'], // Use WebSocket as the transport protocol
});

export default socket;
